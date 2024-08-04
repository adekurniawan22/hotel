<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ReservasiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_pemesan'      => 'Budi Santoso',
                'email'             => 'budi.santoso@example.com',
                'no_hp'             => '081234567890',
                'tanggal_checkin'   => '2024-08-05',
                'tanggal_checkout'  => '2024-08-10',
                'status'            => 'pending',
                'dikonfirmasi' => null,
            ],
            [
                'nama_pemesan'      => 'Siti Aisyah',
                'email'             => 'siti.aisyah@example.com',
                'no_hp'             => '082345678901',
                'tanggal_checkin'   => '2024-08-12',
                'tanggal_checkout'  => '2024-08-15',
                'status'            => 'dikonfirmasi',
                'dikonfirmasi' => 1, // assuming admin ID is 1
            ],
            [
                'nama_pemesan'      => 'Joko Widodo',
                'email'             => 'joko.widodo@example.com',
                'no_hp'             => '083456789012',
                'tanggal_checkin'   => '2024-08-20',
                'tanggal_checkout'  => '2024-08-25',
                'status'            => 'check-in',
                'dikonfirmasi' => null,
            ],
            [
                'nama_pemesan'      => 'Dewi Lestari',
                'email'             => 'dewi.lestari@example.com',
                'no_hp'             => '084567890123',
                'tanggal_checkin'   => '2024-08-22',
                'tanggal_checkout'  => '2024-08-30',
                'status'            => 'selesai',
                'dikonfirmasi' => 1, // assuming admin ID is 1
            ],
            [
                'nama_pemesan'      => 'Andi Pratama',
                'email'             => 'andi.pratama@example.com',
                'no_hp'             => '085678901234',
                'tanggal_checkin'   => '2024-08-28',
                'tanggal_checkout'  => '2024-09-02',
                'status'            => 'gagal',
                'dikonfirmasi' => null,
            ],
        ];

        // Insert data into the 'reservasi' table
        $this->db->table('reservasi')->insertBatch($data);
    }
}
