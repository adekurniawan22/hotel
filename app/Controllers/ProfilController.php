<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfilController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data['user'] = $this->userModel->find(session()->get('user_id'));
        $data['title'] = 'Profil';
        return view('profil', $data);
    }

    public function update()
    {
        $password = $this->request->getPost('password');

        // Check if password is not empty and is a string
        if (is_string($password) && !empty($password)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        } else {
            // If password is empty, do not update it
            $passwordHash = $this->userModel->find(session()->get('user_id'))['password'];
        }

        $userId = session()->get('user_id');
        $userData = [
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => $passwordHash,
        ];

        // Update user in the database
        $this->userModel->update($userId, $userData);

        // Update session data
        $session = session();
        $session->set('nama', $userData['nama']);
        $session->setFlashdata('success', 'Edit profil berhasil!');

        return redirect()->to('/profil');
    }
}
