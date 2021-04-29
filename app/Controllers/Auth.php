<?php

namespace App\Controllers;

use App\Models\ModelAuth;

class Auth extends BaseController
{

    public function __construct()
    {
        $this->ModelAuth = new ModelAuth();
    }

    public function register()
    {
        $data = array(
            'title' => 'Register',
            'validation' => \Config\Services::validation(),
        );
        return view('auth/v_register', $data);
    }

    public function do_register()
    {
        // Validasi Input
        if (!$this->validate([
            'fullname' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Form tidak boleh kosong',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[tbl_user.email]|valid_email',
                'errors' => [
                    'required' => 'Form tidak boleh kosong',
                    'valid_email' => 'Alamat Surel tidak valid.',
                    'is_unique' => 'Alamat Surel tersebut sudah digunakan.',
                    'valid_email' => 'Alamat Surel tidak valid'
                ]
            ],
            'phone' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Form tidak boleh kosong'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => 'Form tidak boleh kosong',
                    'min_length' => 'Minimal 5 karakter',
                ]
            ],
            'repassword' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Form tidak boleh kosong',
                    'matches' => 'Kata Sandi tidak sama'
                ]
            ],
            'terms' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Anda belum menyetujui',
                ]
            ],
        ])) {
            // jika tidak valid
            session()->setFlashdata([
                'alert' => 'error',
                'title' => 'Gagal',
                'description' => 'Mohon cek kembali isian anda'
            ]);
            return redirect()->to('/auth/register')->withInput();
        }

        $password = $this->request->getPost('repassword');
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'fullname' => $this->request->getPost('fullname'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'password' => $passwordHash,
            'role' => 3
        ];

        $this->ModelAuth->do_register($data);

        session()->setFlashdata([
            'alert' => 'success',
            'title' => 'Berhasil',
            'description' => 'Pendaftaran berhasil, silakan masuk'
        ]);
        return redirect()->to('/auth/login')->withInput();
    }

    public function login()
    {
        $data = array(
            'title' => 'Login',
            'validation' => \Config\Services::validation(),
        );
        return view('auth/v_login', $data);
    }

    public function do_login()
    {
        // Validasi Input
        if (!$this->validate([
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Form tidak boleh kosong',
                    'valid_email' => 'Alamat Surel tidak valid.',
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Form tidak boleh kosong',
                ]
            ]
        ])) {
            session()->setFlashdata([
                'alert' => 'error',
                'title' => 'Gagal',
                'description' => 'Mohon cek kembali isian anda',
            ]);
            return redirect()->to('/auth/login')->withInput();
        }

        $email =  $this->request->getPost('email');

        $checkData = $this->ModelAuth->do_login($email);
        if ($checkData) {
            $passPost =  $this->request->getPost('password');
            $passDb = $checkData['password'];
            $verify_pass = password_verify($passPost, $passDb);
            if ($verify_pass) {
                $sessUser = [
                    'logged_in'       => TRUE,
                    'id_user'     => $checkData['id_user'],
                    'fullname'    => $checkData['fullname'],
                    'email'    => $checkData['email'],
                    'phone'    => $checkData['phone'],
                    'password'    => $checkData['password'],
                    'img'    => $checkData['img'],
                    'role'    => $checkData['role'],
                    'created_at'    => $checkData['created_at'],
                    'updated_at'    => $checkData['updated_at'],
                ];
                session()->set($sessUser);
                session()->setFlashdata([
                    'alert' => 'success',
                    'title' => 'Berhasil',
                    'description' => 'Berhasil masuk, selamat datang ' . $sessUser['fullname'],
                ]);
                return redirect()->to('/dashboard');
            } else {
                session()->setFlashdata([
                    'alert' => 'error',
                    'title' => 'Gagal',
                    'description' => 'Kata Sandi salah',
                ]);
                return redirect()->to('/auth/login')->withInput();
            }
        } else {
            session()->setFlashdata([
                'alert' => 'error',
                'title' => 'Gagal',
                'description' => 'Email tidak terdaftar',
            ]);
            return redirect()->to('/auth/login')->withInput();
        }
    }

    public function logout($alert = 'success', $desc = 'Berhasil Keluar')
    {
        session()->remove('logged_in');
        session()->remove('id_user');
        session()->remove('fullname');
        session()->remove('email');
        session()->remove('phone');
        session()->remove('password');
        session()->remove('img');
        session()->remove('role');
        session()->remove('created_at');
        session()->remove('updated_at');

        session()->setFlashdata([
            'alert' => $alert,
            'title' => 'Berhasil',
            'description' => $desc,
        ]);
        return redirect()->to('/auth/login');
    }
}
