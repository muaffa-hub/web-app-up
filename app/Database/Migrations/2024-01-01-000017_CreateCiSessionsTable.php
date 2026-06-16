<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCiSessionsTable extends Migration
{
    public function up(): void
    {
        $this->db->query('CREATE TABLE ci_sessions (
            id VARCHAR(128) NOT NULL,
            ip_address VARCHAR(45) NOT NULL,
            timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            data BLOB NOT NULL,
            KEY ci_sessions_timestamp (timestamp)
        ) ENGINE=InnoDB CHARSET=utf8mb4');
    }

    public function down(): void
    {
        $this->db->query('DROP TABLE IF EXISTS ci_sessions');
    }
}
