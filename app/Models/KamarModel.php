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
}
