<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table         = 'orders';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'invoice_code', 'user_id', 'coupon_id', 'total_bayar',
        'diskon_kupon', 'status_pesanan', 'tipe_pesanan', 'catatan',
    ];

    public function getByInvoice(string $invoiceCode): ?array
    {
        return $this->where('invoice_code', $invoiceCode)->first();
    }

    public function getDetailWithItems(int $orderId): ?array
    {
        $order = $this->db->table('orders o')
            ->select('o.*, u.nama as nama_customer, u.email as email_customer,
                      u.no_whatsapp, c.kode_kupon')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->join('coupons c', 'c.id = o.coupon_id', 'left')
            ->where('o.id', $orderId)
            ->get()->getRowArray();

        if ($order) {
            $order['items'] = $this->db->table('order_items oi')
                ->select('oi.*, p.nama_produk, pi.file_path as foto')
                ->join('products p', 'p.id = oi.product_id', 'left')
                ->join('product_images pi', 'pi.product_id = p.id AND pi.urutan = 0', 'left')
                ->where('oi.order_id', $orderId)
                ->get()->getResultArray();

            $order['print_order'] = $this->db->table('print_orders')
                ->where('order_id', $orderId)
                ->get()->getRowArray();
        }

        return $order;
    }

    public function getForCustomer(int $userId): array
    {
        return $this->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();
    }

    public function getAll(array $filters = []): array
    {
        $builder = $this->db->table('orders o')
            ->select('o.*, u.nama as nama_customer, u.email as email_customer')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->orderBy('o.created_at', 'DESC');

        if (!empty($filters['status'])) {
            $builder->where('o.status_pesanan', $filters['status']);
        }

        if (!empty($filters['tipe'])) {
            $builder->where('o.tipe_pesanan', $filters['tipe']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('o.invoice_code', $filters['search'])
                ->orLike('u.nama', $filters['search'])
                ->orLike('u.email', $filters['search'])
                ->groupEnd();
        }

        return $builder->get()->getResultArray();
    }

    public function generateInvoiceCode(): string
    {
        do {
            $code = 'UP-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 4));
        } while ($this->where('invoice_code', $code)->countAllResults() > 0);

        return $code;
    }

    public function hasPendingItem(int $userId, array $productIds): bool
    {
        $orderIds = $this->db->table('orders')
            ->select('id')
            ->where('user_id', $userId)
            ->where('status_pesanan', 'pending')
            ->get()->getResultArray();

        if (empty($orderIds)) {
            return false;
        }

        $ids = array_column($orderIds, 'id');
        $count = $this->db->table('order_items')
            ->whereIn('order_id', $ids)
            ->whereIn('product_id', $productIds)
            ->countAllResults();

        return $count > 0;
    }

    public function getPendingExpired(): array
    {
        return $this->db->table('orders o')
            ->select('o.*, u.email as email_customer, u.nama as nama_customer')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->where('o.status_pesanan', 'pending')
            ->where('o.created_at <', date('Y-m-d H:i:s', strtotime('-24 hours')))
            ->get()->getResultArray();
    }
}
