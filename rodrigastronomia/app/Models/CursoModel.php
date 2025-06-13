<?php

namespace App\Models;

use CodeIgniter\Model;

class CursoModel extends Model
{
    protected $table      = 'cursos';
    protected $primaryKey = 'id_curso';

    protected $allowedFields = ['nombre', 'descripcion', 'precio', 'detalles', 'imagen', 'modalidad', 'duracion'];


    protected $returnType = 'array';
    public $useTimestamps = false;
}
