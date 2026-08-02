<?php

namespace App\Models;

use CodeIgniter\Model;

class JawabanKategoriBobotModel extends Model
{
    protected $table = 'jawaban_kategori_bobot';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['jawaban_id', 'kategori_id', 'bobot'];

    protected $validationRules = [
        'jawaban_id'  => 'required|is_natural_no_zero',
        'kategori_id' => 'required|is_natural_no_zero',
        'bobot'       => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[1]',
    ];
}
