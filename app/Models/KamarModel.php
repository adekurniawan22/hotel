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

    protected $allowedFields = ['nama_kamar', 'jumlah_kamar', 'deskripsi', 'tipe_kamar', 'harga'];

    protected $useTimestamps = false;
}
