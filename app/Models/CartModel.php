<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table         = 'carts';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = ['user_id', 'product_id', 'qty', 'gambar_design'];

    public function getCartWithProducts(int $userId): array
    {
        return $this->db->table('carts c')
            ->select('c.id, c.qty, c.gambar_design, p.id as product_id, p.nama_produk, p.harga, p.stok,
                      pi.file_path as foto_utama')
            ->join('products p', 'p.id = c.product_id', 'left')
            ->join('product_images pi', 'pi.product_id = p.id AND pi.urutan = 0', 'left')
            ->where('c.user_id', $userId)
            ->where('p.deleted_at IS NULL')
            ->get()->getResultArray();
    }

    public function getItem(int $userId, int $productId): ?array
    {
        return $this->where('user_id', $userId)->where('product_id', $productId)->first();
    }

    public function mergeGuestCart(int $userId, array $guestCart): void
    {
        foreach ($guestCart as $item) {
            $existing = $this->getItem($userId, $item['product_id']);
            if ($existing) {
                $this->update($existing['id'], ['qty' => $existing['qty'] + $item['qty']]);
            } else {
                $this->insert(['user_id' => $userId, 'product_id' => $item['product_id'], 'qty' => $item['qty']]);
            }
        }
    }

    public function countItems(int $userId): int
    {
        return $this->where('user_id', $userId)->countAllResults();
    }
}
