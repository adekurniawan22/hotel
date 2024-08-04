<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class DetailReservasiModel extends Model
{
    protected $table = 'detail_reservasi';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_reservasi', 'id_kamar', 'jumlah_kamar'];
    protected $useTimestamps = false;

    public function getDetailWithKamar($id)
    {
        return $this->select('detail_reservasi.*, kamar.nama_kamar, kamar.harga')
            ->join('kamar', 'kamar.id = detail_reservasi.id_kamar', 'left')
            ->where('detail_reservasi.id_reservasi', $id)
            ->findAll();
    }
}
