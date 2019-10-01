<?php
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'vendor/autoload.php';
require_once 'clases/vehiculo.php';
require_once 'clases/servicio.php';
require_once 'clases/turno.php';

$config ['displayErrorDetails']=true;
$config ['addContentLengthHeader']= false;

$app=new \Slim\App(["settings"=> $config]);

/**
 * 1)cargarVehiculo (post):Se deben guardar los siguientes datos: marca, modelo, patente y precio. Los
 *datos se guardan en el archivo de texto vehiculos.txt, 
 *tomando la patente como identificador(la patente no
 *puede estar repetida).
 * campos: marca | modelo | patente | precio | foto
 */
$app->post('/vehiculo/nuevo',function (Request $request, Response $response){
    $arrayDeParametros = $request->getParsedBody();
    $foto = $_FILES["foto"]; 
    $objeto = new Vehiculo();
    $objeto->cargarVehiculo($arrayDeParametros,$foto);
    $newResponse = $response->withJson($objeto,200);
    return $newResponse;
});

/**
 * 2)consultarVehiculo (get): Se ingresa marca, modelo o patente, 
 * si coincide con algún registro del archivo
 *se retorna las ocurrencias, 
 *si no coincide se debe retornar “No existe xxx” (xxx es lo que se buscó) La búsqueda
 *tiene que ser case insensitive.
 * campos: marca | modelo | patente
 */
$app->get('/vehiculo/consulta',function (Request $request, Response $response){
    $arrayDeParametros = $request->getQueryParams();
    $objeto = new Vehiculo();
    $objeto->consultarVehiculo($arrayDeParametros);
    $newResponse='';
    return $newResponse;
});

/**
 * cargarTipoServicio(post): Se recibe el nombre del servicio a realizar: id, 
 * tipo(de los 10.000km, 20.000km, 50.000km), precio y demora, 
 * y se guardara en el archivo tiposServicio.txt.
 * campos: id | tipo | percio | demora
 */
$app->post('/servicio/nuevo',function (Request $request, Response $response){
    $arrayDeParametros = $request->getParsedBody();
    $objeto = new Servicio();
    $objeto->cargarTipoServicio($arrayDeParametros);
    $newResponse = $response->withJson($objeto,200);
    return $newResponse;
});

/**
 * sacarTurno (get): Se recibe patente y fecha (día) [idServicio] y se debe guardar en el archivo turnos.txt, 
 * fecha, patente, marca, modelo, precio y tipo de servicio. 
 * Si no hay cupo o la materia no existe informar cada caso particular.
 * Campos: patente | idServicio
 */
$app->get('/turno/nuevo',function (Request $request, Response $response){
    $arrayDeParametros = $request->getQueryParams();
    $objeto = new Turno(); //-->cambio "fecha" por el campo "idServicio"
    $objeto->sacarTurno($arrayDeParametros);
    $newResponse='';
    return $newResponse;
});

/**
 * turnos(get): Se devuelve una tabla con todos los servicios.
 */
$app->get('/turno/consulta',function (Request $request, Response $response){
    $objeto = new Turno();
    $objeto->turnos();
    $newResponse='';
    return $newResponse;
});

/**
 * inscripciones(get): Puede recibir el tipo de servicio o la fecha [cambio fecha por patente] y 
 * filtra la tabla de acuerdo al parámetro pasado.
 * campos: tipoServicio | patente
 */
$app->get('/turno/inscripciones',function (Request $request, Response $response){
    $arrayDeParametros = $request->getQueryParams();
    $objeto = new Turno(); 
    $objeto->inscripciones($arrayDeParametros);
    $newResponse='';
    return $newResponse;
});

/**
 * modificarVehiculo(post): Debe poder modificar todos los datos del vehículo menos la patente y 
 * se debe cargar una imagen, si ya existía una guardar la foto antigua en la carpeta /backUpFotos , 
 * el nombre será patente y la fecha.
 * campos: marca | modelo | patente | precio | foto
 */
$app->post('/vehiculo/modificar',function (Request $request, Response $response){
    $arrayDeParametros = $request->getParsedBody();
    $foto = $_FILES["foto"]; 
    $objeto = new Vehiculo();
    $objeto->modificarVehiculo($arrayDeParametros,$foto);
    $newResponse = $response->withJson($objeto,200);
    return $newResponse;
});

/**
 * vehiculos(get): Mostrar una tabla con todos los datos de los vehículos, incluida la foto.
 * Para visualizar las imagenes, abrir la direccion en chrome.
 */
$app->get('/vehiculo/tabla',function (Request $request, Response $response){
    $objeto = new Vehiculo();
    $objeto->vehiculos();
    $newResponse='';
    return $newResponse;
});

$app->run();

?>