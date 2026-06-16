<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotificationsTable extends Migration
{
    public function up(): void
    {
        $this->db->query('CREATE TABLE notifications (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            order_id INT UNSIGNED NULL DEFAULT NULL,
            pesan TEXT NOT NULL,
            is_read BOOLEAN NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL ON UPDATE CASCADE,
            INDEX idx_user_unread (user_id, is_read)
        ) ENGINE=InnoDB CHARSET=utf8mb4');
    }

    public function down(): void
    {
        $this->db->query('DROP TABLE IF EXISTS notifications');
    }
}
