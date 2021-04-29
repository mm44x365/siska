<?php
if (!function_exists('roleIs')) {
    function roleIs($id)
    {
        switch ($id) {
            case '1':
                $role = "Super Admin";
                break;
            case '2':
                $role = "Admin";
                break;
            case '3':
                $role = "Pengguna";
                break;

            default:
                # code...
                break;
        }

        return $role;
    }
}
