<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAuth extends Model
{
    public function do_register($data)
    {
        $this->db->table('tbl_user')->insert($data);
    }

    public function do_login($email)
    {
        return $this->db->table('tbl_user')->where('email', $email)->get()->getRowArray();
    }
}
