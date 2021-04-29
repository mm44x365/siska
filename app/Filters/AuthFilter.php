<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // jika tidak ada session logged_in
        if (!session()->get('logged_in')) {
            // arahkan ke halaman login
            session()->setFlashdata([
                'alert' => 'error',
                'title' => 'Gagal',
                'description' => 'Mohon masuk terlebih dahulu',
            ]);
            return redirect()->to('/auth/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // jika ada session logged_in (saat ingin akses login)
        // if (session()->get('logged_in') == TRUE) {
        //     // arahkan ke halaman dashboard
        //     session()->setFlashdata([
        //         'alert' => 'success',
        //         'title' => 'Berhasil',
        //         'description' => 'Anda sudah masuk',
        //     ]);
        //     return redirect()->to('/dashboard');
        // }
    }
}
