<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\usuario;
use App\Models\ORM\usuarioControler;
// use App\Models\ORM\materia;
// use App\Models\ORM\materiaControler;
use App\Models\ORM\Middleware;


include_once __DIR__ . '/../../src/app/modelORM/usuario.php';
include_once __DIR__ . '/../../src/app/modelORM/usuarioControler.php';
// include_once __DIR__ . '/../../src/app/modelORM/materia.php';
// include_once __DIR__ . '/../../src/app/modelORM/materiaControler.php';
include_once __DIR__ . '/../../src/app/middlewares/middlewaresRoutes.php';

return function (App $app) {
    $container = $app->getContainer();

    $app->group('/usuariosORM', function () {   
        
        $this->post('/users',usuarioControler::class . ':CargarUno' );
        $this->post('/login',usuarioControler::class . ':LoginUsuario' );
        $this->put('/ingreso',usuarioControler::class . ':IngresoUsuario' )->add(Middleware::class. ':validarRuta');
        $this->put('/egreso',usuarioControler::class . ':EgresoUsuario' )->add(Middleware::class. ':validarRuta');        
        $this->get('/ingreso',usuarioControler::class . ':IngresoTodos' )->add(Middleware::class. ':validarRuta');
        $this->get('/ingresoUltimo',usuarioControler::class . ':UltimoIngreso' )->add(Middleware::class. ':validarRuta');
        // $this->post('/materia',materiaControler::class . ':CargarUno' )->add(Middleware::class. ':validarUsuarioAdmin');
        // $this->post('/usuario/{legajo}', usuarioControler::class . ':ModificarUno')->add(Middleware::class . ':validarRuta');
        // $this->post('/materia/{idMateria}', materiaControler::class . ':InscripcionMateria')->add(Middleware::class . ':validarUsuarioAlumn');
        // $this->get('/materias', materiaControler::class . ':TraerTodos')->add(Middleware::class . ':validarRuta');
        // $this->get('/materia/{id}', materiaControler::class . ':TraerUno')->add(Middleware::class . '::validarRuta');
    });

};
?>