<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRoleKategoriBobotTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'role_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'kategori_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'bobot' => ['type' => 'DECIMAL', 'constraint' => '3,2'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['role_id', 'kategori_id']);
        $this->forge->addForeignKey('role_id', 'roles_spesialisasi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kategori_id', 'kategori_minat', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('role_kategori_bobot');
    }

    public function down()
    {
        $this->forge->dropTable('role_kategori_bobot');
    }
}
