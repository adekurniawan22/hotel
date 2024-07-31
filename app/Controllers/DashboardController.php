<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KamarModel;
use App\Models\ReservasiModel;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $userModel = new UserModel();
        $kamarModel = new KamarModel();
        $reservasiModel = new ReservasiModel();

        $data['title'] = 'Dashboard';
        $data['jumlah_user'] =  $userModel->countAllResults();
        $data['jumlah_kamar'] = $kamarModel->countAllResults();
        $data['jumlah_reservasi'] =  $reservasiModel->getReservasiForCurrentMonth();
        return view('admin/dashboard', $data);
    }
}
