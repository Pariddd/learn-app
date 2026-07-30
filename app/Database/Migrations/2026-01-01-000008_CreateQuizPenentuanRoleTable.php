<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuizPenentuanRoleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'pertanyaan' => ['type' => 'TEXT'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('quiz_penentuan_role');
    }

    public function down()
    {
        $this->forge->dropTable('quiz_penentuan_role');
    }
}
