<?php
namespace App\Models\ORM;
use App\Models\IApiControler;
use App\Models\AutentificadorJWT;
use App\Models\ORM\empleado;

include_once __DIR__ . '/pedido.php';
include_once __DIR__ . '/empleado.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';
include_once __DIR__ . '../../modelAPI/AutentificadorJWT.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \Exception;


class pedidoControler implements IApiControler
{
    public function ModificarUno($request, $response, $args) {}
    public function TraerUno($request, $response, $args) {}
    public function BorrarUno($request, $response, $args) {}

    public function TraerTodos($request, $response, $args) {
        $token = $request->getHeader('token');
        $datosToken = AutentificadorJWT::ObtenerData($token[0]);

        if($datosToken->tipo == 'socio'){
            $empleado= pedido::all();
        }
        else{
            $empleado = pedido::where('id_empleado', $datosToken->id)->get();
        }
        return $response->withJson($empleado, 200);
    }

    public function CargarUno($request, $response, $args)
    {
        $datos = $request->getParsedBody();
        $token = $request->getHeader('token');
        $datosToken = AutentificadorJWT::ObtenerData($token[0]);

        if(isset($datos['nombrePedido'],$datos['nombreCliente']) && $datosToken->estado == 'activo' && $datosToken->tipo == "mozo")
        {
            $empleado= empleado::where('id',$datosToken->id);

            if($empleado != null)
            {
                $pedido = new pedido();
                $pedido->id_empleado = $datosToken->id;
                $pedido->nombreCliente= $datos['nombreCliente'];
                $pedido->nombrePedido= $datos['nombrePedido'];
                $pedido->estado = 'Pendiente'; // pendiente || en preparacion || listo para servir
                if(isset($datos['idMesa'])){
                    $pedido->id_mesa =$datos['idMesa'];
                }
                else{
                    $pedido->id_mesa = substr(md5(uniqid(rand(), true)), 0, 5);
                }
                if(($datos['tipo']== 'bartender')  ||
                ($datos['tipo']== 'cervecero')  ||
                ($datos['tipo']== 'cocinero')  ||
                ($datos['tipo']== 'mozo')  ||
                ($datos['tipo']== 'socio') )
                {
                  $pedido->tipo = $datos['tipo'];
                  $pedido->save();
                  return $response->withJson("Pedido en preparacion. Id Mesa:". $pedido->id_mesa .", cliente:". $datos['nombreCliente'], 200);
                }
                else{
                  return $response->withJson("Tipo de pedido invalido para Id Mesa:". $pedido->id_mesa .", cliente:". $datos['nombreCliente'], 200);
                }
            }
            return $response->withJson("No existe el empleado ", 200);
        }
        return $response->withJson("Faltan datos o el empleado no tiene un estado activo, o no es mozo", 200);
    }

    public function PrepararPedido($request, $response, $args)
    {
        $datos = $request->getParsedBody();
        $idPedido = $args['idPedido'];
        $token = $request->getHeader('token');
        $datosToken = AutentificadorJWT::ObtenerData($token[0]);
        $empleado = empleado::where('id', $datosToken->id)->first();

        if($empleado != null  && $empleado["estado"] == "activo")
        {
            if(isset($datos['tiempoEstimadoEnMs']))
            {
                $pedido = pedido::where('id', $idPedido)->first(); ///////!!!!!!!!!!!!!!!!!!!!//////
                if($pedido != null && $pedido['estado'] != 'Entregado' && $pedido['tipo'] == $empleado["tipo"]  )
                {
                    $pedido->estado = 'En Preparacion';
                    $pedido->tiempo_preparacion = AutentificadorJWT::CrearToken("tiempoPreparacion", $datos['tiempoEstimadoEnMs']);
                    $pedido->save();

                    $newResponse = $response->withJson("Pedido: $idPedido se encuentra en preparación", 200);
                }
                else
                {
                    $newResponse = $response->withJson("No encontró el pedido $idPedido,  o ya fue entregado", 200);
                }
            }
            else
            {
                $newResponse = $response->withJson("No se estableció el tiempo estimado", 200);
            }
        }
        else
        {
            $newResponse = $response->withJson("Falta id del pedido, o empleado suspendido", 200);
        }
        return $newResponse;
    }

    public function ServirPedido($request, $response, $args)
    {
        $idPedido = $args['idPedido'];
        $token = $request->getHeader('token');
        $datosToken = AutentificadorJWT::ObtenerData($token[0]);
        $pedido=null;
        $empleado = empleado::where('id', $datosToken->id)->first();

        if($empleado != null && $empleado["estado"] == "activo" && $empleado["tipo"] == "mozo"){
            $pedido = pedido::where('id', $idPedido)->first();
        }

        if($pedido != null && $pedido['estado'] != 'Entregado' )
        {
            try
            {
                AutentificadorJWT::VerificarToken($pedido['tiempo_preparacion']);
                return  $response->withJson("Pedido $idPedido aun no finalizado", 200);
            }
            catch(Exception $e)
            {
                $pedido->estado = "Listo Para Servir";
                $pedido->save();
                return $response->withJson("Pedido $idPedido Entregado", 200);
            }
        }
        return $response->withJson("No se encontró el pedido $idPedido, o ya fue entregado, o empleado suspendido", 200);;
    }
}
?>
