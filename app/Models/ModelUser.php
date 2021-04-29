<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUser extends Model
{
    protected $table = 'tbl_user';
    protected $primaryKey = 'id_user';

    protected $allowedFields = ['fullname', 'email', 'phone', 'password', 'role', 'created_at', 'updated_at'];

    // protected $useTimestamp = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('tbl_user');
    }
    public function noticeTable()
    {
        $result = $this->db->table('tbl_user');
        return $result;
    }

    public function buttonEdit()
    {
        $actionButton = function ($row) {
            return '
            <a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="editData(' . $row["id_user"] . ')"><i class="fa fa-fw fa-edit"></i> Ubah</a>
            <a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="confirmResetPassword(' . $row["id_user"] . ')"><i class="fa fa-fw fa-retweet"></i> Reset Kata Sandi</a>
            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $row["id_user"] . ')"><i class="fa fa-fw fa-trash"></i> Hapus</a>
            ';
        };

        return $actionButton;
    }

    public function getRulesValidation($method = null, $checkEmail = null)
    {
        if ($method == 'save') {
            $rulePassword = 'required|min_length[5]';
            $ruleRePassword = 'required|matches[password]';
        } else {
            $rulePassword = 'permit_empty';
            $ruleRePassword = 'permit_empty';
        }

        if ($checkEmail === TRUE) {
            $ruleEmail = 'required|valid_email';
        } else {
            $ruleEmail = 'required|is_unique[tbl_user.email]|valid_email';
        }

        $rulesValidation = [
            'fullname' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Form tidak boleh kosong',
                ]
            ],
            'phone' => [
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => 'Form tidak boleh kosong',
                    'min_length' => 'Panjang minimal 5 karakter'
                ]
            ],
            'email' => [
                'rules' => $ruleEmail,
                'errors' => [
                    'required' => 'Form tidak boleh kosong',
                    'is_unique' => 'Sudah pengguna lain dengan surel tersebut',
                    'valid_email' => 'Alamat Surel tidak valid'
                ]
            ],
            'password' => [
                'rules' => $rulePassword,
                'errors' => [
                    'required' => 'Form tidak boleh kosong',
                    'min_length' => 'Minimal 5 karakter',
                ]
            ],
            'repassword' => [
                'rules' => $ruleRePassword,
                'errors' => [
                    'required' => 'Form tidak boleh kosong',
                    'matches' => 'Kata Sandi tidak sama'
                ]
            ]
        ];
        return $rulesValidation;
    }

    public function getData($id)
    {
        $this->builder->select('*');
        $this->builder->where('id_user', $id);
        $query = $this->builder->get();
        $data = $query->getRowArray();
        return $data;
    }
}
