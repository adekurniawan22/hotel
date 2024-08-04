<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama'     => 'Administrator',
                'username' => 'admin',
                'password' => password_hash('password', PASSWORD_DEFAULT), // Hash password
                'role'     => 'admin',
            ],
            [
                'nama'     => 'Resepsionis',
                'username' => 'resepsionis',
                'password' => password_hash('password', PASSWORD_DEFAULT), // Hash password
                'role'     => 'resepsionis',
            ],
        ];

        // Insert data into the 'user' table
        $this->db->table('user')->insertBatch($data);
    }
}
