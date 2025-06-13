<?php

namespace App\Models;

use CodeIgniter\Model;

class CompraModel extends Model
{
    protected $table      = 'compras';
    protected $primaryKey = 'id_compra';

    protected $allowedFields = [
        'id_curso',
        'id_usuario',
        'fecha_compra'
    ];

    protected $returnType = 'array';
    public $useTimestamps = false;
}
