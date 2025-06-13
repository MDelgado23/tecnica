<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('usuarios/celular', 'Usuarios::buscarPorCelular');

$routes->get('cursos', 'Cursos::index');
$routes->post('cursos', 'Cursos::create');
$routes->options('cursos', 'Cursos::options');

$routes->get('/comprar', 'ComprasController::comprar');
$routes->post('/comprar', 'ComprasController::comprar');

$routes->get('usuarios', 'Usuarios::showByEmail');

$routes->get('/admin/resumen', 'AdminController::resumenCompras');

$routes->group('compras', function($routes) {
    $routes->get('/', 'Compras::index');
    $routes->post('/', 'Compras::create');
    $routes->options('/', 'Compras::options');
    $routes->get('cliente', 'Compras::cliente');   // /compras/cliente?email=
    $routes->get('resumen', 'Compras::resumen');
    $routes->get('mis-compras', 'ComprasController::misCompras');
});

