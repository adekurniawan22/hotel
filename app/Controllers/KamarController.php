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
        $data['title'] = 'Kamar';
        $data['kamar'] = $this->kamarModel->findAll();
        return view('admin/kamar/list', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Kamar';
        return view('admin/kamar/tambah', $data);
    }

    public function store()
    {
        $this->kamarModel->save([
            'nama_kamar'  => $this->request->getPost('nama_kamar'),
            'jumlah_kamar' => $this->request->getPost('jumlah_kamar'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'tipe_kamar'  => $this->request->getPost('tipe_kamar'),
            'harga'       => $this->request->getPost('harga'),
        ]);
        session()->setFlashdata('success', 'Tambah kamar berhasil!');

        return redirect()->to('/kamar');
    }

    public function edit($id)
    {
        $data['kamar'] = $this->kamarModel->find($id);
        $data['title'] = 'Tambah Kamar';
        return view('admin/kamar/edit', $data);
    }

    public function update($id)
    {
        $this->kamarModel->update($id, [
            'nama_kamar'  => $this->request->getPost('nama_kamar'),
            'jumlah_kamar' => $this->request->getPost('jumlah_kamar'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'tipe_kamar'  => $this->request->getPost('tipe_kamar'),
            'harga'       => $this->request->getPost('harga'),
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
