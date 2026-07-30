<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVideosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'tipe' => ['type' => 'ENUM', 'constraint' => ['basic', 'intermediate']],
            'role_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'judul' => ['type' => 'VARCHAR', 'constraint' => 150],
            'deskripsi' => ['type' => 'TEXT', 'null' => true],
            'thumbnail' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'video_url' => ['type' => 'VARCHAR', 'constraint' => 255],
            'durasi_detik' => ['type' => 'INT', 'constraint' => 11],
            'urutan' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('role_id', 'roles_spesialisasi', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('videos');
    }

    public function down()
    {
        $this->forge->dropTable('videos');
    }
}
