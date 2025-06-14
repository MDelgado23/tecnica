<?php

namespace App\Controllers;

use App\Models\CursoModel;
use CodeIgniter\RESTful\ResourceController;

class Cursos extends ResourceController
{
    protected $modelName = 'App\Models\CursoModel';
    protected $format    = 'json';

    public function index()
    {
        header('Access-Control-Allow-Origin: *');

        $page = $this->request->getGet('page') ?? 1;
        $limit = $this->request->getGet('limit') ?? 6;

        $model = new CursoModel();

        $totalCursos = $model->countAllResults(false); // sin reset
        $cursos = $model->paginate($limit, 'default', $page);

        $response = [
            'cursos' => $cursos,
            'totalPaginas' => ceil($totalCursos / $limit),
        ];

        return $this->respond($response);
    }

    public function create()
    {
        $data = $this->request->getJSON(true);

        if (!isset($data['nombre'], $data['descripcion'], $data['precio'])) {
            return $this->failValidationError('Faltan campos obligatorios');
        }

        $curso = [
            'nombre'     => $data['nombre'],
            'descripcion'=> $data['descripcion'],
            'precio'     => $data['precio'],
            'detalles'   => $data['detalles'] ?? '',
            'imagen'     => $data['imagen'] ?? null,
            'modalidad'  => $data['modalidad'] ?? '',
            'duracion'   => $data['duracion'] ?? ''
        ];

        $this->model->insert($curso);

        return $this->respondCreated(['mensaje' => 'Curso creado correctamente']);
    }

   public function update($id = null)
{
    $data = $this->request->getJSON(true);

    if (!$id || !$data) {
        return $this->failValidationError('Datos incompletos para actualizar el curso');
    }

    $cursoExistente = $this->model->find($id);
    if (!$cursoExistente) {
        return $this->failNotFound('Curso no encontrado');
    }

    $this->model->update($id, $data);

    return $this->respond(['mensaje' => 'Curso actualizado correctamente']);
}



    public function options()
    {
        return $this->response->setStatusCode(200);
    }

    public function show($id = null)
    {
        $curso = $this->model->find($id);

        if (!$curso) {
            return $this->failNotFound('Curso no encontrado');
        }

        return $this->respond($curso);
    }
}
