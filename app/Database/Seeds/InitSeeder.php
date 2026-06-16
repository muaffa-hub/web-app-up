<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitSeeder extends Seeder
{
    public function run(): void
    {
        $adminExists = $this->db->table('users')->where('email', 'admin@up.sekolah.com')->countAllResults() > 0;
        if (! $adminExists) {
            $this->db->table('users')->insert([
                'nama'              => 'Admin UP',
                'email'             => 'admin@up.sekolah.com',
                'password'          => password_hash('password', PASSWORD_DEFAULT),
                'role'              => 'admin',
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ]);
        }

        if ($this->db->table('print_pricing')->countAllResults() === 0) {
        $pricingData = [
            ['jenis_kertas' => 'HVS 70gr', 'warna_opsi' => 'hitam_putih', 'harga_per_halaman' => 500],
            ['jenis_kertas' => 'HVS 70gr', 'warna_opsi' => 'berwarna',    'harga_per_halaman' => 1500],
            ['jenis_kertas' => 'A4',       'warna_opsi' => 'hitam_putih', 'harga_per_halaman' => 500],
            ['jenis_kertas' => 'A4',       'warna_opsi' => 'berwarna',    'harga_per_halaman' => 1500],
            ['jenis_kertas' => 'F4',       'warna_opsi' => 'hitam_putih', 'harga_per_halaman' => 600],
            ['jenis_kertas' => 'F4',       'warna_opsi' => 'berwarna',    'harga_per_halaman' => 1800],
            ['jenis_kertas' => 'Glossy',   'warna_opsi' => 'hitam_putih', 'harga_per_halaman' => 1000],
            ['jenis_kertas' => 'Glossy',   'warna_opsi' => 'berwarna',    'harga_per_halaman' => 3000],
        ];

        foreach ($pricingData as $item) {
            $this->db->table('print_pricing')->insert($item);
        }
        }

        $kategoriExists = $this->db->table('categories')->where('slug', 'umum')->countAllResults() > 0;
        if (! $kategoriExists) {
            $this->db->table('categories')->insert([
                'nama_kategori' => 'Umum',
                'slug'          => 'umum',
                'is_active'     => 1,
            ]);
        }
    }
}
