<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWishlistsTable extends Migration
{
    public function up(): void
    {
        $this->db->query('CREATE TABLE wishlists (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            product_id INT UNSIGNED NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE ON UPDATE CASCADE,
            UNIQUE KEY uq_wishlist (user_id, product_id)
        ) ENGINE=InnoDB CHARSET=utf8mb4');
    }

    public function down(): void
    {
        $this->db->query('DROP TABLE IF EXISTS wishlists');
    }
}
