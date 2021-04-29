<?php

namespace App\Controllers;

use \App\Models\ModelEmploye;
use monken\Tablesigniter;

class Employe extends BaseController
{
    public function __construct()
    {
        helper('form');
        helper('tanggalIndo');
        helper('roleHumanizer');
        helper('checkRole');
        $this->modelEmploye =  new ModelEmploye();
    }

    public function index()
    {
        if (checkRole('admin') == FALSE) {
            return redirect()->to('/dashboard');
        }

        $data = array(
            'title' => 'Data Karyawan',
        );
        return view('dashboard/employes/index', $data);
    }

    public function fetchAll()
    {
        $dataTable = new Tablesigniter();
        $dataTable->setTable($this->modelEmploye->noticeTable())
            ->setDefaultOrder("id_employe", "ASC")
            ->setSearch(["nip", "fullname", "address"])
            ->setOrder(["id_employe", "nip", "fullname", "address"])
            ->setOutput(["id_employe", "nip", "fullname", "address", $this->modelEmploye->buttonEdit()]);

        return $dataTable->getDatatable();
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $this->_validate('save');

            $photo = $this->request->getFile('photo');
            $fileName = $photo->getRandomName();
            $photo->move('img', $fileName);

            $data = [
                "nip" => $this->request->getPost('nip'),
                "fullname" => $this->request->getPost('fullname'),
                "address" => $this->request->getPost('address'),
                "position" => $this->request->getPost('position'),
                "year" => $this->request->getPost('year'),
                "agama" => $this->request->getPost('agama'),
                'img' => $fileName
            ];

            if ($this->modelEmploye->save($data)) {
                echo json_encode(['status' => TRUE]);
            } else {
                echo json_encode(['status' => FALSE]);
            }
        } else {
            die('Error!');
        }
    }

    public function edit($id)
    {
        $data = $this->modelEmploye->getData($id);
        echo json_encode($data);
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $id_employe = $this->request->getPost('id_employe');

            // ambil data pengguna lewat model dan dimasukan kedalam variabel dataProfile
            $dataProfile = $this->modelEmploye->getData($id_employe);

            // ambil data post email
            $nip = $this->request->getPost('nip');

            // ambil nip dari database
            $nipDb = $dataProfile['nip'];

            // cek apakah nip yang diinputkan sama dengan nip yang ada di db
            if ($nip === $nipDb) {
                $checknip = TRUE;
            } else {
                $checknip = FALSE;
            }

            $this->_validate('update', $checknip);

            $photo = $this->request->getFile('photo');

            $imgDb = $dataProfile['img'];
            if ($photo->getError() == 4) {
                $fileName = $imgDb;
            } else {
                // ubah nama ktp dan pindah file
                $fileName = $photo->getRandomName();
                $photo->move('img', $fileName);
                // cek jika gambar default
                if ($imgDb != 'default.png') {
                    // hapus gambar ktp 
                    unlink('img/' . $imgDb);
                }
            }

            $data = [
                "id_employe" => $id_employe,
                "nip" => $this->request->getPost('nip'),
                "fullname" => $this->request->getPost('fullname'),
                "address" => $this->request->getPost('address'),
                "position" => $this->request->getPost('position'),
                "year" => $this->request->getPost('year'),
                "agama" => $this->request->getPost('agama'),
                'img' => $fileName
            ];
            if ($this->modelEmploye->save($data)) {
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
            $dataProfile = $this->modelEmploye->getData($id);
            $img = $dataProfile['img'];
            if ($dataProfile['img'] != 'default.png') {
                unlink('img/' . $img);
            }
            if ($this->modelEmploye->delete($id)) {
                echo json_encode(['status' => TRUE]);
            } else {
                echo json_encode(['status' => FALSE]);
            }
        } else {
            die('Error!');
        }
    }

    public function _validate($method, $checkEmail = null)
    {
        $validation = \Config\Services::validation();
        if (!$this->validate($this->modelEmploye->getRulesValidation($method, $checkEmail))) {
            $data = [];

            $isSuccess = true;

            if ($validation->hasError('nip')) {
                $isSuccess = false;

                $error = [
                    'error_string' => $validation->getError('nip'),
                    'inputerror' => 'nip'
                ];

                $dataError = [
                    'error' => $error,
                    'status' => FALSE
                ];

                array_push($data, $dataError);
            }

            if ($validation->hasError('fullname')) {
                $isSuccess = false;

                $error = [
                    'error_string' => $validation->getError('fullname'),
                    'inputerror' => 'fullname'
                ];

                $dataError = [
                    'error' => $error,
                    'status' => FALSE
                ];

                array_push($data, $dataError);
            }

            if ($validation->hasError('address')) {
                $isSuccess = false;

                $error = [
                    'error_string' => $validation->getError('address'),
                    'inputerror' => 'address'
                ];

                $dataError = [
                    'error' => $error,
                    'status' => FALSE
                ];

                array_push($data, $dataError);
            }

            if ($validation->hasError('position')) {
                $isSuccess = false;

                $error = [
                    'error_string' => $validation->getError('position'),
                    'inputerror' => 'position'
                ];

                $dataError = [
                    'error' => $error,
                    'status' => FALSE
                ];

                array_push($data, $dataError);
            }

            if ($validation->hasError('year')) {
                $isSuccess = false;

                $error = [
                    'error_string' => $validation->getError('year'),
                    'inputerror' => 'year'
                ];

                $dataError = [
                    'error' => $error,
                    'status' => FALSE
                ];

                array_push($data, $dataError);
            }

            if ($validation->hasError('agama')) {
                $isSuccess = false;

                $error = [
                    'error_string' => $validation->getError('agama'),
                    'inputerror' => 'agama'
                ];

                $dataError = [
                    'error' => $error,
                    'status' => FALSE
                ];

                array_push($data, $dataError);
            }

            if ($validation->hasError('photo')) {
                $isSuccess = false;

                $error = [
                    'error_string' => $validation->getError('photo'),
                    'inputerror' => 'photo'
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
