<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DetailReservasiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_reservasi' => 1,
                'id_kamar'     => 1,
                'jumlah_kamar' => 2,
            ],
            [
                'id_reservasi' => 1,
                'id_kamar'     => 2,
                'jumlah_kamar' => 1,
            ],
            [
                'id_reservasi' => 2,
                'id_kamar'     => 3,
                'jumlah_kamar' => 3,
            ],
            [
                'id_reservasi' => 3,
                'id_kamar'     => 4,
                'jumlah_kamar' => 1,
            ],
        ];

        // Insert data into the 'detail_reservasi' table
        $this->db->table('detail_reservasi')->insertBatch($data);
    }
}
