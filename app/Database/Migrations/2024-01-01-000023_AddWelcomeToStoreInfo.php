<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWelcomeToStoreInfo extends Migration
{
    public function up()
    {
        $this->forge->addColumn('store_info', [
            'welcome_enabled' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'after' => 'maintenance_print_msg'],
            'welcome_title'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'welcome_enabled'],
            'welcome_message' => ['type' => 'TEXT', 'null' => true, 'after' => 'welcome_title'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('store_info', ['welcome_enabled', 'welcome_title', 'welcome_message']);
    }
}
