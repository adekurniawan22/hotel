<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama'     => 'Admin',
                'username' => 'admin',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role'     => 'admin',
            ],
            [
                'nama'     => 'Iksal',
                'username' => 'iksal',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role'     => 'resepsionis',
            ],
            [
                'nama'     => 'Faiq',
                'username' => 'faiq',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role'     => 'resepsionis',
            ],
        ];

        // Using Query Builder
        $this->db->table('user')->insertBatch($data);
    }
}
