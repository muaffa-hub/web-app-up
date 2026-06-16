<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\PrintOrderModel;
use App\Models\PrintPricingModel;
use App\Models\NotificationModel;

class PrintAdminController extends BaseController
{
    public function index()
    {
        $orders = $this->db->table('orders o')
            ->select('o.*, u.nama as nama_customer, po.jumlah_halaman, po.jumlah_halaman_terverifikasi, po.jenis_kertas')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->join('print_orders po', 'po.order_id = o.id', 'left')
            ->where('o.tipe_pesanan', 'print')
            ->orderBy('o.created_at', 'DESC')
            ->get()->getResultArray();

        return view('admin/print_orders', ['orders' => $orders]);
    }

    public function detail(int $id)
    {
        $order = (new OrderModel())->getDetailWithItems($id);
        if (!$order || $order['tipe_pesanan'] !== 'print') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('admin/print_order_detail', ['order' => $order]);
    }

    public function verify(int $orderId)
    {
        $jumlahTerverifikasi = (int)$this->request->getPost('jumlah_halaman_terverifikasi');

        if ($jumlahTerverifikasi < 1) {
            session()->setFlashdata('error', 'Jumlah halaman harus minimal 1.');
            return redirect()->to('/admin/print/' . $orderId);
        }

        $printOrderModel = new PrintOrderModel();
        $printOrder = $printOrderModel->getByOrder($orderId);

        if (!$printOrder) {
            session()->setFlashdata('error', 'Pesanan print tidak ditemukan.');
            return redirect()->to('/admin/print');
        }

        $order      = (new OrderModel())->find($orderId);
        $tarif      = (new PrintPricingModel())->getPrice($printOrder['jenis_kertas'], $printOrder['warna_opsi']);
        $efektifHal = !empty($printOrder['bolak_balik']) ? (int)ceil($jumlahTerverifikasi / 2) : $jumlahTerverifikasi;
        $newTotal   = $tarif * $efektifHal * $printOrder['total_copy'];

        $db = \Config\Database::connect();
        $db->transStart();

        $printOrderModel->update($printOrder['id'], [
            'jumlah_halaman_terverifikasi' => $jumlahTerverifikasi,
            'total_harga'                  => $newTotal,
        ]);

        (new OrderModel())->update($orderId, ['total_bayar' => $newTotal]);

        $db->transComplete();

        $this->sendVerificationEmail($order, $printOrder, $jumlahTerverifikasi, $newTotal);

        (new NotificationModel())->notifyUser(
            $order['user_id'],
            $orderId,
            'Ada penyesuaian harga pada pesanan ' . $order['invoice_code'] . '. Total terbaru: Rp ' . number_format($newTotal, 0, ',', '.')
        );

        session()->setFlashdata('success', 'Verifikasi halaman berhasil. Email notifikasi telah dikirim.');
        return redirect()->to('/admin/print/' . $orderId);
    }

    public function downloadFile(int $orderId)
    {
        $printOrder = (new PrintOrderModel())->getByOrder($orderId);

        if (!$printOrder || !$printOrder['file_path']) {
            session()->setFlashdata('error', 'File tidak ditemukan.');
            return redirect()->to('/admin/print/' . $orderId);
        }

        $filePath = WRITEPATH . 'uploads/documents/' . basename($printOrder['file_path']);
        if (!file_exists($filePath)) {
            session()->setFlashdata('error', 'File fisik tidak ditemukan di server.');
            return redirect()->to('/admin/print/' . $orderId);
        }

        return $this->response->download($filePath, null)->setFileName(basename($printOrder['file_path']));
    }

    private function sendVerificationEmail(array $order, array $printOrder, int $verified, float $newTotal): void
    {
        try {
            $user = (new \App\Models\UserModel())->find($order['user_id']);
            $emailService = service('email');
            $emailService->setTo($user['email']);
            $emailService->setSubject('Penyesuaian Harga Pesanan Print - ' . $order['invoice_code']);
            $emailService->setMessage(view('emails/print_verified', [
                'order'      => $order,
                'printOrder' => $printOrder,
                'verified'   => $verified,
                'newTotal'   => $newTotal,
            ]));
            $emailService->setMailType('html');
            $emailService->send();
        } catch (\Exception $e) {
            log_message('error', 'Print verify email error: ' . $e->getMessage());
        }
    }
}
