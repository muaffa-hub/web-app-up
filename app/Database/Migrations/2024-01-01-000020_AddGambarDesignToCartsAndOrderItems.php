<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGambarDesignToCartsAndOrderItems extends Migration
{
    public function up()
    {
        $this->forge->addColumn('carts', [
            'gambar_design' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
                'after'      => 'qty',
            ],
        ]);

        $this->forge->addColumn('order_items', [
            'gambar_design' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
                'after'      => 'subtotal',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('carts', 'gambar_design');
        $this->forge->dropColumn('order_items', 'gambar_design');
    }
}
