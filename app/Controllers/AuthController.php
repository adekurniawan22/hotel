<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\KamarModel;

class AuthController extends Controller
{
    protected $userModel;
    protected $kamarModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->kamarModel = new KamarModel();
    }

    public function index()
    {
        $data = [
            'kamar' => $this->kamarModel->findAll()
        ];
        return view('index', $data);
    }

    public function login()
    {
        $data = [
            'title' => 'Login'
        ];
        return view('login', $data);
    }

    public function authenticate()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $this->userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            $this->setUserSession($user);
            return $this->redirectUserBasedOnRole($user['role']);
        } else {
            session()->setFlashdata('error', 'Login gagal, akun tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy(); // Hapus seluruh session

        return redirect()->to('/login'); // Arahkan kembali ke halaman login
    }

    private function setUserSession(array $user): void
    {
        $session = session();
        $session->set([
            'logged_in' => true,
            'role' => $user['role'],
            'user_id' => $user['id'],
            'nama' => $user['nama']
        ]);
    }

    private function redirectUserBasedOnRole(string $role)
    {
        if ($role === 'admin') {
            session()->setFlashdata('success', 'Selamat datang ke menu admin!');
            return redirect()->to('/dashboard');
        }

        if ($role === 'resepsionis') {
            session()->setFlashdata('success', 'Selamat datang ke menu resepsionis!');
            return redirect()->to('/reservasi');
        }

        session()->setFlashdata('error', 'Login gagal, role tidak dikenali');
        return redirect()->to('/login');
    }
}
