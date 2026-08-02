<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CosineSimilarityService;
use App\Models\HasilQuizRoleModel;
use App\Models\ProgressVideoModel;
use App\Models\QuizPenentuanRoleModel;
use App\Models\RoleSpesialisasiModel;
use App\Models\UserRoleProgressModel;
use App\Models\VideoModel;

class QuizRole extends BaseController
{
    protected QuizPenentuanRoleModel $quizModel;
    protected RoleSpesialisasiModel $roleModel;
    protected HasilQuizRoleModel $hasilModel;
    protected VideoModel $videoModel;
    protected ProgressVideoModel $progressModel;
    protected UserRoleProgressModel $userRoleModel;
    protected CosineSimilarityService $cosine;

    public function __construct()
    {
        $this->quizModel = new QuizPenentuanRoleModel();
        $this->roleModel = new RoleSpesialisasiModel();
        $this->hasilModel = new HasilQuizRoleModel();
        $this->videoModel = new VideoModel();
        $this->progressModel = new ProgressVideoModel();
        $this->userRoleModel = new UserRoleProgressModel();
        $this->cosine = new CosineSimilarityService();
    }

    /**
     * Tampilkan form quiz. Basic Course wajib selesai dulu.
     */
    public function index()
    {
        $userId = session()->get('user_id');
        $userRole = session()->get('role');

        // Admin dikecualikan dari gate ini - tugasnya mengelola konten,
        // bukan menjalani journey siswa, jadi perlu bisa preview quiz kapan saja
        if ($userRole !== 'admin') {
            $basicVideoIds = array_map(fn($v) => $v->id, $this->videoModel->getBasicVideos());
            $basicSelesai = $this->progressModel->isBasicCourseComplete($userId, $basicVideoIds);

            if (!$basicSelesai) {
                return redirect()->to('/basic-course')
                    ->with('error', 'Selesaikan Basic Course terlebih dahulu sebelum mengisi Quiz Role.');
            }
        }

        $soal = $this->quizModel->getAllWithJawaban();

        return view('quiz_role/form', [
            // 'soal' berisi id, pertanyaan, dan jawaban (id + teks_jawaban SAJA).
            // bobot_kategori sengaja TIDAK dikirim ke view demi keamanan -
            // jangan expose logic penilaian ke client-side.
            'soal' => array_map(function ($s) {
                return [
                    'id' => $s['id'],
                    'pertanyaan' => $s['pertanyaan'],
                    'jawaban' => array_map(fn($j) => ['id' => $j['id'], 'teks_jawaban' => $j['teks_jawaban']], $s['jawaban']),
                ];
            }, $soal),
        ]);
    }

    /**
     * Proses submit quiz: hitung vektor user -> cosine similarity ke semua role
     * -> simpan histori lengkap -> tampilkan hasil top-1.
     */
    public function submit()
    {
        $userId = session()->get('user_id');
        $jawabanRaw = $this->request->getPost('jawaban'); // format: [quiz_id => jawaban_id yang dipilih]

        if (empty($jawabanRaw) || !is_array($jawabanRaw)) {
            return redirect()->back()->with('error', 'Jawaban tidak valid.');
        }

        $soalDenganJawaban = $this->quizModel->getAllWithJawaban();

        // Bangun peta soal_id => [daftar jawaban_id yang SAH untuk soal itu]
        // untuk validasi keamanan di bawah.
        $jawabanSahPerSoal = [];
        foreach ($soalDenganJawaban as $soal) {
            $jawabanSahPerSoal[$soal['id']] = array_map('intval', array_column($soal['jawaban'], 'id'));
        }

        $jawabanTerpilih = [];
        foreach ($jawabanRaw as $quizId => $jawabanId) {
            $quizId = (int) $quizId;
            $jawabanId = (int) $jawabanId;

            // Validasi keamanan: jawaban_id yang dikirim HARUS terdaftar sebagai
            // opsi milik soal (quiz_id) tersebut. Tanpa ini, user bisa memanipulasi
            // request untuk "mencocokkan" jawaban_id dari soal lain yang bobot
            // kategorinya lebih menguntungkan, memalsukan hasil rekomendasi.
            if (!isset($jawabanSahPerSoal[$quizId]) || !in_array($jawabanId, $jawabanSahPerSoal[$quizId], true)) {
                return redirect()->back()->with('error', 'Jawaban tidak valid untuk salah satu soal.');
            }

            $jawabanTerpilih[$quizId] = $jawabanId;
        }

        $userVector = $this->cosine->buildUserVector($jawabanTerpilih, $soalDenganJawaban);

        $allRoleVectors = $this->roleModel->getAllRoleVectors();
        if (empty($allRoleVectors)) {
            return redirect()->back()->with('error', 'Belum ada data role yang bisa direkomendasikan. Hubungi admin.');
        }

        $ranking = $this->cosine->rankRoles($userVector, $allRoleVectors);
        $topRoleId = array_key_first($ranking);
        $topScore = $ranking[$topRoleId];

        // Simpan histori lengkap (bukan overwrite) - retake quiz selalu jadi baris baru
        $this->hasilModel->insert([
            'user_id' => $userId,
            'vektor_profil' => json_encode($userVector),
            'skor_semua_role' => json_encode($ranking),
            'role_direkomendasikan' => $topRoleId,
            'skor_similarity' => $topScore,
            'dikerjakan_at' => date('Y-m-d H:i:s'),
        ]);

        $topRole = $this->roleModel->find($topRoleId);

        return view('quiz_role/hasil', [
            'role' => $topRole,
            'skor_persen' => round($topScore * 100, 2),
        ]);
    }

    /**
     * User klik "Mulai Role Ini" dari hasil quiz -> aktifkan role, sumber = 'quiz'.
     */
    public function mulaiRole(int $roleId)
    {
        $userId = session()->get('user_id');
        $this->userRoleModel->activateRole($userId, $roleId, 'quiz');
        return redirect()->to('/role/roadmap/' . $roleId);
    }
}
