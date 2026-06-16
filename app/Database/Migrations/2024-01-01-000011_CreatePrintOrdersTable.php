<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrintOrdersTable extends Migration
{
    public function up(): void
    {
        $this->db->query('CREATE TABLE print_orders (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            order_id INT UNSIGNED NOT NULL,
            file_path VARCHAR(300) NOT NULL,
            jenis_kertas VARCHAR(50) NOT NULL,
            warna_opsi ENUM(\'berwarna\',\'hitam_putih\') NOT NULL,
            jumlah_halaman INT NOT NULL,
            jumlah_halaman_terverifikasi INT NULL DEFAULT NULL,
            total_copy INT NOT NULL DEFAULT 1,
            total_harga DECIMAL(12,2) NOT NULL,
            FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB CHARSET=utf8mb4');
    }

    public function down(): void
    {
        $this->db->query('DROP TABLE IF EXISTS print_orders');
    }
}
