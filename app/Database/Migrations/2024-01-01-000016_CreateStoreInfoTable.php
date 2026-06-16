<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStoreInfoTable extends Migration
{
    public function up(): void
    {
        $this->db->query('CREATE TABLE store_info (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            jam_operasional VARCHAR(200) NOT NULL DEFAULT \'Senin-Jumat 08:00-15:00\',
            lokasi VARCHAR(300) NOT NULL DEFAULT \'Ruang Unit Produksi\',
            no_whatsapp VARCHAR(20) NOT NULL DEFAULT \'\',
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB CHARSET=utf8mb4');

        $this->db->query("INSERT INTO store_info (jam_operasional, lokasi, no_whatsapp) VALUES ('Senin-Jumat 08:00-15:00', 'Ruang Unit Produksi Sekolah', '08123456789')");
    }

    public function down(): void
    {
        $this->db->query('DROP TABLE IF EXISTS store_info');
    }
}
