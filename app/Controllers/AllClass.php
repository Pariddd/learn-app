<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProgressVideoModel;
use App\Models\RoleSpesialisasiModel;
use App\Models\VideoModel;

class AllClass extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $videoModel = new VideoModel();
        $roleModel = new RoleSpesialisasiModel();
        $progressModel = new ProgressVideoModel();

        $keyword = $this->request->getGet('keyword');
        $roleId = $this->request->getGet('role_id') ? (int) $this->request->getGet('role_id') : null;

        $query = $videoModel->searchAllClass($keyword, $roleId)
            ->select('videos.*, roles_spesialisasi.nama_role')
            ->join('roles_spesialisasi', 'roles_spesialisasi.id = videos.role_id', 'left');

        $videosRaw = $query->paginate(9);
        $pager = $videoModel->pager;

        $basicVideoIds = array_map(fn($v) => $v->id, $videoModel->getBasicVideos());
        $basicSelesai = $progressModel->isBasicCourseComplete($userId, $basicVideoIds);
        $isAdmin = session()->get('role') === 'admin';

        $videos = array_map(function ($v) use ($basicSelesai, $isAdmin) {
            $locked = ($v->tipe === 'intermediate') && !$basicSelesai && !$isAdmin;
            return (object) [
                'id' => $v->id,
                'judul' => $v->judul,
                'nama_role' => $v->nama_role ?? null,
                'thumbnail' => $v->thumbnail,
                'is_locked' => $locked,
            ];
        }, $videosRaw);

        return view('all_class/index', [
            'videos' => $videos,
            'pager' => $pager,
            'roles_filter' => $roleModel->findAll(),
            'keyword' => $keyword,
        ]);
    }
}
