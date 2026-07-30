<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHasilQuizRoleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'vektor_profil' => ['type' => 'JSON'],
            'skor_semua_role' => ['type' => 'JSON'],
            'role_direkomendasikan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'skor_similarity' => ['type' => 'DECIMAL', 'constraint' => '5,4'],
            'dikerjakan_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('role_direkomendasikan', 'roles_spesialisasi', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('hasil_quiz_role');
    }

    public function down()
    {
        $this->forge->dropTable('hasil_quiz_role');
    }
}
