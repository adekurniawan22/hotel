<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KamarSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_kamar'  => 'Kamar Deluxe',
                'jumlah_kamar' => 5,
                'deskripsi'   => 'Kamar dengan fasilitas deluxe',
                'tipe_kamar'  => 'deluxe',
                'harga'       => 500000,
            ],
            [
                'nama_kamar'  => 'Kamar Standard',
                'jumlah_kamar' => 10,
                'deskripsi'   => 'Kamar dengan fasilitas standard',
                'tipe_kamar'  => 'standard',
                'harga'       => 300000,
            ],
        ];

        // Using Query Builder
        $this->db->table('kamar')->insertBatch($data);
    }
}
