<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call seeders
        $this->call('UserSeeder');
        $this->call('KamarSeeder');
        $this->call('ReservasiSeeder');
    }
}
