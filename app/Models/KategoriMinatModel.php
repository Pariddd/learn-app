<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriMinatModel extends Model
{
    protected $table = 'kategori_minat';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['nama_kategori'];
}
