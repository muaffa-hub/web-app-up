<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBolakBalikToPrintOrders extends Migration
{
    public function up(): void
    {
        $this->db->query('ALTER TABLE print_orders ADD COLUMN bolak_balik TINYINT(1) NOT NULL DEFAULT 0 AFTER total_copy');
    }

    public function down(): void
    {
        $this->db->query('ALTER TABLE print_orders DROP COLUMN bolak_balik');
    }
}
