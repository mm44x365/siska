<?php

namespace App\Controllers;

use \App\Models\ModelDocument;
use monken\Tablesigniter;

class Document extends BaseController
{
    public function __construct()
    {
        helper('form');
        helper('tanggalIndo');
        helper('checkRole');
        $this->modelDocument =  new ModelDocument();
    }

    public function index()
    {
        if (checkRole('admin') == FALSE) {
            return redirect()->to('/dashboard');
        }

        $data = array(
            'title' => 'Data Dokumen',
        );
        return view('dashboard/documents/index', $data);
    }

    public function fetchAll()
    {
        $dataTable = new Tablesigniter();
        $dataTable->setTable($this->modelDocument->noticeTable())
            ->setDefaultOrder("id_document", "ASC")
            ->setSearch(["title"])
            ->setOrder(["id_document", "title"])
            ->setOutput(["id_document", "title", $this->modelDocument->buttonEdit()]);

        return $dataTable->getDatatable();
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $this->_validate('save');

            $file = $this->request->getFile('file');
            $fileName = $file->getRandomName();
            $file->move('file', $fileName);

            $data = [
                'title' => $this->request->getPost('title'),
                'file' => $fileName
            ];

            if ($this->modelDocument->save($data)) {
                echo json_encode(['status' => TRUE]);
            } else {
                echo json_encode(['status' => FALSE]);
            }
        } else {
            die('Error!');
        }
    }

    public function delete($id)
    {
        if ($this->request->isAJAX()) {
            // ambil data pengguna lewat model dan dimasukan kedalam variabel dataProfile
            $dataProfile = $this->modelDocument->getData($id);
            $file = $dataProfile['file'];
            unlink('file/' . $file);

            if ($this->modelDocument->delete($id)) {
                echo json_encode(['status' => TRUE]);
            } else {
                echo json_encode(['status' => FALSE]);
            }
        } else {
            die('Error!');
        }
    }

    public function _validate($method)
    {
        $validation = \Config\Services::validation();
        if (!$this->validate($this->modelDocument->getRulesValidation($method))) {
            $data = [];

            $isSuccess = true;

            if ($validation->hasError('title')) {
                $isSuccess = false;

                $error = [
                    'error_string' => $validation->getError('title'),
                    'inputerror' => 'title'
                ];

                $dataError = [
                    'error' => $error,
                    'status' => FALSE
                ];

                array_push($data, $dataError);
            }

            if ($validation->hasError('file')) {
                $isSuccess = false;

                $error = [
                    'error_string' => $validation->getError('file'),
                    'inputerror' => 'file'
                ];

                $dataError = [
                    'error' => $error,
                    'status' => FALSE
                ];

                array_push($data, $dataError);
            }

            if ($isSuccess === FALSE) {
                echo json_encode($data);
                exit();
            }
        }
    }
}
