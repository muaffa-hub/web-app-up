<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model
{
    protected $table         = 'wishlists';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $allowedFields = ['user_id', 'product_id'];

    public function getWithProducts(int $userId): array
    {
        return $this->db->table('wishlists w')
            ->select('w.id, p.id as product_id, p.nama_produk, p.harga, p.stok,
                      pi.file_path as foto_utama, COALESCE(AVG(r.rating),0) as avg_rating')
            ->join('products p', 'p.id = w.product_id', 'left')
            ->join('product_images pi', 'pi.product_id = p.id AND pi.urutan = 0', 'left')
            ->join('reviews r', 'r.product_id = p.id', 'left')
            ->where('w.user_id', $userId)
            ->where('p.deleted_at IS NULL')
            ->groupBy('w.id')
            ->get()->getResultArray();
    }

    public function isWishlisted(int $userId, int $productId): bool
    {
        return $this->where('user_id', $userId)->where('product_id', $productId)->countAllResults() > 0;
    }
}
