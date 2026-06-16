<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\OrderModel;

class CancelExpiredOrders extends BaseCommand
{
    protected $group       = 'UP';
    protected $name        = 'cancel:expired-orders';
    protected $description = 'Auto-cancel pesanan pending yang melewati 24 jam.';

    public function run(array $params): void
    {
        $db        = \Config\Database::connect();
        $orderModel = new OrderModel();
        $orders    = $orderModel->getPendingExpired();

        if (empty($orders)) {
            CLI::write('Tidak ada pesanan yang perlu dibatalkan.', 'green');
            return;
        }

        $cancelled = 0;

        foreach ($orders as $order) {
            $db->transStart();

            try {
                $db->query("UPDATE orders SET status_pesanan='dibatalkan' WHERE id=?", [$order['id']]);

                $items = $db->table('order_items')->where('order_id', $order['id'])->get()->getResultArray();
                foreach ($items as $item) {
                    $db->query('UPDATE products SET stok = stok + ? WHERE id = ?', [$item['qty'], $item['product_id']]);
                }

                if ($order['coupon_id']) {
                    $db->query('UPDATE coupons SET sisa_kuota = sisa_kuota + 1 WHERE id = ?', [$order['coupon_id']]);
                    $db->table('coupon_usages')->where('order_id', $order['id'])->delete();
                }

                if ($order['tipe_pesanan'] === 'print') {
                    $printOrder = $db->table('print_orders')->where('order_id', $order['id'])->get()->getRowArray();
                    if ($printOrder && $printOrder['file_path']) {
                        $filePath = WRITEPATH . 'uploads/documents/' . basename($printOrder['file_path']);
                        if (file_exists($filePath)) {
                            if (!@unlink($filePath)) {
                                log_message('error', 'CancelExpiredOrders: gagal hapus file ' . $filePath);
                            }
                        }
                    }
                }

                $db->transComplete();

                if ($db->transStatus()) {
                    $this->sendCancellationEmail($order);
                    $cancelled++;
                    CLI::write('Dibatalkan: ' . $order['invoice_code'], 'yellow');
                }
            } catch (\Exception $e) {
                $db->transRollback();
                log_message('error', 'CancelExpiredOrders error for order ' . $order['id'] . ': ' . $e->getMessage());
            }
        }

        CLI::write("Selesai. Total dibatalkan: {$cancelled} pesanan.", 'green');
    }

    private function sendCancellationEmail(array $order): void
    {
        try {
            $emailService = service('email');
            $emailService->setTo($order['email_customer']);
            $emailService->setSubject('Pesanan Dibatalkan Otomatis - ' . $order['invoice_code']);
            $emailService->setMessage(view('emails/order_cancelled', ['order' => $order]));
            $emailService->setMailType('html');
            $emailService->send();
        } catch (\Exception $e) {
            log_message('error', 'CancelExpiredOrders email error: ' . $e->getMessage());
        }
    }
}
