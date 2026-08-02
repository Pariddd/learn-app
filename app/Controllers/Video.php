<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LinkReferensiModel;
use App\Models\ProgressVideoModel;
use App\Models\VideoModel;

class Video extends BaseController
{
    public function player(int $id)
    {
        $userId = session()->get('user_id');
        $videoModel = new VideoModel();
        $linkModel = new LinkReferensiModel();
        $progressModel = new ProgressVideoModel();

        $video = $videoModel->find($id);
        if (!$video) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Kunci akses: video intermediate hanya bisa diputar jika basic course selesai
        // (admin dikecualikan - perlu bisa preview semua konten untuk keperluan QA)
        if ($video->tipe === 'intermediate' && session()->get('role') !== 'admin') {
            $basicVideoIds = array_map(fn($v) => $v->id, $videoModel->getBasicVideos());
            if (!$progressModel->isBasicCourseComplete($userId, $basicVideoIds)) {
                return redirect()->to('/basic-course')
                    ->with('error', 'Selesaikan Basic Course dulu sebelum mengakses video ini.');
            }
        }

        $progress = $progressModel->where('user_id', $userId)->where('video_id', $id)->first();

        return view('video/player', [
            'video' => $video,
            'referensi' => $linkModel->getByVideo($id),
            'progress' => (object) [
                'watch_percentage' => $progress ? (float) $progress->watch_percentage : 0,
                'status' => $progress ? $progress->status : 'belum',
            ],
        ]);
    }

    /**
     * Endpoint AJAX dipanggil dari JS player (IFrame API) tiap beberapa detik.
     * CATATAN KEAMANAN: nilai persentase dari client TIDAK bisa dipercaya penuh
     * (bisa dipalsukan via console/devtools). Untuk tugas kuliah ini acceptable,
     * tapi didisclose sebagai limitasi. Mitigasi minimum: clamp 0-100 di Model,
     * dan progress tidak pernah mundur (lihat ProgressVideoModel::upsertProgress).
     */
    public function updateProgress()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }

        $userId = session()->get('user_id');
        $videoId = (int) $this->request->getPost('video_id');
        $percentage = (float) $this->request->getPost('percentage');

        $videoModel = new VideoModel();
        if (!$videoModel->find($videoId)) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Video not found']);
        }

        $progressModel = new ProgressVideoModel();
        $progressModel->upsertProgress($userId, $videoId, $percentage);

        // Kirim balik token CSRF baru - token lama otomatis diregenerasi CI4
        // setiap request berhasil, jadi request AJAX berikutnya (termasuk
        // tombol "Tandai Selesai") butuh token terbaru ini, bukan yang lama.
        return $this->response->setJSON([
            'success' => true,
            'csrf_token_name' => csrf_token(),
            'csrf_hash' => csrf_hash(),
        ]);
    }
}
