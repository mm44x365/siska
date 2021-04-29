<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function __construct()
    {
        helper('checkRole');
    }

    public function index()
    {
        if (checkRole('admin') == FALSE) {
            return redirect()->to('/dashboard');
        }
        echo "Hai";
        // dd(checkRole('admin'));
        // if (session()->get('role') <> 1) {
        //     session()->setFlashdata([
        //         'alert' => 'error',
        //         'title' => 'Gagal',
        //         'description' => 'Anda tidak memiliki izin mengakses halaman tersebut',
        //     ]);
        //     return redirect()->to('/dashboard');
        // }
    }
}
