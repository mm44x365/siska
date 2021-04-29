<?php
if (!function_exists('checkRole')) {
    function checkRole($role)
    {
        switch ($role) {
            case 'admin':
                if (session()->get('role') <> 2) {
                    session()->setFlashdata([
                        'alert' => 'error',
                        'title' => 'Gagal',
                        'description' => 'Anda tidak memiliki izin mengakses halaman tersebut',
                    ]);
                    return FALSE;
                }
                break;

            default:
                if (!session()->get('logged_in')) {
                    return FALSE;
                }
                break;
        }

        return TRUE;
    }
}
