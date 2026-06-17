<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDriveBackupToPrintOrders extends Migration
{
    public function up()
    {
        $this->forge->addColumn('print_orders', [
            'drive_file_id' => ['type' => 'VARCHAR', 'constraint' => 128, 'null' => true, 'after' => 'file_path'],
            'drive_url'     => ['type' => 'VARCHAR', 'constraint' => 512, 'null' => true, 'after' => 'drive_file_id'],
            'backed_up_at'  => ['type' => 'DATETIME', 'null' => true, 'after' => 'drive_url'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('print_orders', ['drive_file_id', 'drive_url', 'backed_up_at']);
    }
}
