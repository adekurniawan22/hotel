<?php

namespace App\Controllers;

use App\Models\ReservasiModel;
use CodeIgniter\Controller;
use App\Models\KamarModel;

class ReservasiController extends Controller
{
    protected $reservasiModel;
    protected $kamarModel;

    public function __construct()
    {
        $this->kamarModel = new KamarModel();
        $this->reservasiModel = new ReservasiModel();
    }

    public function index()
    {
        $data['title'] = 'Reservasi';
        $data['reservasi'] = $this->reservasiModel->getReservasiWithKamar();
        return view('admin/reservasi/list', $data);
    }

    public function create()
    {
        $data['kamar'] = $this->kamarModel->findAll();
        $data['title'] = 'Tambah Reservasi';
        return view('admin/reservasi/tambah', $data);
    }

    public function store()
    {
        $this->reservasiModel->save([
            'id_kamar' => $this->request->getPost('id_kamar'),
            'nama_pemesan' => $this->request->getPost('nama_pemesan'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'tanggal_check_in' => $this->request->getPost('tanggal_check_in'),
            'tanggal_check_out' => $this->request->getPost('tanggal_check_out'),
            'status' => $this->request->getPost('status'),
        ]);
        session()->setFlashdata('success', 'Tambah reservasi berhasil!');

        return redirect()->to('/reservasi');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Reservasi';
        $data['reservasi'] = $this->reservasiModel->find($id);
        $data['kamar'] = $this->kamarModel->findAll();
        return view('admin/reservasi/edit', $data);
    }

    public function update($id)
    {
        $this->reservasiModel->update($id, [
            'id_kamar' => $this->request->getPost('id_kamar'),
            'nama_pemesan' => $this->request->getPost('nama_pemesan'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'tanggal_check_in' => $this->request->getPost('tanggal_check_in'),
            'tanggal_check_out' => $this->request->getPost('tanggal_check_out'),
            'status' => $this->request->getPost('status'),
        ]);

        $status = $this->request->getPost('status');
        $userId = session()->get('user_id');

        // Mendapatkan data reservasi yang ada
        $reservasi = $this->reservasiModel->find($id);

        // Menentukan nilai untuk kolom 'diproses_oleh' dan 'diselesaikan_oleh'
        if ($status == 'pending' || $status == 'gagal') {
            $diprosesOleh = null;
            $diselesaikanOleh = null;
        } else {
            $diprosesOleh = ($status == 'diproses') ? $userId : $reservasi['diproses_oleh'];
            $diselesaikanOleh = ($status == 'selesai') ? $userId : $reservasi['diselesaikan_oleh'];
        }

        // Memperbarui data dalam model
        $this->reservasiModel->update($id, [
            'diproses_oleh' => $diprosesOleh,
            'diselesaikan_oleh' => $diselesaikanOleh,
        ]);


        session()->setFlashdata('success', 'Edit reservasi berhasil!');

        return redirect()->to('/reservasi');
    }

    public function delete($id)
    {
        $this->reservasiModel->delete($id);
        session()->setFlashdata('success', 'Hapus reservasi berhasil!');
        return redirect()->to('/reservasi');
    }

    public function createKamar($id)
    {
        $data['kamar'] = $this->kamarModel->find($id);
        $data['id_kamar'] = $id;
        return view('admin/reservasi/pesan', $data);
    }

    public function storeKamar($id)
    {
        // Simpan data pemesanan
        $this->reservasiModel->save([
            'id_kamar' => $id,
            'nama_pemesan' => $this->request->getPost('nama_pemesan'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'tanggal_check_in' => $this->request->getPost('tanggal_check_in'),
            'tanggal_check_out' => $this->request->getPost('tanggal_check_out'),
            'status' => "pending",
        ]);

        // Kirim email
        $email = \Config\Services::email();
        $email->setFrom('appcilogin@gmail.com', 'Tim Hotel');
        $email->setTo($this->request->getPost('email'));
        $email->setSubject('Konfirmasi Pemesanan Kamar');
        $email->setMessage(
            'Terima kasih atas pemesanan Anda. Kami telah memproses pemesanan Anda. ' .
                'Silakan lakukan check-in langsung di hotel pada waktu yang telah ditentukan. ' .
                'Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami ke hoteliksal@email.com.'
        );

        if ($email->send()) {
            session()->setFlashdata('success', 'Pemesanan berhasil. <br>Silakan periksa email Anda untuk detail lebih lanjut.');
        } else {
            session()->setFlashdata('error', 'Pemesanan berhasil, tetapi kami mengalami kesulitan mengirim email konfirmasi.');
        }

        return redirect()->to('/');
    }
}
