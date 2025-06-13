<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\CompraModel;
use App\Models\CursoModel;
use CodeIgniter\RESTful\ResourceController;

class Compras extends ResourceController
{
    protected $modelName = 'App\Models\CompraModel';
    protected $format    = 'json';


    public function create()
    {  
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

        $data = $this->request->getJSON(true);

    
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->where('email', $data['email'])->first();

        if (!$usuario) {
            $usuarioData = [
                'nombre' => $data['nombre'],
                'email'  => $data['email'],
                'celnum' => $data['celnum'],
                'rol'    => 'cliente'
            ];
            $usuarioModel->insert($usuarioData);
            $id_usuario = $usuarioModel->insertID();
        } else {
            $id_usuario = $usuario['id_usuario'];
        }

        $compraModel = new CompraModel();
        $compraModel->insert([
            'id_usuario' => $id_usuario,
            'id_curso'   => $data['id_curso'],
            'fecha_compra' => date('Y-m-d H:i:s')
        ]);

        return $this->respondCreated(['msg' => 'Compra registrada']);
    }


    public function cliente()
    {
        header('Access-Control-Allow-Origin: *');

        $email = $this->request->getGet('email');
        if (!$email) return $this->failValidationError('Falta el email');

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->where('email', $email)->first();

        if (!$usuario) return $this->respond([]);

        $compraModel = new CompraModel();
        $datos = $compraModel
            ->select('cursos.nombre, cursos.imagen, cursos.precio, compras.fecha_compra, compras.id_compra')
            ->join('cursos', 'cursos.id_curso = compras.id_curso')
            ->where('compras.id_usuario', $usuario['id_usuario'])
            ->findAll();

        return $this->respond($datos);
    }

    public function resumen()
    {
        header('Access-Control-Allow-Origin: *');
        
        $compraModel = new CompraModel();
        $datos = $compraModel
            ->select('cursos.id_curso, cursos.nombre, COUNT(compras.id_compra) as total_compras')
            ->join('cursos', 'cursos.id_curso = compras.id_curso')
            ->groupBy('cursos.id_curso')
            ->findAll();

        return $this->respond($datos);
    }

    public function options()
{
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    return $this->response->setStatusCode(200);
}
}
