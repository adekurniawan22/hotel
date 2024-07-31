<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ReservasiModel extends Model
{
    protected $table      = 'reservasi';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_kamar', 'nama_pemesan', 'email', 'no_hp', 'tanggal_check_in', 'tanggal_check_out', 'status', 'diproses_oleh',
        'diselesaikan_oleh'
    ];

    protected $useTimestamps = false;

    public function getReservasiWithKamar()
    {
        return $this->select('reservasi.id AS id_reservasi, reservasi.id_kamar, reservasi.nama_pemesan, reservasi.email, reservasi.no_hp, reservasi.tanggal_check_in, reservasi.tanggal_check_out, reservasi.status, reservasi.diproses_oleh , reservasi.diselesaikan_oleh, kamar.nama_kamar')
            ->join('kamar', 'kamar.id = reservasi.id_kamar')
            ->findAll();
    }

    public function getReservasiForCurrentMonth()
    {
        // Mendapatkan tanggal sekarang di Indonesia
        $now = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
        $startOfMonth = $now->format('Y-m-01');
        $endOfMonth = $now->format('Y-m-t');

        return $this->select('reservasi.id AS id_reservasi, reservasi.id_kamar, reservasi.nama_pemesan, reservasi.email, reservasi.no_hp, reservasi.tanggal_check_in, reservasi.tanggal_check_out, reservasi.status, kamar.nama_kamar')
            ->join('kamar', 'kamar.id = reservasi.id_kamar')
            ->where('tanggal_check_in >=', $startOfMonth)
            ->where('tanggal_check_in <=', $endOfMonth)
            ->countAllResults();
    }
}
