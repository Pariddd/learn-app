<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoleSpesialisasiModel;
use App\Models\VideoModel;

class VideoController extends BaseController
{
    protected VideoModel $model;

    public function __construct()
    {
        $this->model = new VideoModel();
    }

    public function index()
    {
        $roleModel = new RoleSpesialisasiModel();
        return view('admin/video/index', [
            'videos' => $this->model->orderBy('tipe', 'ASC')->orderBy('urutan', 'ASC')->findAll(),
            'roles' => $roleModel->findAll(),
        ]);
    }

    public function show(int $id)
    {
        $video = $this->model->find($id);
        if (!$video) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $roleModel = new RoleSpesialisasiModel();
        $linkModel = new \App\Models\LinkReferensiModel();

        $role = $video->role_id ? $roleModel->find($video->role_id) : null;

        return view('admin/video/show', [
            'video' => $video,
            'role' => $role,
            'referensi' => $linkModel->getByVideo($id),
        ]);
    }

    public function create()
    {
        $roleModel = new RoleSpesialisasiModel();
        return view('admin/video/form', ['video' => null, 'roles' => $roleModel->findAll()]);
    }

    public function store()
    {
        $rules = [
            'tipe'         => 'required|in_list[basic,intermediate]',
            'role_id'      => 'permit_empty|is_natural_no_zero',
            'judul'        => 'required|max_length[150]',
            'deskripsi'    => 'permit_empty',
            'video_url'    => 'required|valid_url_strict',
            'durasi_detik' => 'required|is_natural_no_zero',
            'urutan'       => 'permit_empty|is_natural',
            'thumbnail'    => 'permit_empty|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]|max_size[thumbnail,2048]|ext_in[thumbnail,jpg,jpeg,png]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tipe = $this->request->getPost('tipe');
        $roleId = $this->request->getPost('role_id');

        if ($tipe === 'basic' && !empty($roleId)) {
            return redirect()->back()->withInput()->with('error', 'Video Basic Course tidak boleh diasosiasikan dengan role tertentu.');
        }
        if ($tipe === 'intermediate' && empty($roleId)) {
            return redirect()->back()->withInput()->with('error', 'Video Intermediate wajib memilih role/spesialisasi.');
        }

        $data = [
            'tipe' => $tipe,
            'role_id' => $tipe === 'basic' ? null : (int) $roleId,
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'video_url' => $this->request->getPost('video_url'),
            'durasi_detik' => (int) $this->request->getPost('durasi_detik'),
            'urutan' => (int) ($this->request->getPost('urutan') ?? 0),
        ];

        $file = $this->request->getFile('thumbnail');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/videos', $newName);
            $data['thumbnail'] = $newName;
        }

        $this->model->insert($data);
        return redirect()->to('/admin/video')->with('success', 'Video berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $video = $this->model->find($id);
        if (!$video) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $roleModel = new RoleSpesialisasiModel();
        return view('admin/video/form', ['video' => $video, 'roles' => $roleModel->findAll()]);
    }

    public function update(int $id)
    {
        $video = $this->model->find($id);
        if (!$video) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'tipe'         => 'required|in_list[basic,intermediate]',
            'role_id'      => 'permit_empty|is_natural_no_zero',
            'judul'        => 'required|max_length[150]',
            'video_url'    => 'required|valid_url_strict',
            'durasi_detik' => 'required|is_natural_no_zero',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tipe = $this->request->getPost('tipe');
        $roleId = $this->request->getPost('role_id');

        if ($tipe === 'basic' && !empty($roleId)) {
            return redirect()->back()->withInput()->with('error', 'Video Basic Course tidak boleh diasosiasikan dengan role tertentu.');
        }
        if ($tipe === 'intermediate' && empty($roleId)) {
            return redirect()->back()->withInput()->with('error', 'Video Intermediate wajib memilih role/spesialisasi.');
        }

        $data = [
            'tipe' => $tipe,
            'role_id' => $tipe === 'basic' ? null : (int) $roleId,
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'video_url' => $this->request->getPost('video_url'),
            'durasi_detik' => (int) $this->request->getPost('durasi_detik'),
            'urutan' => (int) ($this->request->getPost('urutan') ?? $video->urutan),
        ];

        $file = $this->request->getFile('thumbnail');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/videos', $newName);
            $data['thumbnail'] = $newName;

            if (!empty($video->thumbnail) && file_exists(FCPATH . 'uploads/videos/' . $video->thumbnail)) {
                unlink(FCPATH . 'uploads/videos/' . $video->thumbnail);
            }
        }

        $this->model->update($id, $data);
        return redirect()->to('/admin/video')->with('success', 'Video berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $video = $this->model->find($id);
        if ($video) {
            if (!empty($video->thumbnail) && file_exists(FCPATH . 'uploads/videos/' . $video->thumbnail)) {
                unlink(FCPATH . 'uploads/videos/' . $video->thumbnail);
            }

            $this->model->delete($id);
        }
        return redirect()->to('/admin/video')->with('success', 'Video berhasil dihapus.');
    }
}
