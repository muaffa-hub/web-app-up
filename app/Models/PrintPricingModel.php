<?php

namespace App\Models;

use CodeIgniter\Model;

class PrintPricingModel extends Model
{
    protected $table         = 'print_pricing';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = ['jenis_kertas', 'warna_opsi', 'harga_per_halaman'];

    public function getPrice(string $jenisKertas, string $warnaOpsi): float
    {
        $row = $this->where('jenis_kertas', $jenisKertas)->where('warna_opsi', $warnaOpsi)->first();
        return $row ? (float)$row['harga_per_halaman'] : 0;
    }

    public function getAllGrouped(): array
    {
        $rows = $this->findAll();
        $grouped = [];
        foreach ($rows as $row) {
            $grouped[$row['jenis_kertas']][$row['warna_opsi']] = $row['harga_per_halaman'];
        }
        return $grouped;
    }
}
