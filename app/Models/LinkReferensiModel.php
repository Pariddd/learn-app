<?php

namespace App\Models;

use CodeIgniter\Model;

class LinkReferensiModel extends Model
{
    protected $table = 'link_referensi';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['video_id', 'jenis_link_id', 'judul', 'url'];

    protected $validationRules = [
        'video_id'      => 'required|is_natural_no_zero',
        'jenis_link_id' => 'required|is_natural_no_zero',
        'judul'         => 'required|max_length[150]',
        'url'           => 'required|valid_url_strict',
    ];

    public function getByVideo(int $videoId): array
    {
        return $this->select('link_referensi.judul, link_referensi.url, jenis_link.nama_jenis as jenis')
            ->join('jenis_link', 'jenis_link.id = link_referensi.jenis_link_id')
            ->where('video_id', $videoId)
            ->findAll();
    }
}
