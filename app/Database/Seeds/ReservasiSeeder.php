<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ReservasiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_pemesan'      => 'John Doe',
                'email'             => 'johndoe@example.com',
                'no_hp'             => '081234567890',
                'tanggal_checkin'   => '2024-08-05',
                'tanggal_checkout'  => '2024-08-10',
                'status'            => 'pending',
                'diselesaikan_oleh' => null,
            ],
            [
                'nama_pemesan'      => 'Jane Smith',
                'email'             => 'janesmith@example.com',
                'no_hp'             => '082345678901',
                'tanggal_checkin'   => '2024-08-15',
                'tanggal_checkout'  => '2024-08-20',
                'status'            => 'selesai',
                'diselesaikan_oleh' => 1, // assuming admin ID is 1
            ],
            [
                'nama_pemesan'      => 'Alice Johnson',
                'email'             => 'alicejohnson@example.com',
                'no_hp'             => '083456789012',
                'tanggal_checkin'   => '2024-08-25',
                'tanggal_checkout'  => '2024-08-30',
                'status'            => 'gagal',
                'diselesaikan_oleh' => null,
            ],
        ];

        // Insert data into the 'reservasi' table
        $this->db->table('reservasi')->insertBatch($data);
    }
}
