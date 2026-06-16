<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCouponsTable extends Migration
{
    public function up(): void
    {
        $this->db->query('CREATE TABLE coupons (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            kode_kupon VARCHAR(50) NOT NULL UNIQUE,
            tipe ENUM(\'persen\',\'nominal\') NOT NULL,
            potongan DECIMAL(12,2) NOT NULL,
            kuota INT NOT NULL DEFAULT 1,
            sisa_kuota INT NOT NULL DEFAULT 1,
            expired_at DATETIME NOT NULL,
            INDEX idx_kode (kode_kupon)
        ) ENGINE=InnoDB CHARSET=utf8mb4');
    }

    public function down(): void
    {
        $this->db->query('DROP TABLE IF EXISTS coupons');
    }
}
