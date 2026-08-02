<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJawabanQuizTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'quiz_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'teks_jawaban' => ['type' => 'VARCHAR', 'constraint' => 255],
            'urutan' => ['type' => 'TINYINT', 'constraint' => 2, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('quiz_id', 'quiz_penentuan_role', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jawaban_quiz');
    }

    public function down()
    {
        $this->forge->dropTable('jawaban_quiz');
    }
}
