<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleSpesialisasiModel extends Model
{
    protected $table = 'roles_spesialisasi';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['nama_role', 'deskripsi', 'thumbnail'];

    protected $validationRules = [
        'nama_role' => 'required|max_length[50]',
    ];

    public function getAllRoleVectors(): array
    {
        $db = \Config\Database::connect();
        $rows = $db->table('role_kategori_bobot')->get()->getResultArray();

        $vectors = [];
        foreach ($rows as $row) {
            $vectors[$row['role_id']][$row['kategori_id']] = (float) $row['bobot'];
        }
        return $vectors;
    }
}
