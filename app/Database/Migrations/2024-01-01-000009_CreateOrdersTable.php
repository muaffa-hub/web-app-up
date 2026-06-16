<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
{
    public function up(): void
    {
        $this->db->query('CREATE TABLE orders (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            invoice_code VARCHAR(30) NOT NULL UNIQUE,
            user_id INT UNSIGNED NOT NULL,
            coupon_id INT UNSIGNED NULL DEFAULT NULL,
            total_bayar DECIMAL(12,2) NOT NULL DEFAULT 0,
            diskon_kupon DECIMAL(12,2) NOT NULL DEFAULT 0,
            status_pesanan ENUM(\'pending\',\'diproses\',\'selesai\',\'dibatalkan\') NOT NULL DEFAULT \'pending\',
            tipe_pesanan ENUM(\'produk\',\'print\') NOT NULL,
            catatan TEXT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (coupon_id) REFERENCES coupons(id) ON DELETE SET NULL ON UPDATE CASCADE,
            INDEX idx_user (user_id),
            INDEX idx_status (status_pesanan),
            INDEX idx_invoice (invoice_code)
        ) ENGINE=InnoDB CHARSET=utf8mb4');
    }

    public function down(): void
    {
        $this->db->query('DROP TABLE IF EXISTS orders');
    }
}
