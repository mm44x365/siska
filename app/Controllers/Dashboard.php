<?php

namespace App\Controllers;

use \App\Models\ModelDashboard;

class Dashboard extends BaseController
{
    public function __construct()
    {
        helper('checkRole');
        $this->modelDashboard =  new ModelDashboard();
    }

    public function index()
    {
        if (checkRole(null) == FALSE) {
            return redirect()->to('/auth/logout/error/Mohon login terlebih dahulu');
        }
        $countUsers = $this->modelDashboard->count('users');
        $countEmployes = $this->modelDashboard->count('employes');
        $countDocuments = $this->modelDashboard->count('documents');
        $data = array(
            'title' => 'Dashboard',
            'countUsers' => $countUsers,
            'countEmployes' => $countEmployes,
            'countDocuments' => $countDocuments,
        );
        return view('dashboard/v_dashboard', $data);
    }
}
