<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriMinatModel;
use App\Models\RoleKategoriBobotModel;
use App\Models\RoleSpesialisasiModel;

class BobotController extends BaseController
{
    protected RoleKategoriBobotModel $model;

    public function __construct()
    {
        $this->model = new RoleKategoriBobotModel();
    }

    public function index()
    {
        $roleModel = new RoleSpesialisasiModel();
        $kategoriModel = new KategoriMinatModel();

        return view('admin/bobot/index', [
            'roles' => $roleModel->findAll(),
            'kategori' => $kategoriModel->findAll(),
            'bobot' => $this->model->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'role_id'     => 'required|is_natural_no_zero',
            'kategori_id' => 'required|is_natural_no_zero',
            'bobot'       => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[1]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $roleId = (int) $this->request->getPost('role_id');
        $kategoriId = (int) $this->request->getPost('kategori_id');

        $existing = $this->model->where('role_id', $roleId)->where('kategori_id', $kategoriId)->first();
        if ($existing) {
            return redirect()->back()->withInput()
                ->with('error', 'Bobot untuk kombinasi role dan kategori ini sudah ada. Gunakan fitur edit.');
        }

        $this->model->insert([
            'role_id' => $roleId,
            'kategori_id' => $kategoriId,
            'bobot' => $this->request->getPost('bobot'),
        ]);

        return redirect()->to('/admin/bobot')->with('success', 'Bobot berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        $rules = ['bobot' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[1]'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, ['bobot' => $this->request->getPost('bobot')]);
        return redirect()->to('/admin/bobot')->with('success', 'Bobot berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/bobot')->with('success', 'Bobot berhasil dihapus.');
    }
}
