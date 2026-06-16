<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCouponUsagesTable extends Migration
{
    public function up(): void
    {
        $this->db->query('CREATE TABLE coupon_usages (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            coupon_id INT UNSIGNED NOT NULL,
            user_id INT UNSIGNED NOT NULL,
            order_id INT UNSIGNED NOT NULL,
            used_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (coupon_id) REFERENCES coupons(id) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE ON UPDATE CASCADE,
            UNIQUE KEY uq_usage (coupon_id, user_id)
        ) ENGINE=InnoDB CHARSET=utf8mb4');
    }

    public function down(): void
    {
        $this->db->query('DROP TABLE IF EXISTS coupon_usages');
    }
}
