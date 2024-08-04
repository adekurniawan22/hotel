<?php

namespace App\Controllers;

use App\Models\ReservasiModel;
use App\Models\DetailReservasiModel;
use App\Models\KamarModel;
use CodeIgniter\Controller;

class ReservasiController extends Controller
{
    protected $reservasiModel;
    protected $detailReservasiModel;
    protected $kamarModel;

    public function __construct()
    {
        $this->reservasiModel = new ReservasiModel();
        $this->detailReservasiModel = new DetailReservasiModel();
        $this->kamarModel = new KamarModel();
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
        $kamarModel = new KamarModel();
        $kamar = $kamarModel->getAvailableKamar();

        $kamar = array_filter($kamar, function ($item) {
            return $item['jumlah_kamar'] != $item['jumlah_pesan'];
        });

        $data = [
            'title' => 'Tambah Reservasi',
            'kamar' => $kamar,
        ];
        return view('reservasi/tambah', $data);
    }

    public function store()
    {
        $reservasiData = [
            'nama_pemesan' => $this->request->getPost('nama_pemesan'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'tanggal_checkin' => $this->request->getPost('tanggal_checkin'),
            'tanggal_checkout' => $this->request->getPost('tanggal_checkout'),
            'status' => $this->request->getPost('status'),
        ];

        $this->reservasiModel->insert($reservasiData);
        $reservasiId = $this->reservasiModel->getInsertID();

        $kamarIds = $this->request->getPost('kamar_id');
        $jumlahPesans = $this->request->getPost('jumlah_pesan');

        foreach ($kamarIds as $index => $kamarId) {
            if (isset($jumlahPesans[$index]) && is_numeric($jumlahPesans[$index]) && $jumlahPesans[$index] > 0) {
                $detailData = [
                    'id_reservasi' => $reservasiId,
                    'id_kamar' => $kamarId,
                    'jumlah_kamar' => $jumlahPesans[$index]
                ];

                $this->detailReservasiModel->insert($detailData);
            }
        }

        session()->setFlashdata('success', 'Reservasi berhasil ditambahkan!');
        return redirect()->to('/reservasi');
    }

    public function edit($id)
    {
        $reservasi = $this->reservasiModel->find($id);
        $kamar = $this->kamarModel->getAvailableKamar();
        $detailReservasi = $this->detailReservasiModel->where('id_reservasi', $id)->findAll();

        $checkedItems = [];
        foreach ($detailReservasi as $detail) {
            $checkedItems[$detail['id_kamar']] = [
                'namaKamar' => $this->kamarModel->find($detail['id_kamar'])['nama_kamar'],
                'jumlahPesan' => $detail['jumlah_kamar']
            ];
        }

        $data = [
            'title' => 'Edit Reservasi',
            'kamar' => $kamar,
            'reservasi' => $reservasi,
            'checkedItems' => $checkedItems
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
            'dikonfirmasi' => $this->request->getPost('dikonfirmasi'), // Atur sesuai kebutuhan
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

    public function detail()
    {
        $id = $this->request->getPost('id');

        if (!$id) {
            return $this->response->setStatusCode(400, 'Invalid ID');
        }

        $reservasi = $this->reservasiModel->find($id);
        if (!$reservasi) {
            return $this->response->setStatusCode(404, 'Reservasi not found');
        }

        $details = $this->detailReservasiModel->getDetailWithKamar($id);
        if (!$details) {
            return $this->response->setStatusCode(404, 'Details not found');
        }

        // Gabungkan data reservasi dan detail
        $result = [
            'nama_pemesan' => $reservasi['nama_pemesan'],
            'email' => $reservasi['email'],
            'no_hp' => $reservasi['no_hp'],
            'tanggal_checkin' => $reservasi['tanggal_checkin'],
            'tanggal_checkout' => $reservasi['tanggal_checkout'],
            'status' => $reservasi['status'],
            'details' => $details
        ];

        return $this->response->setJSON($result);
    }
}
