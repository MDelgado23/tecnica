<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $allowedFields = [
        'nombre',
        'email',
        'celnum',
        'rol'
    ];

    protected $returnType = 'array';
    public $useTimestamps = false;
}