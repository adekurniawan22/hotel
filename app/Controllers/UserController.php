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
        $data['title'] = 'User';
        $data['users'] = $this->userModel->findAll();
        return view('admin/user/list', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah User';
        return view('admin/user/tambah', $data);
    }

    public function store()
    {
        $password = $this->request->getVar('password');

        $this->userModel->save([
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ]);

        session()->setFlashdata('success', 'Tambah user berhasil!');

        return redirect()->to('/user');
    }

    public function edit($id)
    {
        $data['user'] = $this->userModel->find($id);
        $data['title'] = 'Tambah Kamar';
        return view('admin/user/edit', $data);
    }

    public function update($id)
    {
        $password = $this->request->getPost('password');

        // Check if password is not empty and is a string
        if (is_string($password) && !empty($password)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        } else {
            // If password is empty, do not update it
            $passwordHash = $this->userModel->find($id)['password'];
        }

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
