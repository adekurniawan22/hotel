<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReservasiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_kamar'       => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nama_pemesan'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'email'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'no_hp'       => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            'tanggal_check_in'       => [
                'type'       => 'DATE',
            ],
            'tanggal_check_out'       => [
                'type'       => 'DATE',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'diproses', 'selesai', 'gagal'],
                'default'     => 'pending',
            ],
            'diproses_oleh'       => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, // Allow NULL for foreign keys
            ],
            'diselesaikan_oleh'       => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, // Allow NULL for foreign keys
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_kamar', 'kamar', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('diproses_oleh', 'user', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('diselesaikan_oleh', 'user', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('reservasi');
    }

    public function down()
    {
        $this->forge->dropTable('reservasi');
    }
}
