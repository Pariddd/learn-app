<?php

namespace App\Models;

use CodeIgniter\Model;

class VideoModel extends Model
{
    protected $table = 'videos';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'tipe',
        'role_id',
        'judul',
        'deskripsi',
        'thumbnail',
        'video_url',
        'durasi_detik',
        'urutan',
    ];

    protected $validationRules = [
        'tipe'         => 'required|in_list[basic,intermediate]',
        'judul'        => 'required|max_length[150]',
        'video_url'    => 'required|valid_url_strict',
        'durasi_detik' => 'required|is_natural_no_zero',
    ];

    public function getBasicVideos(): array
    {
        return $this->where('tipe', 'basic')->orderBy('urutan', 'ASC')->findAll();
    }

    public function getVideosByRole(int $roleId): array
    {
        return $this->where('tipe', 'intermediate')
            ->where('role_id', $roleId)
            ->orderBy('urutan', 'ASC')
            ->findAll();
    }

    public function searchAllClass(?string $keyword = null, ?int $roleId = null)
    {
        $builder = $this->orderBy('tipe', 'ASC')->orderBy('urutan', 'ASC');

        if (!empty($keyword)) {
            $builder = $builder->like('judul', $keyword);
        }
        if (!empty($roleId)) {
            $builder = $builder->where('role_id', $roleId);
        }
        return $builder;
    }
}
