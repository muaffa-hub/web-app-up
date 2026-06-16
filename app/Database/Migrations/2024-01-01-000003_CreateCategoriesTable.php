<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoriesTable extends Migration
{
    public function up(): void
    {
        $this->db->query('CREATE TABLE categories (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nama_kategori VARCHAR(100) NOT NULL,
            slug VARCHAR(110) NOT NULL UNIQUE,
            is_active BOOLEAN NOT NULL DEFAULT 1,
            deleted_at TIMESTAMP NULL DEFAULT NULL
        ) ENGINE=InnoDB CHARSET=utf8mb4');
    }

    public function down(): void
    {
        $this->db->query('DROP TABLE IF EXISTS categories');
    }
}
