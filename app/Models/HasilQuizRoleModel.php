<?php

namespace App\Models;

use CodeIgniter\Model;

class HasilQuizRoleModel extends Model
{
    protected $table = 'hasil_quiz_role';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'user_id', 'vektor_profil', 'skor_semua_role', 'role_direkomendasikan',
        'skor_similarity', 'dikerjakan_at',
    ];

    public function getRiwayatByUser(int $userId): array
    {
        return $this->select('hasil_quiz_role.dikerjakan_at, hasil_quiz_role.skor_similarity, roles_spesialisasi.nama_role as nama_role_rekomendasi')
            ->join('roles_spesialisasi', 'roles_spesialisasi.id = hasil_quiz_role.role_direkomendasikan')
            ->where('user_id', $userId)
            ->orderBy('dikerjakan_at', 'DESC')
            ->findAll();
    }

    public function getLastResult(int $userId)
    {
        return $this->select('hasil_quiz_role.*, roles_spesialisasi.nama_role as nama_role_rekomendasi')
            ->join('roles_spesialisasi', 'roles_spesialisasi.id = hasil_quiz_role.role_direkomendasikan')
            ->where('user_id', $userId)
            ->orderBy('dikerjakan_at', 'DESC')
            ->first();
    }
}
