<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizPenentuanRoleModel extends Model
{
    protected $table = 'quiz_penentuan_role';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['pertanyaan'];

    public function getAllWithJawaban(): array
    {
        $soalList = $this->findAll();
        $db = \Config\Database::connect();

        $jawabanRows = $db->table('jawaban_quiz')->orderBy('urutan', 'ASC')->get()->getResultArray();
        $bobotRows = $db->table('jawaban_kategori_bobot')->get()->getResultArray();

        $bobotMap = [];
        foreach ($bobotRows as $row) {
            $bobotMap[$row['jawaban_id']][$row['kategori_id']] = (float) $row['bobot'];
        }

        $jawabanByQuiz = [];
        foreach ($jawabanRows as $j) {
            $jawabanByQuiz[$j['quiz_id']][] = [
                'id' => $j['id'],
                'teks_jawaban' => $j['teks_jawaban'],
                'bobot_kategori' => $bobotMap[$j['id']] ?? [],
            ];
        }

        $result = [];
        foreach ($soalList as $soal) {
            $result[] = [
                'id' => $soal->id,
                'pertanyaan' => $soal->pertanyaan,
                'jawaban' => $jawabanByQuiz[$soal->id] ?? [],
            ];
        }
        return $result;
    }
}
