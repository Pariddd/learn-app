<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoleSpesialisasiModel;

class RoleController extends BaseController
{
    protected RoleSpesialisasiModel $model;

    public function __construct()
    {
        $this->model = new RoleSpesialisasiModel();
    }

    public function index()
    {
        return view('admin/role/index', ['roles' => $this->model->findAll()]);
    }

    public function create()
    {
        return view('admin/role/form', ['role' => null]);
    }

    public function store()
    {
        $rules = [
            'nama_role' => 'required|max_length[50]',
            'deskripsi' => 'permit_empty',
            'thumbnail' => 'permit_empty|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]|max_size[thumbnail,2048]|ext_in[thumbnail,jpg,jpeg,png]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_role' => $this->request->getPost('nama_role'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        $file = $this->request->getFile('thumbnail');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/roles', $newName);
            $data['thumbnail'] = $newName;
        }

        $this->model->insert($data);
        return redirect()->to('/admin/role')->with('success', 'Role berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $role = $this->model->find($id);
        if (!$role) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('admin/role/form', ['role' => $role]);
    }

    public function update(int $id)
    {
        $role = $this->model->find($id);
        if (!$role) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'nama_role' => 'required|max_length[50]',
            'deskripsi' => 'permit_empty',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_role' => $this->request->getPost('nama_role'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        $file = $this->request->getFile('thumbnail');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/roles', $newName);
            $data['thumbnail'] = $newName;

            if (!empty($role->thumbnail) && file_exists(FCPATH . 'uploads/roles/' . $role->thumbnail)) {
                unlink(FCPATH . 'uploads/roles/' . $role->thumbnail);
            }
        }

        $this->model->update($id, $data);
        return redirect()->to('/admin/role')->with('success', 'Role berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $role = $this->model->find($id);
        if ($role) {
            if (!empty($role->thumbnail) && file_exists(FCPATH . 'uploads/roles/' . $role->thumbnail)) {
                unlink(FCPATH . 'uploads/roles/' . $role->thumbnail);
            }
            $this->model->delete($id);
        }
        return redirect()->to('/admin/role')->with('success', 'Role berhasil dihapus.');
    }
}
