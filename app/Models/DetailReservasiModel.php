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
}
