<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelEmploye extends Model
{
    protected $table = 'tbl_employe';
    protected $primaryKey = 'id_employe';

    protected $allowedFields = ['nip', 'fullname', 'address', 'position', 'year', 'agama', 'img'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('tbl_employe');
    }
    public function noticeTable()
    {
        $result = $this->db->table('tbl_employe');
        return $result;
    }

    public function buttonEdit()
    {
        $actionButton = function ($row) {
            return '
            <a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="editData(' . $row["id_employe"] . ')"><i class="fa fa-fw fa-edit"></i> Ubah</a>
            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $row["id_employe"] . ')"><i class="fa fa-fw fa-trash"></i> Hapus</a>
            ';
        };

        return $actionButton;
    }

    public function getRulesValidation($method = null, $cheknip = null)
    {
        if ($method == 'save') {
            $rulePassword = 'required|min_length[5]';
            $ruleRePassword = 'required|matches[password]';
        } else {
            $rulePassword = 'permit_empty';
            $ruleRePassword = 'permit_empty';
        }

        if ($cheknip === TRUE) {
            $rulenip = 'required';
        } else {
            $rulenip = 'required|is_unique[tbl_employe.nip]';
        }

        $rulesValidation = [
            'nip' => [
                'rules' => $rulenip,
                'errors' => [
                    'required' => 'Form tidak boleh kosong',
                    'is_unique' => 'Sudah ada karyawan dengan nip tersebut',
                ]
            ],
            'fullname' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Form tidak boleh kosong'
                ]
            ],
            'address' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Form tidak boleh kosong'
                ]
            ],
            'position' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Form tidak boleh kosong'
                ]
            ],
            'year' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Form tidak boleh kosong'
                ]
            ],
            'agama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Form tidak boleh kosong'
                ]
            ], 'photo' => [
                'rules' => 'max_size[photo,1024]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran maksimal 1024Kb atau 1Mb',
                    'is_image' => 'File yang anda pilih tidak sesuai',
                    'mime_in' => 'File yang anda pilih bukan gambar'
                ]
            ]
        ];
        return $rulesValidation;
    }

    public function getData($id)
    {
        $this->builder->select('*');
        $this->builder->where('id_employe', $id);
        $query = $this->builder->get();
        $data = $query->getRowArray();
        return $data;
    }
}
