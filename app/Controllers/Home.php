<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleSpesialisasiModel;

class Home extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            $target = session()->get('role') === 'admin' ? '/admin/dashboard' : '/dashboard';
            return redirect()->to($target);
        }

        $roleModel = new RoleSpesialisasiModel();

        return view('home/index', [
            'roles' => $roleModel->findAll(),
        ]);
    }
}
