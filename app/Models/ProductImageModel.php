<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductImageModel extends Model
{
    protected $table         = 'product_images';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = ['product_id', 'file_path', 'urutan'];

    public function getByProduct(int $productId): array
    {
        return $this->where('product_id', $productId)->orderBy('urutan', 'ASC')->findAll();
    }

    public function getPrimary(int $productId): ?array
    {
        return $this->where('product_id', $productId)->orderBy('urutan', 'ASC')->first();
    }
}
