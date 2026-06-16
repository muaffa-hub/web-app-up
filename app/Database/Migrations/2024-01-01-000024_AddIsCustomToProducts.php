<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsCustomToProducts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('products', [
            'is_custom' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'is_tampil',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'is_custom');
    }
}
