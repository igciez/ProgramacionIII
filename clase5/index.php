<?php
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$config ['displayErrorDetails']=true;
$config ['addContentLengthHeader']= false;

$app=new \Slim\App(["settings"=> $config]);

/*
$app->get('[/]',function (Request $request, Response $response){
    $response->getBody()->write("GET => Bienvenido!!");
    return $response;
}); //trae recursos   

$app->post('[/]',function (Request $request, Response $response){
    $response->getBody()->write("Post => Bienvenido!!");
    return $response;
});//Post:Cargar recursos
$app->put('[/]',function (Request $request, Response $response){
    $response->getBody()->write("Put => Bienvenido!!");
    return $response;
});//Put:modificar recursos
$app->delete('[/]',function (Request $request, Response $response){
    $response->getBody()->write("Delete => Bienvenido!!");
    return $response;
});// Delete: borrar recursos
*/

$app->get('/datos/',function (Request $request, Response $response){
    $datos= array('nombre'=> ' rogelio', ' apellido'=> 'agua', 'edad'=> 40);
    $newResponse= $response->withJson($datos,200);
    return $newResponse;
});

$app->post('/datos/',function (Request $request, Response $response){
    $ArrayDeParametros = $request->getParseBody();
    $objeto= new stdclass();
    $objeto->nombre=
)};

$app->run();

?>