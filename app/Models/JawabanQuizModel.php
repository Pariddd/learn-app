<?php

namespace App\Models;

use CodeIgniter\Model;

class JawabanQuizModel extends Model
{
    protected $table = 'jawaban_quiz';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['quiz_id', 'teks_jawaban', 'urutan'];

    protected $validationRules = [
        'quiz_id' => 'required|is_natural_no_zero',
        'teks_jawaban' => 'required|max_length[255]',
    ];

    public function getByQuiz(int $quizId): array
    {
        return $this->where('quiz_id', $quizId)->orderBy('urutan', 'ASC')->findAll();
    }
}
