<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JawabanKategoriBobotModel;
use App\Models\JawabanQuizModel;
use App\Models\KategoriMinatModel;
use App\Models\QuizPenentuanRoleModel;

class QuizController extends BaseController
{
    protected QuizPenentuanRoleModel $model;
    protected JawabanQuizModel $jawabanModel;
    protected JawabanKategoriBobotModel $bobotModel;

    public function __construct()
    {
        $this->model = new QuizPenentuanRoleModel();
        $this->jawabanModel = new JawabanQuizModel();
        $this->bobotModel = new JawabanKategoriBobotModel();
    }

    public function index()
    {
        $kategoriModel = new KategoriMinatModel();
        return view('admin/quiz/index', [
            'soal' => $this->model->getAllWithJawaban(),
            'kategori' => $kategoriModel->findAll(),
        ]);
    }

    public function store()
    {
        $result = $this->validateAndParse();
        if ($result['error']) {
            return redirect()->back()->withInput()->with('error', $result['error']);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->model->insert(['pertanyaan' => $this->request->getPost('pertanyaan')]);
        $quizId = $this->model->getInsertID();

        $this->simpanJawaban($quizId, $result['jawaban']);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan soal, silakan coba lagi.');
        }

        return redirect()->to('/admin/quiz')->with('success', 'Soal quiz berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        if (!$this->model->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $result = $this->validateAndParse();
        if ($result['error']) {
            return redirect()->back()->withInput()->with('error', $result['error']);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->model->update($id, ['pertanyaan' => $this->request->getPost('pertanyaan')]);

        $this->jawabanModel->where('quiz_id', $id)->delete();
        $this->simpanJawaban($id, $result['jawaban']);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui soal, silakan coba lagi.');
        }

        return redirect()->to('/admin/quiz')->with('success', 'Soal quiz berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/quiz')->with('success', 'Soal quiz berhasil dihapus.');
    }


    private function validateAndParse(): array
    {
        if (!$this->validate(['pertanyaan' => 'required|max_length[500]'])) {
            return ['error' => implode(' ', $this->validator->getErrors()), 'jawaban' => []];
        }

        $jawabanRaw = $this->request->getPost('jawaban');
        if (empty($jawabanRaw) || !is_array($jawabanRaw) || count($jawabanRaw) < 2) {
            return ['error' => 'Minimal 2 opsi jawaban diperlukan.', 'jawaban' => []];
        }

        $parsed = [];
        foreach ($jawabanRaw as $item) {
            $teks = trim($item['teks'] ?? '');
            $kategoriIds = $item['kategori_id'] ?? [];
            $bobotList = $item['bobot'] ?? [];

            if ($teks === '') {
                return ['error' => 'Teks jawaban tidak boleh kosong.', 'jawaban' => []];
            }
            if (empty($kategoriIds) || count($kategoriIds) !== count($bobotList)) {
                return ['error' => 'Setiap jawaban wajib punya minimal 1 bobot kategori.', 'jawaban' => []];
            }
            if (count($kategoriIds) !== count(array_unique($kategoriIds))) {
                return ['error' => 'Satu kategori tidak boleh dipilih dua kali dalam jawaban yang sama.', 'jawaban' => []];
            }
            foreach ($bobotList as $b) {
                if (!is_numeric($b) || $b < 0 || $b > 1) {
                    return ['error' => 'Bobot harus berupa angka antara 0.00 - 1.00.', 'jawaban' => []];
                }
            }

            $parsed[] = ['teks' => $teks, 'kategori_id' => $kategoriIds, 'bobot' => $bobotList];
        }

        return ['error' => null, 'jawaban' => $parsed];
    }


    private function simpanJawaban(int $quizId, array $jawabanList): void
    {
        foreach ($jawabanList as $index => $item) {
            $this->jawabanModel->insert([
                'quiz_id' => $quizId,
                'teks_jawaban' => $item['teks'],
                'urutan' => $index + 1,
            ]);
            $jawabanId = $this->jawabanModel->getInsertID();

            $bobotRows = [];
            foreach ($item['kategori_id'] as $i => $kategoriId) {
                $bobotRows[] = [
                    'jawaban_id' => $jawabanId,
                    'kategori_id' => (int) $kategoriId,
                    'bobot' => $item['bobot'][$i],
                ];
            }
            $this->bobotModel->insertBatch($bobotRows);
        }
    }
}
