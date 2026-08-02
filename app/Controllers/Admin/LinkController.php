<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JenisLinkModel;
use App\Models\LinkReferensiModel;
use App\Models\VideoModel;

class LinkController extends BaseController
{
    protected LinkReferensiModel $model;

    public function __construct()
    {
        $this->model = new LinkReferensiModel();
    }

    public function index()
    {
        $videoModel = new VideoModel();
        $jenisModel = new JenisLinkModel();

        return view('admin/link/index', [
            'links' => $this->model
                ->select('link_referensi.*, videos.judul as judul_video, jenis_link.nama_jenis')
                ->join('videos', 'videos.id = link_referensi.video_id')
                ->join('jenis_link', 'jenis_link.id = link_referensi.jenis_link_id')
                ->findAll(),
            'videos' => $videoModel->findAll(),
            'jenis' => $jenisModel->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'video_id'      => 'required|is_natural_no_zero',
            'jenis_link_id' => 'required|is_natural_no_zero',
            'judul'         => 'required|max_length[150]',
            'url'           => 'required|valid_url_strict',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'video_id' => (int) $this->request->getPost('video_id'),
            'jenis_link_id' => (int) $this->request->getPost('jenis_link_id'),
            'judul' => $this->request->getPost('judul'),
            'url' => $this->request->getPost('url'),
        ]);

        return redirect()->to('/admin/link')->with('success', 'Link referensi berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        if (!$this->model->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'judul' => 'required|max_length[150]',
            'url'   => 'required|valid_url_strict',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'judul' => $this->request->getPost('judul'),
            'url' => $this->request->getPost('url'),
        ]);

        return redirect()->to('/admin/link')->with('success', 'Link referensi berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/link')->with('success', 'Link referensi berhasil dihapus.');
    }
}
