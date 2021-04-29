<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProfile extends Model
{

    protected $useTimestamp = true;

    // protected $db, $builder;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('tbl_user');
    }

    public function getRulesValidation($method = null, $checkEmail = null)
    {
        switch ($method) {
            case 'EditPhoto':
                $rulesValidation = [
                    'photo' => [
                        'rules' => 'max_size[photo,4024]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png,image/gif]',
                        'errors' => [
                            'max_size' => 'Ukuran maksimal 1024Kb atau 1Mb',
                            'is_image' => 'File yang anda pilih tidak sesuai',
                            'mime_in' => 'File yang anda pilih bukan gambar'
                        ]
                    ],
                ];
                break;

            case 'EditProfile':
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
                    'email' => [
                        'rules' => $ruleEmail,
                        'errors' => [
                            'required' => 'Form tidak boleh kosong',
                            'is_unique' => 'Sudah pengguna lain dengan surel tersebut',
                            'valid_email' => 'Alamat Surel tidak valid'
                        ]
                    ], 'phone' => [
                        'rules' => 'required|min_length[5]',
                        'errors' => [
                            'required' => 'Form tidak boleh kosong',
                            'min_length' => 'Panjang minimal 5 karakter'
                        ]
                    ],
                ];
                break;

            case 'EditPass':
                $rulesValidation = [
                    'oldpassword' => [
                        'rules' => 'required|min_length[5]',
                        'errors' => [
                            'required' => 'Form tidak boleh kosong',
                            'min_length' => 'Panjang minimal 5 karakter'
                        ]
                    ],
                    'password' => [
                        'rules' => 'required|min_length[5]',
                        'errors' => [
                            'required' => 'Form tidak boleh kosong',
                            'min_length' => 'Minimal 5 karakter',
                        ]
                    ],
                    'repassword' => [
                        'rules' => 'required|matches[password]',
                        'errors' => [
                            'required' => 'Form tidak boleh kosong',
                            'matches' => 'Kata Sandi tidak sama'
                        ]
                    ]
                ];
                break;

            default:
                # code...
                break;
        }


        return $rulesValidation;
    }

    public function do_register($data)
    {
        // $this->db->table('tbl_user')->insert($data);
        $this->builder->insert($data);
    }

    public function do_editProfile($id, $data)
    {
        $this->builder->where('id_user', $id);

        return $this->builder->update($data);
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
