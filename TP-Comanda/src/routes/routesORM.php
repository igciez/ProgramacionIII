<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\Middleware;
use App\Models\ORM\empleado;
use App\Models\ORM\pedido;
use App\Models\ORM\empleadoControler;
use App\Models\ORM\pedidoControler;

include_once __DIR__ . '/../../src/app/modelORM/empleado.php';
include_once __DIR__ . '/../../src/app/modelORM/pedido.php';
include_once __DIR__ . '/../../src/app/modelORM/empleadoControler.php';
include_once __DIR__ . '/../../src/app/modelORM/pedidoControler.php';
include_once __DIR__ . '/../../src/app/middlewares/middlewaresRoutes.php';

return function (App $app) {
    $container = $app->getContainer();

    $app->group('/comandaORM', function () { 
        $this->post('/empleado/cargar',empleadoControler::class . ':CargarUno' );
        $this->post('/empleado/login',empleadoControler::class . ':LoginEmpleado' );
        $this->post('/empleado/suspender/{id}', empleadoControler::class . ':SuspenderEmpleado');
        $this->post('/empleado/eliminar/{id}', empleadoControler::class . ':BorrarUno');
        $this->post('/pedido/cargar', pedidoControler::class . ':CargarUno')->add(Middleware::class . ':validarRuta');
        $this->get('/pedido/ver', pedidoControler::class . ':TraerTodos')->add(Middleware::class . ':validarRuta');
        $this->post('/pedido/preparar/{idPedido}', pedidoControler::class . ':PrepararPedido')->add(Middleware::class . ':validarRuta');       
        $this->post('/pedido/entregar/{idPedido}', pedidoControler::class . ':ServirPedido')->add(Middleware::class . ':validarRuta');
    });
};
?>