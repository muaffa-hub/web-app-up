<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table          = 'products';
    protected $primaryKey     = 'id';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted_at';
    protected $allowedFields  = [
        'category_id', 'nama_produk', 'deskripsi', 'harga', 'stok', 'is_tampil', 'is_custom',
    ];

    public function getWithCategory(?int $categoryId = null, ?string $search = null, ?string $sort = null, bool $onlyVisible = true): array
    {
        $builder = $this->db->table('products p')
            ->select('p.*, c.nama_kategori, pi.file_path as foto_utama,
                      COALESCE(AVG(r.rating),0) as avg_rating,
                      COUNT(r.id) as review_count')
            ->join('categories c', 'c.id = p.category_id', 'left')
            ->join('product_images pi', 'pi.product_id = p.id AND pi.urutan = 0', 'left')
            ->join('reviews r', 'r.product_id = p.id', 'left')
            ->where('p.deleted_at IS NULL')
            ->groupBy('p.id');

        if ($onlyVisible) {
            $builder->where('p.is_tampil', 1);
        }

        if ($categoryId) {
            $builder->where('p.category_id', $categoryId);
        }

        if ($search) {
            $builder->groupStart()
                ->like('p.nama_produk', $search)
                ->orLike('p.deskripsi', $search)
                ->groupEnd();
        }

        switch ($sort) {
            case 'harga_asc':
                $builder->orderBy('p.harga', 'ASC');
                break;
            case 'harga_desc':
                $builder->orderBy('p.harga', 'DESC');
                break;
            case 'rating':
                $builder->orderBy('avg_rating', 'DESC');
                break;
            default:
                $builder->orderBy('p.created_at', 'DESC');
        }

        return $builder->get()->getResultArray();
    }

    public function getDetailWithImages(int $id, bool $onlyVisible = true): ?array
    {
        $builder = $this->db->table('products p')
            ->select('p.*, c.nama_kategori, COALESCE(AVG(r.rating),0) as avg_rating, COUNT(r.id) as review_count')
            ->join('categories c', 'c.id = p.category_id', 'left')
            ->join('reviews r', 'r.product_id = p.id', 'left')
            ->where('p.id', $id)
            ->where('p.deleted_at IS NULL')
            ->groupBy('p.id');

        if ($onlyVisible) {
            $builder->where('p.is_tampil', 1);
        }

        $product = $builder->get()->getRowArray();

        if ($product) {
            $product['images'] = $this->db->table('product_images')
                ->where('product_id', $id)
                ->orderBy('urutan', 'ASC')
                ->get()->getResultArray();
        }

        return $product;
    }

    public function getLowStock(int $threshold = 5): array
    {
        return $this->where('stok <=', $threshold)->where('deleted_at IS NULL')->findAll();
    }

    public function getTopSelling(int $limit = 10): array
    {
        return $this->db->table('order_items oi')
            ->select('p.id, p.nama_produk, SUM(oi.qty) as total_terjual')
            ->join('products p', 'p.id = oi.product_id', 'left')
            ->join('orders o', 'o.id = oi.order_id', 'left')
            ->where('o.status_pesanan', 'selesai')
            ->where('p.deleted_at IS NULL')
            ->groupBy('p.id')
            ->orderBy('total_terjual', 'DESC')
            ->limit($limit)
            ->get()->getResultArray();
    }
}
