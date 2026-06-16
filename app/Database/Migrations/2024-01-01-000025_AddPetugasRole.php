<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPetugasRole extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE users MODIFY COLUMN role ENUM('admin','customer','petugas') NOT NULL DEFAULT 'customer'");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE users MODIFY COLUMN role ENUM('admin','customer') NOT NULL DEFAULT 'customer'");
    }
}
