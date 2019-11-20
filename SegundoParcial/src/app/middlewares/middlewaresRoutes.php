<?php

namespace App\Models\ORM;

use App\Models\ORM\usuario;//ruta completa de la clase
use App\Models\AutentificadorJWT;

include_once __DIR__ . '../../modelAPI/AutentificadorJWT.php';


class Middleware
{
    public static function validarUsuarioAdmin($request, $response, $next)
    {
        $token = $request->getHeader('token');     
        $esValido = false;

        try
        {
            AutentificadorJWT::VerificarToken($token[0]);
            $datos = AutentificadorJWT::ObtenerData($token[0]);
            $usuario = usuario::where('legajo', $datos->legajo)->first();
            
            if( $datos->tipo == 'admin' && (strcasecmp($usuario->tipo, 'admin') == 0 )){
                $esValido = true;
            }
            else
            {
                $newResponse = $response->withJson("No es Admin", 200);
            }            
        }
        catch(Exception $e)
        {
            $newResponse = $response->withJson($e->getMessage(), 200);
        }

        if($esValido)
        {
            $newResponse = $next($request, $response); 
        }                
            
        return $newResponse;
    }


    public static function validarRuta($request, $response, $next)
    {
        $token = $request->getHeader('token');
        
        try
        {
            AutentificadorJWT::VerificarToken($token[0]);            
            return $next($request, $response);
        }
        catch(Exception $e)
        {
            return $response->withJson($e->getMessage(), 200);
        }
    }

    public static function validarUsuarioAlumn($request, $response, $next)
    {
        $token = $request->getHeader('token');    

        try
        {
            AutentificadorJWT::VerificarToken($token[0]);
            $datos = AutentificadorJWT::ObtenerData($token[0]);
            if( $datos->tipo == 'alumno'){
                return $next($request, $response);
            }
            return $response->withJson("No es alumno", 200);
        }
        catch(Exception $e)
        {
            return $response->withJson($e->getMessage(), 200);
        }
    }
}
?>