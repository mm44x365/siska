<?php

namespace App\Controllers;

use App\Models\ModelProfile;

class Profile extends BaseController
{
    public function __construct()
    {
        helper('form');
        helper('tanggalIndo');
        helper('roleHumanizer');
        $this->ModelProfile = new ModelProfile();
    }

    public function index()
    {
        $id = session()->get('id_user');
        $dataProfile = $this->ModelProfile->getData($id);

        $data = array(
            'title' => 'Profil',
            'dataProfile' => $dataProfile
        );

        return view('/dashboard/profile/index', $data);
    }

    public function editPassword()
    {
        $data = array(
            'title' => 'Ubah Password'
        );

        return view('dashboard/profile/v_change_password', $data);
    }

    public function doEditPhoto()
    {
        if ($this->request->isAJAX()) {
            // ambil id_user dari session dan dimasukan kedalam variabel id
            $id = session()->get('id_user');

            // ambil data pengguna lewat model dan dimasukan kedalam variabel dataProfile
            $dataProfile = $this->ModelProfile->getData($id);

            // validasi
            $this->_validate('EditPhoto');

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

            // masukan data inputan ke array 
            $data = [
                'img' => $fileName
            ];

            if ($this->ModelProfile->do_editProfile($id, $data)) {
                echo json_encode(['status' => TRUE]);
            } else {
                echo json_encode(['status' => FALSE]);
            }
        } else {
            die('Error!');
        }
    }

    public function doEditProfile()
    {
        if ($this->request->isAJAX()) {
            // ambil id_user dari session dan dimasukan kedalam variabel id
            $id = session()->get('id_user');

            // ambil data pengguna lewat model dan dimasukan kedalam variabel dataProfile
            $dataProfile = $this->ModelProfile->getData($id);

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

            // validasi
            $this->_validate('EditProfile', $checkEmail);

            // masukan data inputan ke array 
            $data = [
                'fullname' => $this->request->getPost('fullname'),
                'email' => $email,
                'phone' => $this->request->getPost('phone')
            ];

            if ($this->ModelProfile->do_editProfile($id, $data)) {
                echo json_encode(['status' => TRUE]);
            } else {
                echo json_encode(['status' => FALSE]);
            }
        } else {
            die('Error!');
        }
    }

    public function doEditPass()
    {
        // periksa apakah ini request ajax, jika tidak maka gagal
        if ($this->request->isAJAX()) {
            // validasi
            $this->_validate('EditPass');

            // ambil id_user dari session dan dimasukan kedalam variabel id
            $id = session()->get('id_user');

            // ambil data pengguna lewat model dan dimasukan kedalam variabel dataProfile
            $dataProfile = $this->ModelProfile->getData($id);

            // ambil oldpassword dan repassword dari post
            $oldpassword = $this->request->getPost('oldpassword');
            $password = $this->request->getPost('repassword');

            // ambil password yang ada didalam database
            $passDb = $dataProfile['password'];

            // enskripsi variabel password dan masukan kedalam variabel passwordHash
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // cocokan password lama dengan password yang ada didalam database
            $verify_pass = password_verify($oldpassword, $passDb);

            // masukan ke array 
            $data = ['password' => $passwordHash];

            // jika variabel verify_pass bernilai true jalankan query ubah password
            // jika bernilai false maka keluarkan notif
            if ($verify_pass) {
                if ($this->ModelProfile->do_editProfile($id, $data)) {
                    echo json_encode(['status' => TRUE]);
                } else {
                    echo json_encode(['status' => FALSE]);
                }
            } else {
                $data = [];
                // password tidak cocok
                $error = [
                    'error_string' => 'Kata Sandi lama tidak cocok!',
                    'inputerror' => 'oldpassword'
                ];

                $dataError = [
                    'error' => $error,
                    'status' => FALSE
                ];

                array_push($data, $dataError);
                echo json_encode($data);
                exit();
                // echo json_encode(['status' => FALSE]);
            }
        } else {
            die('Error!');
        }
    }

    public function _validate($method, $checkEmail = null)
    {
        $validation = \Config\Services::validation();

        switch ($method) {
            case 'EditPhoto':
                if (!$this->validate($this->ModelProfile->getRulesValidation($method))) {
                    $data = [];

                    $isSuccess = true;

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
                break;

            case 'EditProfile':
                if (!$this->validate($this->ModelProfile->getRulesValidation($method, $checkEmail))) {
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

                    if ($isSuccess === FALSE) {
                        echo json_encode($data);
                        exit();
                    }
                }
                break;

            case 'EditPass':
                if (!$this->validate($this->ModelProfile->getRulesValidation($method))) {
                    $data = [];

                    $isSuccess = true;

                    if ($validation->hasError('oldpassword')) {
                        $isSuccess = false;

                        $error = [
                            'error_string' => $validation->getError('oldpassword'),
                            'inputerror' => 'oldpassword'
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
                break;

            default:
                # code...
                break;
        }
    }
}
