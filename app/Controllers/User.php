<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;
use App\Models\SubmenuModel;
use App\Models\RoleModel;

class User extends BaseController
{
    protected $submenuModel;
    protected $anggotamodel;
    protected $roleModel;
    public function __construct()
    {
        $this->submenuModel = new SubmenuModel();
        $this->anggotamodel = new AnggotaModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        if (!check_login(session('userID')))
            return redirect()->to('/login');

        //dd($this->anggotamodel->getAnggota(1));

        $data = [
            'title' => 'User',
            'active' => $this->submenuModel->find(2),
            'users' => $this->anggotamodel->getAnggota(),
            'levels' => $this->roleModel->find()
        ];

        return view('user/index', $data);
    }

    public function getFormNew()
    {
        helper('text');
        if ($this->request->isAJAX()) {
            //execute next process
            if (!(check_login(session('userID')))) {
                $msg = [
                    'error' => ['logout' => base_url('logout')]
                ];
                echo json_encode($msg);
                return;
            }

            $data = [
                'levels' => $this->roleModel->find(),
                'password' => random_string('alnum', 8)
            ];

            $msg = [
                'data' => view('User/Modals/New', $data)
            ];

            echo json_encode($msg);
        }
        else {
            return redirect()->to('user');
        }
    }


    public function saveUser()
    {
        if ($this->request->isAJAX()) {
            //execute next process
            if (!(check_login(session('userID')))) {
                $msg = [
                    'error' => ['logout' => base_url('logout')]
                ];
                echo json_encode($msg);
                return;
            }

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi'
                    ]
                    ],
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required|is_unique[anggota.username]|min_length[3]',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'is_unique' => '{field} sudah terdaftar',
                        'min_length' => '{field} harus terdiri dari minimal 3 karakter',
                        ]
                    ],
                    'level' => [
                    'label' => 'Level',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        ]
                    ],
                    'password' => [
                        'label' => 'Password',
                        'rules' => 'required|min_length[8]',
                        'errors' => [
                            'required' => '{field} harus diisi',
                            'min_length' => '{field} harus terdiri dari minimal 8 karakter',
                        ]
                    ]
            ]);
            if(!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $validation->getError('nama'),
                        'username' => $validation->getError('username'),
                        'level' => $validation->getError('level'),
                        'password' => $validation->getError('password'),
                    ]
                ];
                
                echo json_encode($msg);
                return;
            }
        } else {
            return redirect()->to('user');
        }
    }
}