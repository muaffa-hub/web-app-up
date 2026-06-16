<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\PrintPricingModel;
use App\Models\PrintOrderModel;
use App\Models\OrderModel;
use App\Models\NotificationModel;

class PrintController extends BaseController
{
    public function index()
    {
        $pricingModel = new PrintPricingModel();
        return view('customer/print_order', [
            'pricing' => $pricingModel->getAllGrouped(),
            'pricingList' => $pricingModel->findAll(),
        ]);
    }

    public function countPages()
    {
        $file = $this->request->getFile('dokumen');
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['pages' => null]);
        }

        $ext   = strtolower($file->getClientExtension());
        $pages = null;

        if ($ext === 'docx') {
            $zip = new \ZipArchive();
            if ($zip->open($file->getTempName()) === true) {
                $xml = $zip->getFromName('docProps/app.xml');
                $zip->close();
                if ($xml && preg_match('/<Pages>(\d+)<\/Pages>/i', $xml, $m)) {
                    $pages = (int)$m[1];
                }
            }
        }

        return $this->response->setJSON(['pages' => $pages]);
    }

    public function calculate()
    {
        $jenisKertas = $this->request->getPost('jenis_kertas');
        $warnaOpsi   = $this->request->getPost('warna_opsi');
        $jumlahHal   = max(1, (int)$this->request->getPost('jumlah_halaman'));
        $jumlahCopy  = max(1, (int)$this->request->getPost('total_copy'));
        $bolakBalik  = (bool)$this->request->getPost('bolak_balik');

        $tarif       = (new PrintPricingModel())->getPrice($jenisKertas, $warnaOpsi);
        $efektifHal  = $bolakBalik ? (int)ceil($jumlahHal / 2) : $jumlahHal;
        $total       = $tarif * $efektifHal * $jumlahCopy;

        return $this->response->setJSON([
            'tarif'           => $tarif,
            'efektif_halaman' => $efektifHal,
            'total'           => $total,
            'total_formatted' => 'Rp ' . number_format($total, 0, ',', '.'),
        ]);
    }

    public function process()
    {
        $userId = session()->get('user_id');

        $rules = [
            'jenis_kertas'   => 'required',
            'warna_opsi'     => 'required|in_list[berwarna,hitam_putih]',
            'jumlah_halaman' => 'required|integer|greater_than[0]',
            'total_copy'     => 'required|integer|greater_than[0]',
            'dokumen'        => 'uploaded[dokumen]|max_size[dokumen,10240]|ext_in[dokumen,pdf,docx,xlsx]',
            'bolak_balik'    => 'permit_empty|in_list[0,1]',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to('/customer/print');
        }

        $file = $this->request->getFile('dokumen');
        $allowedMimes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

        if (!in_array($file->getMimeType(), $allowedMimes)) {
            session()->setFlashdata('error', 'Tipe file tidak diizinkan.');
            return redirect()->to('/customer/print');
        }

        $ext      = $file->getClientExtension();
        $newName  = bin2hex(random_bytes(16)) . '.' . $ext;
        $savePath = WRITEPATH . 'uploads/documents/';

        if (!$file->move($savePath, $newName)) {
            session()->setFlashdata('error', 'Gagal mengunggah file.');
            return redirect()->to('/customer/print');
        }

        $jenisKertas = $this->request->getPost('jenis_kertas');
        $warnaOpsi   = $this->request->getPost('warna_opsi');
        $jumlahHal   = (int)$this->request->getPost('jumlah_halaman');
        $jumlahCopy  = (int)$this->request->getPost('total_copy');
        $bolakBalik  = $this->request->getPost('bolak_balik') === '1' ? 1 : 0;
        $catatan     = strip_tags($this->request->getPost('catatan') ?? '');

        $tarif      = (new PrintPricingModel())->getPrice($jenisKertas, $warnaOpsi);
        $efektifHal = $bolakBalik ? (int)ceil($jumlahHal / 2) : $jumlahHal;
        $totalHarga = $tarif * $efektifHal * $jumlahCopy;

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $orderModel  = new OrderModel();
            $invoiceCode = $orderModel->generateInvoiceCode();

            $orderId = $orderModel->insert([
                'invoice_code'   => $invoiceCode,
                'user_id'        => $userId,
                'total_bayar'    => $totalHarga,
                'diskon_kupon'   => 0,
                'status_pesanan' => 'pending',
                'tipe_pesanan'   => 'print',
                'catatan'        => $catatan,
            ]);

            (new PrintOrderModel())->insert([
                'order_id'       => $orderId,
                'file_path'      => $newName,
                'jenis_kertas'   => $jenisKertas,
                'warna_opsi'     => $warnaOpsi,
                'jumlah_halaman' => $jumlahHal,
                'total_copy'     => $jumlahCopy,
                'bolak_balik'    => $bolakBalik,
                'total_harga'    => $totalHarga,
            ]);

            $db->transComplete();

            if (!$db->transStatus()) {
                throw new \Exception('Transaction failed');
            }

            (new NotificationModel())->notifyAdmins($orderId, 'Pesanan print baru: ' . $invoiceCode);

            session()->setFlashdata('success', 'Pesanan print berhasil dikirim! Invoice: ' . $invoiceCode);
            return redirect()->to('/order/' . $invoiceCode);
        } catch (\Exception $e) {
            $db->transRollback();
            @unlink($savePath . $newName);
            log_message('error', 'Print order error: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan. Coba lagi.');
            return redirect()->to('/customer/print');
        }
    }
}
