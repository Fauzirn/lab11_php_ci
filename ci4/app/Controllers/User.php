<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    public function index()
    {
        $title = 'Daftar User';
        $model = new UserModel();
        $users = $model->findAll();
        return view('user/index', compact('users', 'title'));
    }

    public function login()
    {
        helper(['form']);
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$email) {
            return view('user/login');
        }

        $session = session();
        $model = new UserModel();
        $login = $model->where('useremail', $email)->first();

        if ($login) {
            $pass = $login['userpassword'];

            // Cek plain text dulu, kalau gagal baru cek hash
            if ($pass === $password || password_verify($password, $pass)) {
                $login_data = [
                    'user_id' => $login['id'],
                    'user_name' => $login['username'],
                    'user_email' => $login['useremail'],
                    'logged_in' => TRUE,
                ];
                $session->set($login_data);
                return redirect()->to('/admin/artikel');
            } else {
                $session->setFlashdata("flash_msg", "Password salah.");
                return redirect()->to('/user/login');
            }
        } else {
            $session->setFlashdata("flash_msg", "Email tidak terdaftar.");
            return redirect()->to('/user/login');
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/user/login');

    }

    public function register()
    {
        helper(['form']);
        $model = new UserModel();
        $data = [
            'username' => $this->request->getPost('username'),
            'useremail' => $this->request->getPost('email'),
            'userpassword' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        if ($this->request->getMethod() === 'post') {
            if ($model->insert($data)) {
                session()->setFlashdata('success', 'Registrasi berhasil, silakan login.');
                return redirect()->to('/user/login');
            } else {
                session()->setFlashdata('error', 'Registrasi gagal, silakan coba lagi.');
                return redirect()->to('/user/register');
            }
        }

        return view('user/register');
    }

     public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/user/login');
        }

        $title = 'Dashboard Admin';
        $user_id = session()->get('user_id');
        $user_name = session()->get('user_name');

        // Ambil data artikel untuk ditampilkan di dashboard
        $artikelModel = new \App\Models\ArtikelModel();
        $artikel_count = $artikelModel->countAll();
        $artikel_published = $artikelModel->where('status', 'published')->countAllResults();

        return view('user/dashboard', compact('title', 'user_name', 'artikel_count', 'artikel_published'));
    }

}