<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'User',
            'users' => $this->userModel->findAll(),
        ];
        return view('user/list', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah User'];
        return view('user/tambah', $data);
    }

    public function store()
    {
        $this->userModel->save([
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ]);

        session()->setFlashdata('success', 'Tambah user berhasil!');
        return redirect()->to('/user');
    }

    public function edit($id)
    {
        $data = [
            'user'  => $this->userModel->find($id),
            'title' => 'Edit User',
        ];
        return view('user/edit', $data);
    }

    public function update($id)
    {
        $passwordHash = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $this->userModel->find($id)['password'];

        $this->userModel->update($id, [
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => $passwordHash,
            'role'     => $this->request->getPost('role'),
        ]);

        session()->setFlashdata('success', 'Edit user berhasil!');
        return redirect()->to('/user');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata('success', 'Hapus user berhasil!');
        return redirect()->to('/user');
    }
}
