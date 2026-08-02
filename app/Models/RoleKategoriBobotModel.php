<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleKategoriBobotModel extends Model
{
    protected $table = 'role_kategori_bobot';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['role_id', 'kategori_id', 'bobot'];

    protected $validationRules = [
        'role_id'     => 'required|is_natural_no_zero',
        'kategori_id' => 'required|is_natural_no_zero',
        'bobot'       => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[1]',
    ];
}
