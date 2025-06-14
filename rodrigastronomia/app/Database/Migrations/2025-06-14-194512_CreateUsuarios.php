<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsuarios extends Migration
{
    public function up()
    {
        $this->forge->addField([
        'id_usuario' => [
            'type'           => 'INT',
            'constraint'     => 9,
            'unsigned'       => true,
            'auto_increment' => true,
        ],
        'nombre' => [
            'type'       => 'VARCHAR',
            'constraint' => '100',
        ],
        'email' => [
            'type'       => 'VARCHAR',
            'constraint' => '100',
            'unique'     => true,
        ],
        'celnum' => [
            'type'       => 'VARCHAR',
            'constraint' => '20',
            'unique'     => true,
        ],
        'rol' => [
            'type'       => 'VARCHAR',
            'constraint' => '20',
            'default'    => 'cliente',
        ],
    ]);
    $this->forge->addKey('id_usuario', true);
    $this->forge->createTable('usuarios');
    }

    public function down()
    {
        $this->forge->dropTable('usuarios');
    }
}
