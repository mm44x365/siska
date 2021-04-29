<?php

namespace App\Controllers;

use \App\Models\ModelUser;
use monken\Tablesigniter;

class User extends BaseController
{
    public function __construct()
    {
        helper('form');
        helper('tanggalIndo');
        helper('roleHumanizer');
        helper('checkRole');
        $this->modelUser =  new ModelUser();
    }

    public function index()
    {
        if (checkRole('admin') == FALSE) {
            return redirect()->to('/dashboard');
        }

        $data = array(
            'title' => 'Data Admin',
        );
        return view('dashboard/users/index', $data);
    }

    public function fetchAll()
    {
        $dataTable = new Tablesigniter();
        $dataTable->setTable($this->modelUser->noticeTable())
            ->setDefaultOrder("id_user", "ASC")
            ->setSearch(["fullname", "email"])
            ->setOrder(["id_user", "fullname", "email", "phone"])
            ->setOutput(["id_user", "fullname", "email", "phone", $this->modelUser->buttonEdit()]);

        return $dataTable->getDatatable();
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $this->_validate('save');

            $password = $this->request->getPost('repassword');
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $data = [
                "fullname" => $this->request->getPost('fullname'),
                "phone" => $this->request->getPost('phone'),
                "email" => $this->request->getPost('email'),
                "password" => $passwordHash,
            ];
            if ($this->modelUser->save($data)) {
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
        $data = $this->modelUser->getData($id);
        echo json_encode($data);
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $id_user = $this->request->getPost('id_user');

            // ambil data pengguna lewat model dan dimasukan kedalam variabel dataProfile
            $dataProfile = $this->modelUser->getData($id_user);

            // ambil data post email
            $email = $this->request->getPost('email');

            // ambil email dari database
            $emailDb = $dataProfile['email'];

            // cek apakah email yang diinputkan sama dengan email yang ada di db
            if ($email === $emailDb) {
                $checkEmail = TRUE;
            } else {
                $checkEmail = FALSE;
            }

            $this->_validate('update', $checkEmail);

            $data = [
                "id_user" => $id_user,
                "fullname" => $this->request->getPost('fullname'),
                "phone" => $this->request->getPost('phone'),
                "email" => $this->request->getPost('email'),
            ];
            if ($this->modelUser->save($data)) {
                echo json_encode(['status' => TRUE]);
            } else {
                echo json_encode(['status' => FALSE]);
            }
        } else {
            die('Error!');
        }
    }

    public function reset($id)
    {
        if ($this->request->isAJAX()) {
            $password = '12345678';
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $data = [
                "id_user" => $id,
                "password" => $passwordHash
            ];

            if ($this->modelUser->save($data)) {
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
            $dataProfile = $this->modelUser->getData($id);
            $img = $dataProfile['img'];
            if ($dataProfile['img'] != 'default.png') {
                unlink('img/' . $img);
            }
            if ($this->modelUser->delete($id)) {
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
        if (!$this->validate($this->modelUser->getRulesValidation($method, $checkEmail))) {
            $data = [];

            $isSuccess = true;

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

            if ($validation->hasError('email')) {
                $isSuccess = false;

                $error = [
                    'error_string' => $validation->getError('email'),
                    'inputerror' => 'email'
                ];

                $dataError = [
                    'error' => $error,
                    'status' => FALSE
                ];

                array_push($data, $dataError);
            }

            if ($validation->hasError('phone')) {
                $isSuccess = false;

                $error = [
                    'error_string' => $validation->getError('phone'),
                    'inputerror' => 'phone'
                ];

                $dataError = [
                    'error' => $error,
                    'status' => FALSE
                ];

                array_push($data, $dataError);
            }

            if ($validation->hasError('password')) {
                $isSuccess = false;

                $error = [
                    'error_string' => $validation->getError('password'),
                    'inputerror' => 'password'
                ];

                $dataError = [
                    'error' => $error,
                    'status' => FALSE
                ];

                array_push($data, $dataError);
            }

            if ($validation->hasError('repassword')) {
                $isSuccess = false;

                $error = [
                    'error_string' => $validation->getError('repassword'),
                    'inputerror' => 'repassword'
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
