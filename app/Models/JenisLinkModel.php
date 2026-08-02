<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisLinkModel extends Model
{
    protected $table = 'jenis_link';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['nama_jenis'];
}
