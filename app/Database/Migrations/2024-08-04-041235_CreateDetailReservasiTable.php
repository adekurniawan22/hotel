<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailReservasiTable extends Migration
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
            'id_reservasi'      => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'id_kamar'          => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'jumlah_kamar'      => [
                'type'              => 'INT',
                'constraint'        => 11,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_reservasi', 'reservasi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kamar', 'kamar', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_reservasi');
    }

    public function down()
    {
        $this->forge->dropTable('detail_reservasi');
    }
}
