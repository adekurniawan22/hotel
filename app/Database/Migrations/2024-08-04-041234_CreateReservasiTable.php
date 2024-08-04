<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReservasiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'nama_pemesan'      => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
            ],
            'email'             => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
            ],
            'no_hp'             => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
                'null'              => true,
            ],
            'tanggal_checkin'   => [
                'type'              => 'DATE',
            ],
            'tanggal_checkout'  => [
                'type'              => 'DATE',
            ],
            'status'            => [
                'type'              => 'ENUM',
                'constraint'        => ['pending', 'dikonfirmasi', 'check-in', 'selesai', 'gagal'],
                'default'           => 'pending',
            ],
            'dikonfirmasi' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('dikonfirmasi', 'user', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('reservasi');
    }

    public function down()
    {
        $this->forge->dropTable('reservasi');
    }
}
