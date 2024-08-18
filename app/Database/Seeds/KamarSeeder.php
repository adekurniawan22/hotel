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
            // Additional room data
            [
                'nama_kamar'        => 'Kamar Premium 1',
                'deskripsi'         => 'Kamar Premium dengan fasilitas mewah.',
                'tipe_kamar'        => 'Premium',
                'maksimal_kapasitas' => 4,
                'harga'             => 600000,
                'jumlah_kamar'      => 4,
            ],
            [
                'nama_kamar'        => 'Kamar Premium 2',
                'deskripsi'         => 'Kamar Premium dengan balkon pribadi.',
                'tipe_kamar'        => 'Premium',
                'maksimal_kapasitas' => 4,
                'harga'             => 650000,
                'jumlah_kamar'      => 3,
            ],
            [
                'nama_kamar'        => 'Kamar Executive 1',
                'deskripsi'         => 'Kamar Executive dengan ruang kerja.',
                'tipe_kamar'        => 'Executive',
                'maksimal_kapasitas' => 3,
                'harga'             => 700000,
                'jumlah_kamar'      => 2,
            ],
            [
                'nama_kamar'        => 'Kamar Executive 2',
                'deskripsi'         => 'Kamar Executive dengan fasilitas VIP.',
                'tipe_kamar'        => 'Executive',
                'maksimal_kapasitas' => 3,
                'harga'             => 750000,
                'jumlah_kamar'      => 2,
            ],
            [
                'nama_kamar'        => 'Kamar Family 1',
                'deskripsi'         => 'Kamar Family dengan dua tempat tidur king.',
                'tipe_kamar'        => 'Family',
                'maksimal_kapasitas' => 5,
                'harga'             => 800000,
                'jumlah_kamar'      => 1,
            ],
        ];

        // Insert data into the 'kamar' table
        $this->db->table('kamar')->insertBatch($data);
    }
}
