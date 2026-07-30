<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolesSpesialisasiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_role' => ['type' => 'VARCHAR', 'constraint' => 50],
            'deskripsi' => ['type' => 'TEXT', 'null' => true],
            'thumbnail' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('roles_spesialisasi');
    }

    public function down()
    {
        $this->forge->dropTable('roles_spesialisasi');
    }
}
