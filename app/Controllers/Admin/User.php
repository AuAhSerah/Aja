<?php

namespace App\Controllers;

use App\Models\UserModel;

define('_TITLE', 'Data User');

class User extends BaseController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $dataUser = $this->userModel->getUsers();
        $data = [
            'title'  => _TITLE,
            'result'  => $dataUser
        ];
        return view('users/index', $data);
        // dd($dataUser);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah User'
        ];
        return view('users/create', $data);
    }

    public function edit($id)
    {
        $dataUser = $this->userModel->getUsers($id);
        $data = [
            'title'  => _TITLE,
            'result'  => $dataUser
        ];
        return view('users/edit', $data);
    }

    public function update($id)
    {
        $user_myth = new UserModel();
        // dd($this->request->getVar('username'));
        $this->userModel->save([
            'id'            => $id,
            'firstname'     => $this->request->getVar('firstname'),
            'lastname'      => $this->request->getVar('lastname'),
            'user_name'     => $this->request->getVar('username'),
            'user_email'    => $this->request->getVar('email'),
            'role'          => $this->request->getVar('role'),
        ]);

        session()->setFlashdata('msg', 'Berhasil memperbarui user');
        return redirect()->to('/users');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata("msg", "Data berhasil dihapus!");
        return redirect()->to('/users');
    }

    public function save()
    {
        $user_myth = new UserModel();
        $user_myth->save([
            'firstname'     => $this->request->getVar('firstname'),
            'lastname'      => $this->request->getVar('lastname'),
            'user_name'     => $this->request->getVar('username'),
            'user_email'    => $this->request->getVar('email'),
            'role'          => $this->request->getVar('role'),
            'user_password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ]);
        session()->setFlashdata('msg', 'Berhasil menambah user!');
        return redirect()->to('/users');
    }
}
