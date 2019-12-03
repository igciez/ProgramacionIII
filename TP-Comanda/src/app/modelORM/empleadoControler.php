<?php
namespace App\Models\ORM;
use App\Models\IApiControler;
use App\Models\AutentificadorJWT;
use App\Models\ORM\empleado;

include_once __DIR__ . '../../modelAPI/IApiControler.php';
include_once __DIR__ . '../../modelAPI/AutentificadorJWT.php';
include_once __DIR__ . '/empleado.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class empleadoControler implements IApiControler
{
    private static $claveSecreta = 'calveSecreta'; // clave para encriptacion

    public function TraerTodos($request, $response, $args) {
       	//return cd::all()->toJson();
        // $todosLosCds=cd::all();
        // $newResponse = $response->withJson($todosLosCds, 200);
        // return $newResponse;
    }
    public function TraerUno($request, $response, $args) {
     	//complete el codigo
     	// $newResponse = $response->withJson("sin completar", 200);
    	// return $newResponse;
    }

    public function CargarUno($request, $response, $args) {
        $datos = $request->getParsedBody();

        if(isset($datos['nombre'], $datos['tipo'], $datos['apellido'],$datos['clave'] ) &&
        strlen($datos['nombre']) > 0 && strlen($datos['apellido']) > 0 && strlen($datos['clave']) > 0 )
        {
            $empleado = new empleado();
            $empleado->nombre = $datos['nombre'];
            $empleado->apellido = $datos['apellido'];
            $empleado->clave =crypt($datos['clave'], self::$claveSecreta);

            if(($datos['tipo']== 'bartender')  ||
                ($datos['tipo']== 'cervecero')  ||
                ($datos['tipo']== 'cocinero')  ||
                ($datos['tipo']== 'mozo')  ||
                ($datos['tipo']== 'socio') )
            {
                $empleado->tipo = $datos['tipo'];
                $empleado->save();
                $newResponse = $response->withJson("Empleado cargado", 200);
            }
            else{
                $newResponse = $response->withJson("Error, tipo ingresado incorrecto", 200);
            }
        }
        else
        {
            $newResponse = $response->withJson("Error, Faltan datos", 200);
        }

        return $newResponse;
    }

    public function BorrarUno($request, $response, $args) {
        $id = $args['id'];
        $empleado = empleado::where('id', $id)->first();

        if($empleado != null)
        {
            $empleado->delete();
            return $response->withJson("Empleado $id eliminado", 200);
        }
        return $response->withJson("No se encontro al empleado: $id", 200);
    }

    public function ModificarUno($request, $response, $args) {}

    public function SuspenderEmpleado($request, $response, $args){
        $id =  $args['id'];
        $empleado = empleado::where("id", $id)->first();

        if($empleado != null)
        {
            if($empleado->estado == 'activo')
            {
                $empleado->estado = 'suspendido';
                $empleado->save();

                return  $response->withJson("Se cambio el estado a Suspendido", 200);
            }
            return $response->withJson("El estado actual del empleado es $empleado->estado", 200);
        }
        return $response->withJson("No se encontro al empleado $id", 200);
    }


    public function LoginEmpleado($request, $response, $args)
    {
        $datos = $request->getParsedBody();

        if(isset($datos["nombre"],$datos["apellido"], $datos["clave"]))
        {
            $clave=$datos["clave"];
            $empleado = empleado::where('clave',crypt($clave, self::$claveSecreta))->get();

            if($empleado != null )
            {
                $nombre= $datos["nombre"];
                $apellido= $datos["apellido"];

                foreach ($empleado as $key => $value) {
                    if($value->nombre == $datos["nombre"] && $value->apellido == $datos["apellido"] && $value->estado == "activo" ){
                        $datosEmpleado = array(
                                            'nombre' => $value->nombre,
                                            'apellido' => $value->apellido,
                                            'id' => $value->id,
                                            'tipo' => $value->tipo,
                                            'estado'=>$value->estado,
                                        );
                        $token = AutentificadorJWT::CrearToken($datosEmpleado, 4600);
                        return $response->withJson($token, 200);
                    }
                }
            }
        }
        return $response->withJson('Empleado no encontrado', 200);
    }

    public static function GuardarArchivoTemporal($archivo, $destino, $nombre)
    {
        $origen = $archivo->getClientFileName();

        $fecha = new \DateTime();
        $fecha = $fecha->setTimezone(new \DateTimeZone('America/Argentina/Buenos_Aires'));
        $fecha = $fecha->format("d-m-Y-His");

        $extension = pathinfo($archivo->getClientFileName(), PATHINFO_EXTENSION);

        $destino = "$destino$nombre-$fecha.$extension";

        $archivo->moveTo($destino);

        return $destino;
    }
}
