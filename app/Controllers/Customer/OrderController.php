<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\NotificationModel;
use App\Models\ReviewModel;

class OrderController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        return view('customer/orders', [
            'orders' => (new OrderModel())->getForCustomer($userId),
        ]);
    }

    public function detail(int $id)
    {
        $userId = session()->get('user_id');
        $order = (new OrderModel())->getDetailWithItems($id);

        if (!$order || $order['user_id'] !== $userId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('customer/order_detail', ['order' => $order]);
    }

    public function cancel(int $id)
    {
        $userId    = session()->get('user_id');
        $orderModel = new OrderModel();
        $order     = $orderModel->find($id);

        if (!$order || $order['user_id'] !== $userId) {
            session()->setFlashdata('error', 'Pesanan tidak ditemukan.');
            return redirect()->to('/customer/orders');
        }

        if ($order['status_pesanan'] !== 'pending') {
            session()->setFlashdata('error', 'Pesanan tidak bisa dibatalkan.');
            return redirect()->to('/customer/orders/' . $id);
        }

        $this->cancelOrderWithRefund($id, $order);

        session()->setFlashdata('success', 'Pesanan berhasil dibatalkan.');
        return redirect()->to('/customer/orders');
    }

    public function review(int $productId)
    {
        $userId = session()->get('user_id');

        $bought = $this->db->table('order_items oi')
            ->join('orders o', 'o.id = oi.order_id')
            ->where('oi.product_id', $productId)
            ->where('o.user_id', $userId)
            ->where('o.status_pesanan', 'selesai')
            ->countAllResults();

        if (!$bought) {
            session()->setFlashdata('error', 'Kamu hanya bisa ulasan produk yang sudah kamu beli.');
            return redirect()->to('/product/' . $productId);
        }

        $reviewModel = new ReviewModel();
        if ($reviewModel->hasReviewed($userId, $productId)) {
            session()->setFlashdata('error', 'Kamu sudah memberikan ulasan untuk produk ini.');
            return redirect()->to('/product/' . $productId);
        }

        $rating = (int)$this->request->getPost('rating');
        $ulasan = strip_tags($this->request->getPost('ulasan') ?? '');

        if ($rating < 1 || $rating > 5) {
            session()->setFlashdata('error', 'Rating harus antara 1 hingga 5.');
            return redirect()->to('/product/' . $productId);
        }

        $reviewModel->insert([
            'user_id'    => $userId,
            'product_id' => $productId,
            'rating'     => $rating,
            'ulasan'     => $ulasan,
        ]);

        session()->setFlashdata('success', 'Ulasan berhasil ditambahkan.');
        return redirect()->to('/product/' . $productId);
    }

    private function cancelOrderWithRefund(int $orderId, array $order): void
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
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
                        @unlink($filePath);
                    }
                }
            }

            $db->transComplete();

            (new NotificationModel())->notifyUser($order['user_id'], $orderId, 'Pesanan #' . $order['invoice_code'] . ' telah dibatalkan.');
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Cancel order error: ' . $e->getMessage());
        }
    }
}
