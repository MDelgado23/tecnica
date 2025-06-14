<?php

namespace App\Controllers;
use App\Models\UsuarioModel;
use CodeIgniter\RESTful\ResourceController;

class Usuarios extends ResourceController
{
    protected $modelName = 'App\Models\UsuarioModel';
    protected $format = 'json';

    public function findByEmail()
    {
        header('Access-Control-Allow-Origin: *');

        $email = $this->request->getGet('email');
        if (!$email) return $this->failValidationError('Falta el email');

        $usuario = $this->model->where('email', $email)->first();
        if (!$usuario) return $this->failNotFound('Usuario no encontrado');

        return $this->respond($usuario);
    }

    public function findByCel()
{
    $cel = $this->request->getGet('celnum');
    if (!$cel) return $this->failValidationError('Falta el número de celular');

    $usuarioModel = new UsuarioModel();
    $usuario = $usuarioModel->where('celnum', $cel)->first();

    if (!$usuario) return $this->respond([]);
    return $this->respond($usuario);
}
}
