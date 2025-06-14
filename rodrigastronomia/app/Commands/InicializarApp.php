<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\UsuarioModel;

class InicializarApp extends BaseCommand
{
    protected $group       = 'custom';
    protected $name        = 'app:inicializar';
    protected $description = 'Carga datos iniciales si no existen.';

    public function run(array $params)
    {
        $usuarioModel = new UsuarioModel();

        if ($usuarioModel->countAll() === 0) {
            CLI::write('Insertando datos de ejemplo...', 'yellow');
            \Config\Services::seeder()->call('DatosEjemplo');
            CLI::write('Datos insertados correctamente.', 'green');
        } else {
            CLI::write('Los datos ya existen. No se insertó nada.', 'blue');
        }
    }
}
