<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('usuarios/celular', 'Usuarios::buscarPorCelular');
$routes->get('usuarios/email', 'Usuarios::showByEmail');

$routes->get('/comprar', 'ComprasController::comprar');
$routes->post('/comprar', 'ComprasController::comprar');

$routes->get('/admin/resumen', 'AdminController::resumenCompras');

// Rutas RESTful de cursos
$routes->resource('cursos'); // Esto reemplaza los GET, POST, PUT, DELETE manuales


$routes->options('(:any)', 'Cors::options');


$routes->group('compras', function($routes) {
    $routes->get('/', 'Compras::index');
    $routes->post('/', 'Compras::create');
    $routes->options('/', 'Compras::options');
    $routes->get('cliente', 'Compras::cliente');   // /compras/cliente?email=
    $routes->get('resumen', 'Compras::resumen');
    $routes->get('mis-compras', 'ComprasController::misCompras');
});
