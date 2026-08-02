<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profil extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        return view('profil/index', ['user' => $user]);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        $userModel = new UserModel();

        $data = [];
        $file = $this->request->getFile('foto_profil');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validasi ketat: whitelist ekstensi + MIME check, cegah arbitrary file upload
            if (!$this->validate([
                'foto_profil' => 'uploaded[foto_profil]|is_image[foto_profil]|mime_in[foto_profil,image/jpg,image/jpeg,image/png]|max_size[foto_profil,2048]|ext_in[foto_profil,jpg,jpeg,png]',
            ])) {
                return redirect()->back()->with('errors', $this->validator->getErrors());
            }
            $newName = $file->getRandomName(); // jangan pakai nama asli dari client
            $file->move(FCPATH . 'uploads/profil', $newName);
            $data['foto_profil'] = $newName;
        }

        if (!empty($data)) {
            $userModel->update($userId, $data);
        }

        return redirect()->to('/profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
