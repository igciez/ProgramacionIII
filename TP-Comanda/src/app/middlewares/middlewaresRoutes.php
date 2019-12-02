<?php

namespace App\Models\ORM;

use App\Models\ORM\usuario;//ruta completa de la clase
use App\Models\AutentificadorJWT;

include_once __DIR__ . '../../modelAPI/AutentificadorJWT.php';


class Middleware
{
    
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
}
?>