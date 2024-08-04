<?php

namespace App\Controllers;

use App\Models\ReservasiModel;
use App\Models\DetailReservasiModel;
use CodeIgniter\Controller;

class ReservasiController extends Controller
{
    protected $reservasiModel;
    protected $detailReservasiModel;

    public function __construct()
    {
        $this->reservasiModel = new ReservasiModel();
        $this->detailReservasiModel = new DetailReservasiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Reservasi',
            'reservasi' => $this->reservasiModel->findAll(),
        ];
        return view('reservasi/list', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Reservasi',
            'kamar' => (new \App\Models\KamarModel())->findAll(), // Ambil semua data kamar
        ];
        return view('reservasi/tambah', $data);
    }

    public function store()
    {
        // Ambil data dari request
        $namaPemesan = $this->request->getPost('nama_pemesan');
        $email = $this->request->getPost('email');
        $noHp = $this->request->getPost('no_hp');
        $tanggalCheckin = $this->request->getPost('tanggal_checkin');
        $tanggalCheckout = $this->request->getPost('tanggal_checkout');
        $status = $this->request->getPost('status');
        $kamar = $this->request->getPost('id_kamar'); // Array of kamar IDs
        $jumlahKamar = $this->request->getPost('jumlah_kamar'); // Array of jumlah kamar per ID

        // Simpan data reservasi
        $reservasiId = $this->reservasiModel->insert([
            'nama_pemesan' => $namaPemesan,
            'email' => $email,
            'no_hp' => $noHp,
            'tanggal_checkin' => $tanggalCheckin,
            'tanggal_checkout' => $tanggalCheckout,
            'status' => $status,
            'diselesaikan_oleh' => null, // Atur sesuai kebutuhan
        ]);

        // Simpan detail reservasi
        if ($reservasiId) {
            foreach ($kamar as $index => $kamarId) {
                $this->detailReservasiModel->insert([
                    'id_reservasi' => $reservasiId,
                    'id_kamar' => $kamarId,
                    'jumlah_kamar' => $jumlahKamar[$index],
                ]);
            }
        }

        session()->setFlashdata('success', 'Reservasi berhasil ditambahkan!');
        return redirect()->to('/reservasi');
    }

    public function edit($id)
    {
        $data = [
            'reservasi' => $this->reservasiModel->find($id),
            'title' => 'Edit Reservasi',
            'kamar' => (new \App\Models\KamarModel())->findAll(), // Ambil semua data kamar
        ];
        return view('reservasi/edit', $data);
    }

    public function update($id)
    {
        $this->reservasiModel->update($id, [
            'nama_pemesan' => $this->request->getPost('nama_pemesan'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'tanggal_checkin' => $this->request->getPost('tanggal_checkin'),
            'tanggal_checkout' => $this->request->getPost('tanggal_checkout'),
            'status' => $this->request->getPost('status'),
            'diselesaikan_oleh' => $this->request->getPost('diselesaikan_oleh'), // Atur sesuai kebutuhan
        ]);

        session()->setFlashdata('success', 'Reservasi berhasil diperbarui!');
        return redirect()->to('/reservasi');
    }

    public function delete($id)
    {
        // Hapus detail reservasi terkait
        $this->detailReservasiModel->where('id_reservasi', $id)->delete();

        // Hapus reservasi
        $this->reservasiModel->delete($id);

        session()->setFlashdata('success', 'Reservasi berhasil dihapus!');
        return redirect()->to('/reservasi');
    }
}
