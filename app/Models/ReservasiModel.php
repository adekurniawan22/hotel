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
    protected $allowedFields = ['nama_pemesan', 'email', 'no_hp', 'tanggal_checkin', 'tanggal_checkout', 'status', 'dikonfirmasi'];
    protected $useTimestamps = false;

    public function getReservasiForCurrentMonth()
    {
        return $this->where('MONTH(tanggal_checkin)', date('m'))
            ->where('YEAR(tanggal_checkin)', date('Y'))
            ->countAllResults();
    }

    public function getTotalRevenueForCurrentMonth($detailReservasiModel)
    {
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Get all reservasi IDs for the current month
        $reservasiIds = $this->select('id')
            ->where('MONTH(tanggal_checkin)', $currentMonth)
            ->where('YEAR(tanggal_checkin)', $currentYear)
            ->where('status', "selesai")
            ->findColumn('id');

        if (empty($reservasiIds)) {
            return 0;
        }

        // Calculate total revenue
        $totalRevenue = $detailReservasiModel->select('SUM(detail_reservasi.jumlah_kamar * kamar.harga) AS total_revenue')
            ->join('kamar', 'kamar.id = detail_reservasi.id_kamar')
            ->whereIn('detail_reservasi.id_reservasi', $reservasiIds)
            ->first();

        return $totalRevenue['total_revenue'] ?? 0;
    }
}
