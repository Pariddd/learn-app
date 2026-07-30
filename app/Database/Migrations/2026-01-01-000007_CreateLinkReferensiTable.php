<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLinkReferensiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'video_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jenis_link_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'judul' => ['type' => 'VARCHAR', 'constraint' => 150],
            'url' => ['type' => 'VARCHAR', 'constraint' => 255],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('video_id', 'videos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('jenis_link_id', 'jenis_link', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('link_referensi');
    }

    public function down()
    {
        $this->forge->dropTable('link_referensi');
    }
}
