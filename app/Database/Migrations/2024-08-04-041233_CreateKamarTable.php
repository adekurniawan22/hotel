<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKamarTable extends Migration
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
            'nama_kamar'        => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
            ],
            'deskripsi'         => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
            'tipe_kamar'        => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ],
            'maksimal_kapasitas' => [
                'type'              => 'INT',
                'constraint'        => 11,
            ],
            'harga'             => [
                'type'              => 'BIGINT',
                'constraint'        => '11',
            ],
            'jumlah_kamar'      => [
                'type'              => 'INT',
                'constraint'        => 11,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kamar');
    }

    public function down()
    {
        $this->forge->dropTable('kamar');
    }
}
