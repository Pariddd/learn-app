<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriMinatModel;

class KategoriController extends BaseController
{
    protected KategoriMinatModel $model;

    public function __construct()
    {
        $this->model = new KategoriMinatModel();
    }

    public function index()
    {
        return view('admin/kategori/index', ['kategori' => $this->model->findAll()]);
    }

    public function store()
    {
        if (!$this->validate(['nama_kategori' => 'required|max_length[50]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert(['nama_kategori' => $this->request->getPost('nama_kategori')]);
        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        if (!$this->model->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if (!$this->validate(['nama_kategori' => 'required|max_length[50]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, ['nama_kategori' => $this->request->getPost('nama_kategori')]);
        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        try {
            $this->model->delete($id);
            return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/admin/kategori')
                ->with('error', 'Kategori tidak bisa dihapus karena masih dipakai di bobot role/quiz.');
        }
    }
}
