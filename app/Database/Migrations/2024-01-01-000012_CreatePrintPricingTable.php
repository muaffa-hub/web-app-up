<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrintPricingTable extends Migration
{
    public function up(): void
    {
        $this->db->query('CREATE TABLE print_pricing (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            jenis_kertas VARCHAR(50) NOT NULL,
            warna_opsi ENUM(\'berwarna\',\'hitam_putih\') NOT NULL,
            harga_per_halaman DECIMAL(10,2) NOT NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY uq_pricing (jenis_kertas, warna_opsi)
        ) ENGINE=InnoDB CHARSET=utf8mb4');
    }

    public function down(): void
    {
        $this->db->query('DROP TABLE IF EXISTS print_pricing');
    }
}
