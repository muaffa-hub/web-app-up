<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table         = 'reviews';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = ['user_id', 'product_id', 'rating', 'ulasan'];

    public function getByProduct(int $productId): array
    {
        return $this->db->table('reviews r')
            ->select('r.*, u.nama as nama_user')
            ->join('users u', 'u.id = r.user_id', 'left')
            ->where('r.product_id', $productId)
            ->orderBy('r.created_at', 'DESC')
            ->get()->getResultArray();
    }

    public function hasReviewed(int $userId, int $productId): bool
    {
        return $this->where('user_id', $userId)->where('product_id', $productId)->countAllResults() > 0;
    }
}
