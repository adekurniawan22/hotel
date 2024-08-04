<?php

namespace App\Controllers;

use App\Models\KamarModel;
use CodeIgniter\Controller;

class KamarController extends Controller
{
    protected $kamarModel;

    public function __construct()
    {
        $this->kamarModel = new KamarModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kamar',
            'kamar' => $this->kamarModel->findAll(),
        ];
        return view('kamar/list', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Kamar'];
        return view('kamar/tambah', $data);
    }

    public function store()
    {
        $this->kamarModel->save([
            'nama_kamar'        => $this->request->getPost('nama_kamar'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'tipe_kamar'        => $this->request->getPost('tipe_kamar'),
            'maksimal_kapasitas' => $this->request->getPost('maksimal_kapasitas'),
            'harga'             => $this->request->getPost('harga'),
            'jumlah_kamar'      => $this->request->getPost('jumlah_kamar'),
        ]);

        session()->setFlashdata('success', 'Tambah kamar berhasil!');
        return redirect()->to('/kamar');
    }

    public function edit($id)
    {
        $data = [
            'kamar' => $this->kamarModel->find($id),
            'title' => 'Edit Kamar',
        ];
        return view('kamar/edit', $data);
    }

    public function update($id)
    {
        $this->kamarModel->update($id, [
            'nama_kamar'        => $this->request->getPost('nama_kamar'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'tipe_kamar'        => $this->request->getPost('tipe_kamar'),
            'maksimal_kapasitas' => $this->request->getPost('maksimal_kapasitas'),
            'harga'             => $this->request->getPost('harga'),
            'jumlah_kamar'      => $this->request->getPost('jumlah_kamar'),
        ]);

        session()->setFlashdata('success', 'Edit kamar berhasil!');
        return redirect()->to('/kamar');
    }

    public function delete($id)
    {
        $this->kamarModel->delete($id);
        session()->setFlashdata('success', 'Hapus kamar berhasil!');
        return redirect()->to('/kamar');
    }
}
