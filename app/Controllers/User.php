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
        if (!check_login(session('userID'))) return redirect()->to('/login');

        //dd($this->anggotamodel->getAnggota(1));

        $data = [
            'title' => 'User',
            'active' => $this->submenuModel->find(2),
            'users' => $this->anggotamodel->getAnggota(),
            'levels' => $this->roleModel->find()
        ];

        return view('user/index', $data);
    }
}