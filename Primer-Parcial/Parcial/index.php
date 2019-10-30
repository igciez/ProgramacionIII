<?php
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'vendor/autoload.php';
require_once 'clases/pizza.php';

$config ['displayErrorDetails']=true;
$config ['addContentLengthHeader']= false;

$app=new \Slim\App(["settings"=> $config]);

/**
 * Ruta: pizzas​ (POST): se ingresa precio, Tipo (“molde” o “piedra”), cantidad( de unidades),sabor
*(muzza;jamón; especial), precio y dos imágenes (guardarlas en la carpeta images/pizzas y cambiarles el nombre
*para que sea único). Se guardan los datos en en el archivo de texto ​Pizza.xxx, ​tomando un id autoincremental
*como identificador, la combinación tipo - sabor debe ser única.
*campos: precio | tipo | cantidad | sabor | imagenUno | imagenDos
 */
$app->post('/pizza/nuevo',function (Request $request, Response $response){
    $arrayDeParametros = $request->getParsedBody();
    $imagenUno = $_FILES["imagenUno"];
    $imagenDos = $_FILES["imagenDos"]; 
    $objeto = new Pizza();
    $objeto->pizzas($arrayDeParametros,$imagenUno,$imagenDos);    
    $newResponse = "";
    return $newResponse;
});

/**
 *  ​Ruta: pizzas​: (GET): Recibe Sabor y Tipo, si coincide con algún registro del archivo ​Pizza.xxx, ​retornar la
*cantidad de producto disponible, de lo contrario informar si no existe el tipo o el sabor. La consulta debe ser ​case
*insensitiv
*campos: Sabor | Tipo
 */
$app->get('/pizza/consulta',function (Request $request, Response $response){
    $arrayDeParametros = $request->getQueryParams();
    $objeto = new Pizza();
    $objeto->consultarPizzas($arrayDeParametros);
    $newResponse='';
    return $newResponse;
});


$app->run();
?>