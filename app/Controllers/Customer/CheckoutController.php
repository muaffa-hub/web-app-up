<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\CouponModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\NotificationModel;
use App\Models\ProductModel;

class CheckoutController extends BaseController
{
    public function index()
    {
        $userId    = session()->get('user_id');
        $cartModel = new CartModel();
        $items     = $cartModel->getCartWithProducts($userId);

        if (empty($items)) {
            session()->setFlashdata('error', 'Keranjang kamu kosong.');
            return redirect()->to('/customer/cart');
        }

        return view('customer/checkout', ['items' => $items]);
    }

    public function process()
    {
        $userId    = session()->get('user_id');
        $cartModel = new CartModel();
        $items     = $cartModel->getCartWithProducts($userId);

        if (empty($items)) {
            session()->setFlashdata('error', 'Keranjang kamu kosong.');
            return redirect()->to('/customer/cart');
        }

        $couponCode = $this->request->getPost('coupon_code');
        $catatan    = strip_tags($this->request->getPost('catatan') ?? '');
        $coupon     = null;
        $diskon     = 0;

        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['harga'] * $item['qty'];
        }

        if ($couponCode) {
            $result = (new CouponModel())->validateCoupon($couponCode, $userId, $subtotal);
            if (!$result['valid']) {
                session()->setFlashdata('error', $result['message']);
                return redirect()->to('/customer/checkout');
            }
            $coupon = $result['coupon'];
            $diskon = $result['diskon'];
        }

        $productIds = array_column($items, 'product_id');
        if ((new OrderModel())->hasPendingItem($userId, $productIds)) {
            session()->setFlashdata('warning', 'Kamu sudah punya pesanan serupa yang masih pending. Lanjutkan?');
            session()->set('checkout_confirm', true);

            if (!$this->request->getPost('confirm_duplicate')) {
                return view('customer/checkout_confirm', ['items' => $items, 'subtotal' => $subtotal, 'diskon' => $diskon, 'coupon' => $coupon, 'catatan' => $catatan]);
            }
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            foreach ($items as $item) {
                $row = $db->query('SELECT stok FROM products WHERE id = ? FOR UPDATE', [$item['product_id']])->getRowArray();
                if (!$row || $row['stok'] < $item['qty']) {
                    $db->transRollback();
                    session()->setFlashdata('error', 'Maaf, stok ' . esc($item['nama_produk']) . ' tidak mencukupi. Silakan perbarui keranjang kamu.');
                    return redirect()->to('/customer/cart');
                }
            }

            $orderModel = new OrderModel();
            $invoiceCode = $orderModel->generateInvoiceCode();
            $totalBayar  = $subtotal - $diskon;

            $orderId = $orderModel->insert([
                'invoice_code'   => $invoiceCode,
                'user_id'        => $userId,
                'coupon_id'      => $coupon ? $coupon['id'] : null,
                'total_bayar'    => $totalBayar,
                'diskon_kupon'   => $diskon,
                'status_pesanan' => 'pending',
                'tipe_pesanan'   => 'produk',
                'catatan'        => $catatan,
            ]);

            $orderItemModel = new OrderItemModel();
            foreach ($items as $item) {
                $orderItemModel->insert([
                    'order_id'      => $orderId,
                    'product_id'    => $item['product_id'],
                    'qty'           => $item['qty'],
                    'harga_satuan'  => $item['harga'],
                    'subtotal'      => $item['harga'] * $item['qty'],
                    'gambar_design' => $item['gambar_design'] ?? null,
                ]);
                $db->query('UPDATE products SET stok = stok - ? WHERE id = ?', [$item['qty'], $item['product_id']]);
            }

            if ($coupon) {
                $db->query('UPDATE coupons SET sisa_kuota = sisa_kuota - 1 WHERE id = ?', [$coupon['id']]);
                $db->table('coupon_usages')->insert([
                    'coupon_id' => $coupon['id'],
                    'user_id'   => $userId,
                    'order_id'  => $orderId,
                ]);
            }

            $db->table('carts')->where('user_id', $userId)->delete();

            $db->transComplete();

            if (!$db->transStatus()) {
                throw new \Exception('Transaction failed');
            }

            (new NotificationModel())->notifyAdmins($orderId, 'Pesanan baru masuk: ' . $invoiceCode);

            $this->sendOrderEmail($userId, $invoiceCode, $orderId);

            session()->setFlashdata('success', 'Pesanan berhasil dibuat! Invoice: ' . $invoiceCode);
            return redirect()->to('/order/' . $invoiceCode);
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Checkout error: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat proses checkout. Coba lagi.');
            return redirect()->to('/customer/checkout');
        }
    }

    public function applyCoupon()
    {
        $code     = $this->request->getPost('coupon_code');
        $subtotal = (float)$this->request->getPost('subtotal');
        $userId   = session()->get('user_id');

        $result = (new CouponModel())->validateCoupon($code, $userId, $subtotal);
        return $this->response->setJSON($result);
    }

    private function sendOrderEmail(int $userId, string $invoiceCode, int $orderId): void
    {
        try {
            $user = (new \App\Models\UserModel())->find($userId);
            $orderDetail = (new OrderModel())->getDetailWithItems($orderId);
            $emailService = service('email');
            $emailService->setTo($user['email']);
            $emailService->setSubject('Pesanan Diterima - ' . $invoiceCode);
            $emailService->setMessage(view('emails/order_created', ['order' => $orderDetail, 'invoiceUrl' => base_url('/order/' . $invoiceCode)]));
            $emailService->setMailType('html');
            $emailService->send();
        } catch (\Exception $e) {
            log_message('error', 'Order email error: ' . $e->getMessage());
        }
    }
}
