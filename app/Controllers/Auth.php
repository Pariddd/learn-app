<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function showRegister()
    {
        return view('auth/register');
    }

    public function register()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->insert([
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'user',
            'is_premium' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function showLogin()
    {
        return view('auth/login');
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user->password)) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        session()->set([
            'user_id' => $user->id,
            'username' => $user->username,
            'role' => $user->role,
            'isLoggedIn' => true,
        ]);

        return redirect()->to($user->role === 'admin' ? '/admin/dashboard' : '/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
