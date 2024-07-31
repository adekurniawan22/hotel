<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKamarTable extends Migration
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
            'nama_kamar'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'jumlah_kamar'       => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'deskripsi'       => [
                'type'       => 'TEXT',
            ],
            'tipe_kamar'       => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'harga'       => [
                'type'       => 'INT',
                'constraint' => 11,
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
