<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCursos extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id_curso' => [
            'type'           => 'INT',
            'constraint'     => 9,
            'unsigned'       => true,
            'auto_increment' => true,
        ],
        'nombre' => [
            'type'       => 'VARCHAR',
            'constraint' => 100
        ],
        'descripcion' => [
            'type' => 'TEXT'
        ],
        'modalidad' => [
            'type'       => 'VARCHAR',
            'constraint' => 50
        ],
        'duracion' => [
            'type'       => 'VARCHAR',
            'constraint' => 50
        ],
        'precio' => [
            'type'       => 'DECIMAL',
            'constraint' => '10,2'
        ],
        'detalles' => [
            'type' => 'TEXT',
            'null' => true
        ],
        'imagen' => [
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => true
        ]
    ]);
    $this->forge->addKey('id_curso', true);
    $this->forge->createTable('cursos');
}

    public function down()
    {
         $this->forge->dropTable('cursos');
    }
}
