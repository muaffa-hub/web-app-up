<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsTampilToProducts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('products', [
            'is_tampil' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 1,
                'after'      => 'stok',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'is_tampil');
    }
}
