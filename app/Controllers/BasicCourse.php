<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProgressVideoModel;
use App\Models\RoleSpesialisasiModel;
use App\Models\VideoModel;

class BasicCourse extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $videoModel = new VideoModel();
        $progressModel = new ProgressVideoModel();
        $roleModel = new RoleSpesialisasiModel();

        $videos = $videoModel->getBasicVideos();
        $progressList = $progressModel->where('user_id', $userId)->findAll();
        $progressByVideo = [];
        foreach ($progressList as $p) {
            $progressByVideo[$p->video_id] = $p;
        }

        $result = array_map(function ($v) use ($progressByVideo) {
            $p = $progressByVideo[$v->id] ?? null;
            return (object) [
                'id' => $v->id,
                'judul' => $v->judul,
                'deskripsi' => $v->deskripsi,
                'thumbnail' => $v->thumbnail,
                'watch_percentage' => $p ? (float) $p->watch_percentage : 0,
                'status' => $p ? $p->status : 'belum',
            ];
        }, $videos);

        $basicVideoIds = array_map(fn($v) => $v->id, $videos);
        $basicSelesai = $progressModel->isBasicCourseComplete($userId, $basicVideoIds);

        $rolesWithPreview = [];
        if ($basicSelesai) {
            foreach ($roleModel->findAll() as $role) {
                $previewVideos = array_slice($videoModel->getVideosByRole($role->id), 0, 4);
                $rolesWithPreview[] = [
                    'role' => $role,
                    'preview_videos' => $previewVideos,
                    'total_videos' => count($videoModel->getVideosByRole($role->id)),
                ];
            }
        }

        return view('basic_course/index', [
            'videos' => $result,
            'basic_selesai' => $basicSelesai,
            'roles_with_preview' => $rolesWithPreview,
        ]);
    }
}
