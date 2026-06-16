<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table         = 'categories';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleted_at';
    protected $allowedFields = ['nama_kategori', 'slug', 'is_active'];

    public function getActive(): array
    {
        return $this->where('is_active', 1)->where('deleted_at IS NULL')->findAll();
    }

    public function generateSlug(string $name): string
    {
        $slug = url_title($name, '-', true);
        $original = $slug;
        $i = 1;
        while ($this->where('slug', $slug)->first()) {
            $slug = $original . '-' . $i++;
        }
        return $slug;
    }
}
