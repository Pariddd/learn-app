<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProgressVideoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'video_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'watch_percentage' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0],
            'status' => ['type' => 'ENUM', 'constraint' => ['belum', 'sedang', 'selesai'], 'default' => 'belum'],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        // Satu user hanya punya satu baris progress per video (dipakai untuk UPSERT saat tracking)
        $this->forge->addUniqueKey(['user_id', 'video_id']);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('video_id', 'videos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('progress_video');
    }

    public function down()
    {
        $this->forge->dropTable('progress_video');
    }
}
