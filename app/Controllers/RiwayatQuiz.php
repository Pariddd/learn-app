<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HasilQuizRoleModel;

class RiwayatQuiz extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $model = new HasilQuizRoleModel();
        $riwayatRaw = $model->getRiwayatByUser($userId);

        $riwayat = array_map(fn($r) => (object) [
            'tanggal' => $r->dikerjakan_at,
            'nama_role_rekomendasi' => $r->nama_role_rekomendasi,
            'skor_similarity' => round((float) $r->skor_similarity * 100, 2), // sudah dalam format persen
        ], $riwayatRaw);

        return view('riwayat_quiz/index', ['riwayat' => $riwayat]);
    }
}
