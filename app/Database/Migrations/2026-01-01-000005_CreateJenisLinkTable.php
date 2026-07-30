<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJenisLinkTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_jenis' => ['type' => 'VARCHAR', 'constraint' => 30],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('jenis_link');
    }

    public function down()
    {
        $this->forge->dropTable('jenis_link');
    }
}
