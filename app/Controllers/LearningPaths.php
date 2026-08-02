<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserRoleProgressModel;

class LearningPaths extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $model = new UserRoleProgressModel();
        $paths = $model->getLearningPaths($userId);

        $result = array_map(fn($p) => (object) [
            'role_id' => $p['role_id'],
            'nama_role' => $p['nama_role'],
            'progress_percentage' => round((float) $p['progress_percentage'], 1),
            'sumber' => $p['sumber'],
            'started_at' => $p['started_at'],
        ], $paths);

        return view('learning_paths/index', ['learning_paths' => $result]);
    }

    /**
     * User berhenti menjalani sebuah role (mis. cuma penasaran, ternyata
     * tidak minat). Ini HANYA menghapus baris "role aktif" (user_role_progress),
     * TIDAK menghapus progress_video yang sudah tercatat - supaya kalau user
     * suatu saat mulai lagi role yang sama, video yang sudah ditonton tidak
     * hilang progressnya.
     */
    public function hapus(int $roleId)
    {
        $userId = session()->get('user_id');
        $model = new UserRoleProgressModel();

        $model->where('user_id', $userId)->where('role_id', $roleId)->delete();

        return redirect()->to('/learning-paths')->with('success', 'Role berhasil dihapus dari daftar yang sedang dijalani.');
    }
}
