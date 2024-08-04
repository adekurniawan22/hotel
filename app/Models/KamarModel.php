<?php

namespace App\Models;

use CodeIgniter\Model;

class KamarModel extends Model
{
    protected $table      = 'kamar';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nama_kamar', 'deskripsi', 'tipe_kamar', 'maksimal_kapasitas', 'harga', 'jumlah_kamar'];
    protected $useTimestamps = false;

    public function getAvailableKamar()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('kamar');

        // Mendapatkan ID reservasi yang dikonfirmasi
        $reservasiModel = new \App\Models\ReservasiModel();
        $reservasiDikonfirmasi = $reservasiModel->whereIn('status', ['dikonfirmasi', 'check-in'])->findAll();
        $idReservasiDikonfirmasi = array_column($reservasiDikonfirmasi, 'id');

        $jumlahDipesan = [];
        if (!empty($idReservasiDikonfirmasi)) {
            $detailReservasiModel = new \App\Models\DetailReservasiModel();
            $detailReservasi = $detailReservasiModel->whereIn('id_reservasi', $idReservasiDikonfirmasi)->findAll();
            foreach ($detailReservasi as $detail) {
                if (!isset($jumlahDipesan[$detail['id_kamar']])) {
                    $jumlahDipesan[$detail['id_kamar']] = 0;
                }
                $jumlahDipesan[$detail['id_kamar']] += $detail['jumlah_kamar'];
            }
        }

        // Mengambil semua data kamar
        $kamar = $this->findAll();

        // Menambahkan jumlah pesan dan menghapus kamar yang sudah penuh
        foreach ($kamar as &$item) {
            $idKamar = $item['id'];
            $jumlahDipesanKamar = isset($jumlahDipesan[$idKamar]) ? $jumlahDipesan[$idKamar] : 0;
            $item['jumlah_pesan'] = $jumlahDipesanKamar;
        }

        return $kamar;
    }
}
