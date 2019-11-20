<?php
namespace App\Models\ORM;
use App\Models\ORM\usuario;
use App\Models\ORM\ingreso;
// use App\Models\ORM\profesor_materia;
use App\Models\IApiControler;// --> si se va a usar un metodo????.
use App\Models\AutentificadorJWT;

include_once __DIR__ . '/usuario.php'; 
// include_once __DIR__ . '/profesor_materia.php';
include_once __DIR__ . '/ingreso.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';
include_once __DIR__ . '../../modelAPI/AutentificadorJWT.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class usuarioControler implements IApiControler 
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

    /**
     * se recibe email, clave, legajo(1 entre 1 y 1000) y dos imágenes (guardarlas en la carpeta
    *images/users y cambiarles el nombre para que sea único). No se podrá guardar la clave en texto plano. Todos las
    *datos deberán ser validados antes de guardarlos en la BD.
     */
    public function CargarUno($request, $response, $args) {
        $datos = $request->getParsedBody();
        $ruta=$request->getUri();
        $method = $request->getMethod();
        $archivos = $request->getUploadedFiles();


        if(isset($datos['email'], $datos['clave'], $datos['legajo'])  )
        {
            $usuario = new usuario();
            $usuario->email = $datos['email'];
            $usuario->legajo = $datos['legajo'];
            $usuario->ruta = $ruta->getBaseUrl().$ruta->getPath();
            $usuario->ip= "10001111";
            $usuario->metodo = $method;
            $usuario->clave = crypt($datos['clave'], self::$claveSecreta); 
            
            if(strcasecmp($datos['tipo'],'alumno') == 0 ||
            strcasecmp($datos['tipo'],'admin') == 0 ||
            strcasecmp($datos['tipo'],'profesor') == 0)
            {   
                $usuario->tipo = $datos['tipo'];
            }

            if($archivos != null)
            {   
                $usuario->imagenUno = usuarioControler::GuardarArchivoTemporal($archivos['imagenUno'], __DIR__ . "../../../../imagenes/users",
                $usuario->legajo.$usuario->tipo);   
                $usuario->imagenDos = usuarioControler::GuardarArchivoTemporal($archivos['imagenDos'], __DIR__ . "../../../../imagenes/users",
                $usuario->legajo.$usuario->tipo);
            }         

            $usuario->save();
            
            $newResponse = $response->withJson("Usuario cargado", 200);  
        }
        else
        {
            $newResponse = $response->withJson("Error, Falta dato", 200);  
        }
            
        return $newResponse;
    }
    
    public function BorrarUno($request, $response, $args) {
  		//complete el codigo
    //   $newResponse = $response->withJson("sin completar", 200);  
    //   return $newResponse;
    }
    
    public function ModificarUno($request, $response, $args) {

        // $usuarioAModificar = null;
        // $seGuardoUsuario=false;
        // $datosModificados = $request->getParsedBody();
        // $archivos = $request->getUploadedFiles();
        // // $legajo = $request->getParam('legajo'); //legajo que le paso por param
        // $legajo = $request->getAttribute('legajo');//si se lo paso por url
        // $token = $request->getHeader('token');
        // $datosToken = AutentificadorJWT::ObtenerData($token[0]);
        // $usuarioAModificar= usuario::where('legajo', $legajo)->first();

        // if($usuarioAModificar != null && $datosToken->legajo == $usuarioAModificar->legajo ){ 
        //     switch($datosToken->tipo)
        //     {   
        //         case 'alumno':
        //         $usuarioAModificar->email = $datosModificados['email'];
        //         //usuarioControler::HacerBackup(__DIR__ . "../../../../img/", $usuarioAModificar);
        //         $usuarioAModificar->foto = usuarioControler::GuardarArchivoTemporal($archivos['foto'], __DIR__ . "../../../../img/",
        //             $usuarioAModificar->legajo.$usuarioAModificar->tipo);
        //         $usuarioAModificar->save();
        //         $seGuardoUsuario=true;
        //         break;

        //         case 'profesor':
        //         $usuarioAModificar->email = $datosModificados['email']; //se modifica el email del profesor en la tabla usuarios
        //         profesor_materia::where('id_profesor', $usuarioAModificar->legajo)->delete();//borro todas las materias del profesor
        //         // var_dump($datosModificados['materiasDictadas']);
        //         foreach($datosModificados['materiasDictadas'] as $idMateria)
        //         {//para pasar array por postman -> key = materiasDictadas[0] value = materiaUno
        //             $materia = materia::where('nombre',$idMateria )->first();
        //             $profesorMateria = new profesor_materia();
        //             $profesorMateria->id_profesor = $usuarioAModificar->legajo;
        //             $profesorMateria->id_materia = $materia['id'];
        //             $profesorMateria->save();
        //         }                 
        //         $usuarioAModificar->save();
        //         $seGuardoUsuario=true;
        //         break;

        //         case 'admin':
        //             $usuarioAModificar->email = $datosModificados['email'];
        //             $usuarioAModificar->foto = usuarioControler::GuardarArchivoTemporal($archivos['foto'], __DIR__ . "../../../../img/",
        //             $usuarioAModificar->legajo.$usuarioAModificar->tipo);
        //             foreach($datosModificados['materiasDictadas'] as $idMateria)
        //             {
        //                 $materia = materia::where('nombre',$idMateria )->first();
        //                 $profesorMateria = new profesor_materia();
        //                 $profesorMateria->id_profesor = $usuarioAModificar->legajo;
        //                 $profesorMateria->id_materia = $materia['id'];
        //                 $profesorMateria->save();
        //                 $seGuardoUsuario=true;
        //             }
        //             $usuarioAModificar->save();
                    
        //         break;
        //     }
        // }         
        // else
        // {
        //     return $response->withJson("Error, El legajo no corresponde a un usuario", 200);
        // }
        // if($seGuardoUsuario){
        //     return $response->withJson("Usuario modificado correctamente", 200);
        // }

		// return 	$response->withJson("Error, el usuario no pudo guardarse, verifique el tipo de usuario", 200);
    }

    /**
     * login​: (POST): Recibe clave, email y legajo, si estos datos existen en la BD​, ​retornar un JWT, de lo
     * contrario informar lo ocurrido. La consulta debe ser ​case insensitive
     */
    public function LoginUsuario($request, $response, $args)
    {
        $datos = $request->getParsedBody();
        
        if(isset($datos["legajo"], $datos["clave"],  $datos["email"]))
        {
            $legajo= $datos["legajo"];
            $clave=$datos["clave"];

            $usuario = usuario::where('legajo',$legajo )->first();
            
            if($usuario != null && $usuario->email == $datos["email"] )
            {
                if(hash_equals($usuario->clave, crypt($clave, self::$claveSecreta)))
                {
                    $datosUsuario = array(
                        'email' => $usuario->email,
                        'legajo' => $usuario->legajo,
                        'clave' => $usuario->clave
                    );

                    $token = AutentificadorJWT::CrearToken($datosUsuario);

                    $newResponse = $response->withJson($token, 200);
                }
                else
                {
                    $newResponse = $response->withJson('Clave incorrecta', 200);
                }
            }
            else
            {
                $newResponse = $response->withJson('No se encontró al usuario', 200);
            }
        }
        else
        {
            $newResponse = $response->withJson('Faltan datos', 200);
        }

        return $newResponse;
    } 
    
    public function IngresoUsuario($request, $response, $args)
    {
        $token = $request->getHeader('token');
        $datosToken = AutentificadorJWT::ObtenerData($token[0]);
        $tokenLegajo= $datosToken->legajo;
        $auxUsuario= usuario::where('legajo',$tokenLegajo)->first();
        $auxIngreso=new ingreso();
        $auxDBingreso= ingreso::where('legajo',$tokenLegajo)->first();
        
        if( $auxUsuario != null && $auxDBingreso == null ){
            $auxIngreso->legajo=  $tokenLegajo;            
            $auxIngreso->save();
            $newResponse= "Usuario Ingresado: ".$auxUsuario->updated_at;
        }
        else if($auxDBingreso != null){
            $auxIngreso->legajo= $tokenLegajo;           
            $auxIngreso->save();
            $newResponse= "Usuario Reingresado: ".$auxDBingreso->updated_at;
        }
        else{
            $newResponse="El usuario es la primera vez que ha ingresado";
        }

        return $newResponse;
    }

    public function EgresoUsuario($request, $response, $args)
    {
        $token = $request->getHeader('token');
        $datosToken = AutentificadorJWT::ObtenerData($token[0]);
        $tokenLegajo= $datosToken->legajo;
        // $auxUsuario= usuario::where('legajo',$tokenLegajo)->first();
        // $auxIngreso=new ingreso();
        $auxDBingreso= ingreso::where('legajo',$tokenLegajo)->get();
        
        if( $auxDBingreso != null ){
            $fecha = new \DateTime();
            $fecha = $fecha->setTimezone(new \DateTimeZone('America/Argentina/Buenos_Aires'));
            $fecha = $fecha->format("d-m-Y-His");
            foreach ($auxDBingreso as $key => $value) {
                $value->legajo=  $tokenLegajo;
                $value->egreso= $fecha;          
                $value->save();
            }
            
            $newResponse= "Usuario Egreso: ".$fecha;
        }
        else{
            $newResponse="El usuario es la primera vez que ha ingresado";
        }

        return $newResponse;

    }

    public function IngresoTodos($request, $response, $args)
    {
        $token = $request->getHeader('token');
        $datosToken = AutentificadorJWT::ObtenerData($token[0]);
        $tokenLegajo= $datosToken->legajo;  
        
        $auxIngresos = ingreso::where('legajo', $tokenLegajo)->get();
        
        if($auxIngresos != null){
            $newResponse = $response->withJson($auxIngresos, 200);
        }
        else{
            $newResponse = $response->withJson("Error, No ha ingresado el usuario", 200);
        }

        return $newResponse;        
    }

    public function UltimoIngreso($request, $response, $args)
    {
        $token = $request->getHeader('token');
        $datosToken = AutentificadorJWT::ObtenerData($token[0]);
        $tokenLegajo= $datosToken->legajo;  
        
        $auxIngresos = ingreso::where('legajo', $tokenLegajo)->get();
        
        if($auxIngresos != null && $tokenLegajo < 100 ){
            $length = count($auxIngresos);
            $date=$auxIngresos[$length-1]->updated_at;
            var_dump($date);
            $newResponse = $response->withJson($auxIngresos[$length-1]->updated_at, 200);
        }
        else{
            $newResponse = $response->withJson("Error, No ha ingresado el usuario", 200);
        }

        return $newResponse;        
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