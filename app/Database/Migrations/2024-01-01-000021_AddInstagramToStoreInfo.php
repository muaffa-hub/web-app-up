<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddInstagramToStoreInfo extends Migration
{
    public function up()
    {
        $this->forge->addColumn('store_info', [
            'instagram' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'default'    => null,
                'after'      => 'no_whatsapp',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('store_info', 'instagram');
    }
}
