<?php

namespace App\Controllers;

class Web extends BaseController
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = array(
            'title' => 'Kirim Pesan',
        );
        return view('web/v_home', $data);
    }
}
