<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\NotificationModel;

class OrderAdminController extends BaseController
{
    public function index()
    {
        $filters = [
            'status' => $this->request->getGet('status'),
            'tipe'   => $this->request->getGet('tipe'),
            'search' => $this->request->getGet('q'),
        ];

        return view('admin/orders', [
            'orders'  => (new OrderModel())->getAll($filters),
            'filters' => $filters,
        ]);
    }

    public function detail(int $id)
    {
        $order = (new OrderModel())->getDetailWithItems($id);
        if (!$order) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        return view('admin/order_detail', ['order' => $order]);
    }

    public function updateStatus(int $id)
    {
        $orderModel = new OrderModel();
        $order      = $orderModel->find($id);

        if (!$order) {
            session()->setFlashdata('error', 'Pesanan tidak ditemukan.');
            return redirect()->to('/admin/orders');
        }

        $newStatus = $this->request->getPost('status_pesanan');
        $allowed   = ['pending', 'diproses', 'selesai', 'dibatalkan'];

        if (!in_array($newStatus, $allowed)) {
            session()->setFlashdata('error', 'Status tidak valid.');
            return redirect()->to('/admin/orders/' . $id);
        }

        if ($newStatus === 'dibatalkan' && $order['status_pesanan'] !== 'dibatalkan') {
            $this->cancelOrderWithRefund($id, $order);
        } else {
            $orderModel->update($id, ['status_pesanan' => $newStatus]);
        }

        $notifModel = new NotificationModel();
        $notifModel->notifyUser(
            $order['user_id'],
            $id,
            'Status pesanan #' . $order['invoice_code'] . ' diperbarui menjadi: ' . ucfirst($newStatus)
        );

        $this->sendStatusEmail($order, $newStatus);

        session()->setFlashdata('success', 'Status pesanan berhasil diperbarui.');
        return redirect()->to('/admin/orders/' . $id);
    }

    private function cancelOrderWithRefund(int $orderId, array $order): void
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $db->query("UPDATE orders SET status_pesanan='dibatalkan' WHERE id=?", [$orderId]);

        $items = $db->table('order_items')->where('order_id', $orderId)->get()->getResultArray();
        foreach ($items as $item) {
            $db->query('UPDATE products SET stok = stok + ? WHERE id = ?', [$item['qty'], $item['product_id']]);
        }

        if ($order['coupon_id']) {
            $db->query('UPDATE coupons SET sisa_kuota = sisa_kuota + 1 WHERE id = ?', [$order['coupon_id']]);
            $db->table('coupon_usages')->where('order_id', $orderId)->delete();
        }

        if ($order['tipe_pesanan'] === 'print') {
            $printOrder = $db->table('print_orders')->where('order_id', $orderId)->get()->getRowArray();
            if ($printOrder && $printOrder['file_path']) {
                $filePath = WRITEPATH . 'uploads/documents/' . basename($printOrder['file_path']);
                if (file_exists($filePath)) {
                    if (!@unlink($filePath)) {
                        log_message('error', 'Failed to unlink print file: ' . $filePath);
                    }
                }
            }
        }

        $db->transComplete();
    }

    private function sendStatusEmail(array $order, string $newStatus): void
    {
        try {
            $emailService = service('email');
            $emailService->setTo($order['email_customer'] ?? '');
            $emailService->setSubject('Update Status Pesanan - ' . $order['invoice_code']);
            $emailService->setMessage(view('emails/order_status', [
                'order'     => $order,
                'newStatus' => $newStatus,
            ]));
            $emailService->setMailType('html');
            $emailService->send();
        } catch (\Exception $e) {
            log_message('error', 'Status email error: ' . $e->getMessage());
        }
    }
}
