<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDocument extends Model
{
    protected $table = 'tbl_document';
    protected $primaryKey = 'id_document';

    protected $allowedFields = ['title', 'file'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('tbl_document');
    }
    public function noticeTable()
    {
        $result = $this->db->table('tbl_document');
        return $result;
    }

    public function buttonEdit()
    {
        $actionButton = function ($row) {
            return '
            <a href="file/' . $row["file"] . '" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-fw fa-eye"></i> Lihat Data</a>
            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $row["id_document"] . ')"><i class="fa fa-fw fa-trash"></i> Hapus</a>
            ';
        };

        return $actionButton;
    }

    public function getRulesValidation($method = null)
    {
        $rulesValidation = [
            'title' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Form tidak boleh kosong'
                ]
            ], 'file' => [
                'rules' => 'max_size[file,23000]',
                'errors' => [
                    'max_size' => 'Ukuran maksimal 20Mb',
                ]
            ]
        ];
        return $rulesValidation;
    }

    public function getData($id)
    {
        $this->builder->select('*');
        $this->builder->where('id_document', $id);
        $query = $this->builder->get();
        $data = $query->getRowArray();
        return $data;
    }
}
