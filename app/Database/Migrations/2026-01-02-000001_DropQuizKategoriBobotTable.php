<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropQuizKategoriBobotTable extends Migration
{
    public function up()
    {
        $this->forge->dropTable('quiz_kategori_bobot', true);
    }

    public function down()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'quiz_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'kategori_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'bobot' => ['type' => 'DECIMAL', 'constraint' => '3,2'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['quiz_id', 'kategori_id']);
        $this->forge->addForeignKey('quiz_id', 'quiz_penentuan_role', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kategori_id', 'kategori_minat', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('quiz_kategori_bobot');
    }
}
