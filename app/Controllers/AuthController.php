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
        $data['kamar'] = $this->kamarModel->findAll();
        return view('index', $data);
    }

    public function login()
    {
        return view('login', ['title' => 'Login']);
    }

    public function authenticate()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $this->userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            $session = session();
            $session->set('logged_in', true);
            $session->set('role', $user['role']);
            $session->set('user_id', $user['id']);
            $session->set('nama', $user['nama']);

            if ($user['role'] == 'admin') {
                session()->setFlashdata('success', 'Selamat datang ke menu admin!');
                return redirect()->to('/dashboard');
            } elseif ($user['role'] == 'resepsionis') {
                session()->setFlashdata('success', 'Selamat datang ke menu resepsionis!');
                return redirect()->to('/reservasi');
            } else {
                session()->setFlashdata('error', 'Login gagal, akun tidak ditemukan');
                return redirect()->to('/login');
            }
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
}
