<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\UsuarioModel;
use Config\Services;

class InicializarApp extends BaseCommand
{
    protected $group       = 'custom';
    protected $name        = 'app:inicializar';
    protected $description = 'Ejecuta migraciones y carga datos iniciales si no existen.';

    public function run(array $params)
{
    CLI::write('Ejecutando migraciones...', 'yellow');
    Services::migrations()->latest();

    $usuarioModel = new UsuarioModel();

    if ($usuarioModel->countAll() === 0) {
        CLI::write('Insertando datos de ejemplo...', 'yellow');
        
        $seeder = \Config\Database::seeder();

        $seeder->call('DatosEjemplo');

        CLI::write('Datos insertados correctamente.', 'green');
    } else {
        CLI::write('Los datos ya existen. No se insertó nada.', 'blue');
    }
}
}
