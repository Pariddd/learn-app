<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HasilQuizRoleModel;
use App\Models\ProgressVideoModel;
use App\Models\RoleSpesialisasiModel;
use App\Models\UserRoleProgressModel;
use App\Models\VideoModel;

class Role extends BaseController
{
    public function jelajahi()
    {
        $userId = session()->get('user_id');
        $roleModel = new RoleSpesialisasiModel();
        $hasilModel = new HasilQuizRoleModel();

        $roles = $roleModel->findAll();
        $lastQuiz = $hasilModel->getLastResult($userId);

        $skorMap = [];
        $hasQuiz = false;
        if ($lastQuiz) {
            $hasQuiz = true;
            $skorSemua = json_decode($lastQuiz->skor_semua_role, true) ?? [];
            foreach ($skorSemua as $roleId => $skor) {
                $skorMap[$roleId] = round($skor * 100, 1);
            }
        }

        $result = array_map(function ($r) use ($skorMap) {
            return (object) [
                'id' => $r->id,
                'nama_role' => $r->nama_role,
                'deskripsi' => $r->deskripsi,
                'thumbnail' => $r->thumbnail,
                'match_percentage' => $skorMap[$r->id] ?? null,
            ];
        }, $roles);

        return view('role/jelajahi', ['roles' => $result, 'has_quiz' => $hasQuiz]);
    }

    public function roadmap(int $roleId)
    {
        $userId = session()->get('user_id');
        $roleModel = new RoleSpesialisasiModel();
        $videoModel = new VideoModel();
        $progressModel = new ProgressVideoModel();
        $userRoleModel = new UserRoleProgressModel();

        $role = $roleModel->find($roleId);
        if (!$role) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Klik masuk roadmap otomatis mengaktifkan role sebagai "sedang dijalani"
        // via jalur manual (jika belum aktif dari quiz sebelumnya) - kecuali admin,
        // yang cuma preview konten, bukan benar-benar menjalani role
        if (session()->get('role') !== 'admin') {
            $userRoleModel->activateRole($userId, $roleId, 'manual');
        }

        $basicVideoIds = array_map(fn($v) => $v->id, $videoModel->getBasicVideos());
        $basicSelesai = $progressModel->isBasicCourseComplete($userId, $basicVideoIds);
        $isAdmin = session()->get('role') === 'admin';

        $videos = $videoModel->getVideosByRole($roleId);
        $result = array_map(function ($v) use ($basicSelesai, $isAdmin) {
            return (object) [
                'id' => $v->id,
                'judul' => $v->judul,
                'thumbnail' => $v->thumbnail,
                'urutan' => $v->urutan,
                'is_locked' => !$basicSelesai && !$isAdmin,
            ];
        }, $videos);

        return view('role/roadmap', ['role' => $role, 'videos' => $result]);
    }
}
