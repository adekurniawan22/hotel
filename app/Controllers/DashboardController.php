<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KamarModel;
use App\Models\ReservasiModel;
use App\Models\DetailReservasiModel;
use CodeIgniter\Controller;

class DashboardController extends Controller
{
    protected $userModel;
    protected $kamarModel;
    protected $reservasiModel;
    protected $detailReservasiModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->kamarModel = new KamarModel();
        $this->reservasiModel = new ReservasiModel();
        $this->detailReservasiModel = new DetailReservasiModel();
    }

    public function index(): string
    {
        $data = [
            'title' => 'Dashboard',
            'jumlah_user' => $this->userModel->countAllResults(),
            'jumlah_kamar' => $this->kamarModel->countAllResults(),
            'jumlah_reservasi' => $this->reservasiModel->getReservasiForCurrentMonth(),
            'jumlah_reservasi_pending' => $this->reservasiModel->getCountByStatus('pending'),
            'jumlah_reservasi_gagal' => $this->reservasiModel->getCountByStatus('gagal'),
            'jumlah_reservasi_selesai' => $this->reservasiModel->getCountByStatus('selesai'),
            'jumlah_uang_masuk' => $this->reservasiModel->getTotalRevenueForCurrentMonth($this->detailReservasiModel),
        ];
        return view('dashboard', $data);
    }
}
