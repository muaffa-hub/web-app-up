<?php

namespace App\Models;

use CodeIgniter\Model;

class PrintOrderModel extends Model
{
    protected $table         = 'print_orders';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'order_id', 'file_path', 'jenis_kertas', 'warna_opsi',
        'jumlah_halaman', 'jumlah_halaman_terverifikasi', 'total_copy', 'bolak_balik', 'total_harga',
    ];

    public function getByOrder(int $orderId): ?array
    {
        return $this->where('order_id', $orderId)->first();
    }

    public function getFinishedForCleanup(): array
    {
        return $this->db->table('print_orders po')
            ->select('po.*')
            ->join('orders o', 'o.id = po.order_id', 'left')
            ->where('o.status_pesanan', 'selesai')
            ->where('o.updated_at <', date('Y-m-d H:i:s', strtotime('-72 hours')))
            ->where('po.file_path IS NOT NULL')
            ->get()->getResultArray();
    }
}
