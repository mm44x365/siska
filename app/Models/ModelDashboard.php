<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDashboard extends Model
{

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->b1 = $this->db->table('tbl_user');
        $this->b2 = $this->db->table('tbl_employe');
        $this->b3 = $this->db->table('tbl_document');
    }

    public function count($table)
    {
        switch ($table) {
            case 'users':
                $return = $this->b1->countAllResults();
                break;

            case 'employes':
                $return = $this->b2->countAllResults();
                break;

            case 'documents':
                $return = $this->b3->countAllResults();
                break;

            default:
                # code...
                break;
        }
        return $return;
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
