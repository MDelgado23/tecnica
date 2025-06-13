<?php

namespace App\Controllers;

use App\Models\CompraModel;
use CodeIgniter\Controller;

class AdminController extends Controller
{
    public function resumenCompras()
    {
        $compraModel = new CompraModel();

        $data['resumen'] = $compraModel
            ->select('cursos.nombre AS curso, COUNT(*) AS cantidad')
            ->join('cursos', 'cursos.id_curso = compras.id_curso')
            ->groupBy('compras.id_curso')
            ->findAll();

        return view('admin/resumen_compras', $data);
    }
}
