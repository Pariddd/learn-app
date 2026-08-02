<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HasilQuizRoleModel;
use App\Models\ProgressVideoModel;
use App\Models\UserRoleProgressModel;
use App\Models\VideoModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');

        $videoModel = new VideoModel();
        $progressModel = new ProgressVideoModel();
        $userRoleModel = new UserRoleProgressModel();
        $hasilModel = new HasilQuizRoleModel();

        $basicVideoIds = array_map(fn($v) => $v->id, $videoModel->getBasicVideos());
        $basicSelesai = $progressModel->isBasicCourseComplete($userId, $basicVideoIds);

        $rolesAktifRaw = $userRoleModel->getLearningPaths($userId);
        $rolesAktif = array_map(fn($r) => (object) [
            'nama_role' => $r['nama_role'],
            'progress_percentage' => round((float) $r['progress_percentage'], 1),
        ], $rolesAktifRaw);

        $lastQuiz = $hasilModel->getLastResult($userId);

        return view('dashboard/index', [
            'basic_selesai' => $basicSelesai,
            'roles_aktif' => $rolesAktif,
            'last_quiz_result' => $lastQuiz,
        ]);
    }
}
