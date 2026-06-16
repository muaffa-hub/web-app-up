<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMaintenanceToStoreInfo extends Migration
{
    public function up()
    {
        $this->forge->addColumn('store_info', [
            'maintenance_website'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'after' => 'instagram'],
            'maintenance_website_msg' => ['type' => 'TEXT', 'null' => true, 'default' => null, 'after' => 'maintenance_website'],
            'maintenance_produk'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'after' => 'maintenance_website_msg'],
            'maintenance_produk_msg'  => ['type' => 'TEXT', 'null' => true, 'default' => null, 'after' => 'maintenance_produk'],
            'maintenance_print'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'after' => 'maintenance_produk_msg'],
            'maintenance_print_msg'   => ['type' => 'TEXT', 'null' => true, 'default' => null, 'after' => 'maintenance_print'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('store_info', [
            'maintenance_website', 'maintenance_website_msg',
            'maintenance_produk',  'maintenance_produk_msg',
            'maintenance_print',   'maintenance_print_msg',
        ]);
    }
}
