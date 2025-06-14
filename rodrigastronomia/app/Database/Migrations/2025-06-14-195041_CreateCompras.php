<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCompras extends Migration
{
    public function up()
    {
        $this->forge->addField([
        'id_compra' => [
            'type'           => 'INT',
            'constraint'     => 9,
            'unsigned'       => true,
            'auto_increment' => true,
        ],
        'id_usuario' => [
            'type'       => 'INT',
            'unsigned'   => true,
        ],
        'id_curso' => [
            'type'       => 'INT',
            'unsigned'   => true,
        ],
        'fecha_compra' => [
            'type' => 'DATETIME',
        ]
    ]);
    $this->forge->addKey('id_compra', true);
    $this->forge->addForeignKey('id_usuario', 'usuarios', 'id_usuario', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('id_curso', 'cursos', 'id_curso', 'CASCADE', 'CASCADE');
    $this->forge->createTable('compras');
    }

    public function down()
    {
        $this->forge->dropTable('compras');
    }
}
