<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $distribusiRole = $db->query("
            SELECT rs.nama_role, COUNT(urp.id) as jumlah_user
            FROM roles_spesialisasi rs
            LEFT JOIN user_role_progress urp ON urp.role_id = rs.id
            GROUP BY rs.id, rs.nama_role
            ORDER BY jumlah_user DESC
        ")->getResultArray();

        $rataSkor = $db->query("
            SELECT AVG(skor_similarity) as rata_rata
            FROM hasil_quiz_role
        ")->getRowArray();

        $totalUser = $db->table('users')->where('role', 'user')->countAllResults();
        $totalQuizDikerjakan = $db->table('hasil_quiz_role')->countAllResults();

        return view('admin/dashboard/index', [
            'distribusi_role' => $distribusiRole,
            'rata_skor_similarity' => round((float) ($rataSkor['rata_rata'] ?? 0) * 100, 2),
            'total_user' => $totalUser,
            'total_quiz_dikerjakan' => $totalQuizDikerjakan,
        ]);
    }
}
