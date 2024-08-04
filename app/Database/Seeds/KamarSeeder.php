<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KamarSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_kamar'        => 'Kamar Deluxe 1',
                'deskripsi'         => 'Kamar Deluxe dengan pemandangan laut.',
                'tipe_kamar'        => 'Deluxe',
                'maksimal_kapasitas' => 2,
                'harga'             => 500000,
                'jumlah_kamar'      => 10,
            ],
            [
                'nama_kamar'        => 'Kamar Deluxe 2',
                'deskripsi'         => 'Kamar Deluxe dengan pemandangan gunung.',
                'tipe_kamar'        => 'Deluxe',
                'maksimal_kapasitas' => 2,
                'harga'             => 550000,
                'jumlah_kamar'      => 8,
            ],
            [
                'nama_kamar'        => 'Kamar Superior 1',
                'deskripsi'         => 'Kamar Superior dengan fasilitas lengkap.',
                'tipe_kamar'        => 'Superior',
                'maksimal_kapasitas' => 3,
                'harga'             => 400000,
                'jumlah_kamar'      => 5,
            ],
            [
                'nama_kamar'        => 'Kamar Superior 2',
                'deskripsi'         => 'Kamar Superior dengan akses langsung ke kolam renang.',
                'tipe_kamar'        => 'Superior',
                'maksimal_kapasitas' => 3,
                'harga'             => 450000,
                'jumlah_kamar'      => 6,
            ],
            [
                'nama_kamar'        => 'Kamar Standar 1',
                'deskripsi'         => 'Kamar Standar dengan fasilitas dasar.',
                'tipe_kamar'        => 'Standar',
                'maksimal_kapasitas' => 2,
                'harga'             => 300000,
                'jumlah_kamar'      => 15,
            ],
            [
                'nama_kamar'        => 'Kamar Standar 2',
                'deskripsi'         => 'Kamar Standar dengan pemandangan taman.',
                'tipe_kamar'        => 'Standar',
                'maksimal_kapasitas' => 2,
                'harga'             => 350000,
                'jumlah_kamar'      => 12,
            ],
        ];

        // Insert data into the 'kamar' table
        $this->db->table('kamar')->insertBatch($data);
    }
}
