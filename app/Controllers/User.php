<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;
use App\Models\SubmenuModel;
use App\Models\RoleModel;
use Exception;

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
            // Awal Validasi
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
            //Akhir Validasi

            $nama = $this->request->getPost('nama') ? $this->request->getPost('nama') : '';
            $username = $this->request->getPost('username') ? $this->request->getPost('username') : '';
            $password = $this->request->getPost('password') ? $this->request->getPost('password') : '';
            $level = $this->request->getPost('level') ? $this->request->getPost('level') : '';
            $aktif = $this->request->getPost('aktif') == 1 ? 1 : 0;

            $data = [
                'nama' => htmlspecialchars($nama, true),
                'username' => htmlspecialchars($username, true),
                'password' => password_hash(htmlspecialchars($password, true), PASSWORD_DEFAULT),
                'level' => htmlspecialchars($level, true),
                'aktif' => htmlspecialchars($aktif, true),
            ];

            try{
                if ($this->anggotamodel->save($data)) {
                    $alert = [
                        'message' => 'User Berhasil Diubah',
                        'alert' => 'alert-success'
                    ];

                    $msg = [
                        'process' => 'Process success'
                    ];
                }
            } catch (Exception $e) {
                $alert = [
                        'message' => 'User Tidak Berhasil Diubah<br>', $e->getMessage(),
                        'alert' => 'alert-danger'
                    ];

                    $msg = [
                        'process' => 'Process Terminated'
                    ];
            } finally {
                session()->setFlashdata($alert);
                echo json_encode($msg);
            }
        } else {
            return redirect()->to('user');
        }
    }

    public function getFormEdit() {
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
                'user' => $this->anggotamodel->find($this->request->getPost('id'))
            ];

            $msg = [
                'data' => view('User/Modals/edit', $data)
            ];

            echo json_encode($msg);
        }
        else {
            return redirect()->to('user');
        } 
    }

    public function updateUser(){
        if ($this->request->isAJAX()) {
            //execute next process
            if (!(check_login(session('userID')))) {
                $msg = [
                    'error' => ['logout' => base_url('logout')]
                ];
                echo json_encode($msg);
                return;
            }

            $id = $this->request->getPost('id') ? $this->request->getPost('id') : '';
            $username = $this->request->getPost('username') ? $this->request->getPost('username') : '';

            $oldUsername = $this->anggotamodel->find($id);

            if($oldUsername->username == $username) {
                $rules = 'required|min_length[3]';
            } else {
                $rules = 'required|is_unique[anggota.username]|min_length[3]';
            }

            if($this->request->getPost('password')){
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
                    'rules' => $rules,
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
                        'rules' => 'min_length[8]',
                        'errors' => [
                            'min_length' => '{field} harus terdiri dari minimal 8 karakter',
                        ]
                    ]
            ]);
            }else{
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
                    'rules' => $rules,
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
                ]);
            }

            // Awal Validasi
            $validation = \Config\Services::validation();
            
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
            //Akhir Validasi

            $nama = $this->request->getPost('nama') ? $this->request->getPost('nama') : '';
            $password = $this->request->getPost('password') ? $this->request->getPost('password') : '';
            $level = $this->request->getPost('level') ? $this->request->getPost('level') : '';
            $aktif = $this->request->getPost('aktif') == 1 ? 1 : 0;

            //Cek password
            if($password) {
                $data = [
                'id' => htmlspecialchars($id, true),
                'nama' => htmlspecialchars($nama, true),
                'username' => htmlspecialchars($username, true),
                'password' => password_hash(htmlspecialchars($password, true), PASSWORD_DEFAULT),
                'level' => htmlspecialchars($level, true),
                'aktif' => htmlspecialchars($aktif, true),
            ];
            } else{
                $data = [
                'id' => htmlspecialchars($id, true),
                'nama' => htmlspecialchars($nama, true),
                'username' => htmlspecialchars($username, true),
                'level' => htmlspecialchars($level, true),
                'aktif' => htmlspecialchars($aktif, true),
                ];
            }
            

            try{
                if ($this->anggotamodel->save($data)) {
                    $alert = [
                        'message' => 'User Berhasil Diubah',
                        'alert' => 'alert-success'
                    ];

                    $msg = [
                        'process' => 'Process success'
                    ];
                }
            } catch (Exception $e) {
                $alert = [
                        'message' => 'User Tidak Berhasil Diubah<br>', $e->getMessage(),
                        'alert' => 'alert-danger'
                    ];

                    $msg = [
                        'process' => 'Process Terminated'
                    ];
            } finally {
                session()->setFlashdata($alert);
                echo json_encode($msg);
            }
        } else {
            return redirect()->to('user');
        }
    }
    public function getFormDelete() {
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
                'user' => $this->anggotamodel->find($this->request->getPost('id'))
            ];

            $msg = [
                'data' => view('User/Modals/delete', $data)
            ];

            echo json_encode($msg);
        }
        else {
            return redirect()->to('user');
        } 
    }

    public function deleteUser() {
        if ($this->request->isAJAX()) {
            if (!(check_login(session('userID')))) {
                $msg = [
                    'error' => ['logout' => base_url('logout')]
                ];
                echo json_encode($msg);
                return;
            }

            $id = $this->request->getPost('id');
            try{
                if ($this->anggotamodel->delete(htmlspecialchars($id = $this->request->getPost('id') ? $this->request->getPost('id') : '', true))) {
                    $alert = [
                        'message' => 'User Berhasil Dihapus',
                        'alert' => 'alert-success'
                    ];

                    $msg = [
                        'process' => 'Process success'
                    ];
                }
            } catch (Exception $e) {
                $alert = [
                        'message' => 'User Tidak Berhasil Dihapus<br>', $e->getMessage(),
                        'alert' => 'alert-danger'
                    ];

                    $msg = [
                        'process' => 'Process Terminated'
                    ];
            } finally {
                session()->setFlashdata($alert);
                echo json_encode($msg);
            }
        } else {
            return redirect()->to('user');
        } 
    }
}