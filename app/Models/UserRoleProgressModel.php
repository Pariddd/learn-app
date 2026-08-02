<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRoleProgressModel extends Model
{
    protected $table = 'user_role_progress';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['user_id', 'role_id', 'sumber', 'started_at'];

    public function activateRole(int $userId, int $roleId, string $sumber): void
    {
        $existing = $this->where('user_id', $userId)->where('role_id', $roleId)->first();
        if (!$existing) {
            $this->insert([
                'user_id' => $userId,
                'role_id' => $roleId,
                'sumber' => $sumber,
                'started_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function getLearningPaths(int $userId): array
    {
        $db = \Config\Database::connect();

       
        $sql = "
            SELECT
                urp.role_id,
                rs.nama_role,
                urp.sumber,
                urp.started_at,
                COALESCE(AVG(COALESCE(pv.watch_percentage, 0)), 0) AS progress_percentage
            FROM user_role_progress urp
            JOIN roles_spesialisasi rs ON rs.id = urp.role_id
            LEFT JOIN videos v ON v.role_id = urp.role_id AND v.tipe = 'intermediate'
            LEFT JOIN progress_video pv ON pv.video_id = v.id AND pv.user_id = urp.user_id
            WHERE urp.user_id = ?
            GROUP BY urp.role_id, rs.nama_role, urp.sumber, urp.started_at
            ORDER BY urp.started_at DESC
        ";
        return $db->query($sql, [$userId])->getResultArray();
    }
}
