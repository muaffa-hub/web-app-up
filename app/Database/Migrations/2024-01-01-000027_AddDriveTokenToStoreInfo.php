<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDriveTokenToStoreInfo extends Migration
{
    public function up()
    {
        $this->forge->addColumn('store_info', [
            'gdrive_refresh_token' => ['type' => 'TEXT', 'null' => true, 'after' => 'welcome_message'],
            'gdrive_email'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'gdrive_refresh_token'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('store_info', ['gdrive_refresh_token', 'gdrive_email']);
    }
}
