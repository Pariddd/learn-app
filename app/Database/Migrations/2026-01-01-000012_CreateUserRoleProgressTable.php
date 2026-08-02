<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserRoleProgressTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'role_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'sumber' => ['type' => 'ENUM', 'constraint' => ['quiz', 'manual']],
            'started_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['user_id', 'role_id']);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('role_id', 'roles_spesialisasi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_role_progress');
    }

    public function down()
    {
        $this->forge->dropTable('user_role_progress');
    }
}
