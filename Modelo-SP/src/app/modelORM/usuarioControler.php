<?php
namespace App\Models\ORM;
use App\Models\ORM\usuario;
use App\Models\ORM\materia;
use App\Models\ORM\profesor_materia;
use App\Models\IApiControler;// --> si se va a usar un metodo????.
use App\Models\AutentificadorJWT;

include_once __DIR__ . '/usuario.php'; //--->si se va a usar un objeto (una clase)????
include_once __DIR__ . '/profesor_materia.php';
include_once __DIR__ . '/materia.php';
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

    public function CargarUno($request, $response, $args) {
        $datos = $request->getParsedBody();
        $archivos = $request->getUploadedFiles();

        if(isset($datos['email'], $datos['clave'], $datos['tipo']))
        {
            $usuario = new usuario();
            $usuario->email = $datos['email'];
            $usuario->clave = crypt($datos['clave'], self::$claveSecreta); //llamo a la variable estática
                
            if(strcasecmp($datos['tipo'],'alumno') == 0 ||
                strcasecmp($datos['tipo'],'admin') == 0 ||
                strcasecmp($datos['tipo'],'profesor') == 0)
            {   
                $usuario->tipo = $datos['tipo'];
            }

            if($archivos != null)
            {
            $usuario->foto = usuarioControler::GuardarArchivoTemporal($archivos['foto'], __DIR__ . "../../../../img/",
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

        $usuarioAModificar = null;
        $seGuardoUsuario=false;
        $datosModificados = $request->getParsedBody();
        $archivos = $request->getUploadedFiles();
        // $legajo = $request->getParam('legajo'); //legajo que le paso por param
        $legajo = $request->getAttribute('legajo');//si se lo paso por url
        $token = $request->getHeader('token');
        $datosToken = AutentificadorJWT::ObtenerData($token[0]);
        $usuarioAModificar= usuario::where('legajo', $legajo)->first();

        if($usuarioAModificar != null && $datosToken->legajo == $usuarioAModificar->legajo ){ 
            switch($datosToken->tipo)
            {   
                case 'alumno':
                $usuarioAModificar->email = $datosModificados['email'];
                //usuarioControler::HacerBackup(__DIR__ . "../../../../img/", $usuarioAModificar);
                $usuarioAModificar->foto = usuarioControler::GuardarArchivoTemporal($archivos['foto'], __DIR__ . "../../../../img/",
                    $usuarioAModificar->legajo.$usuarioAModificar->tipo);
                $usuarioAModificar->save();
                $seGuardoUsuario=true;
                break;

                case 'profesor':
                $usuarioAModificar->email = $datosModificados['email']; //se modifica el email del profesor en la tabla usuarios
                profesor_materia::where('id_profesor', $usuarioAModificar->legajo)->delete();//borro todas las materias del profesor
                // var_dump($datosModificados['materiasDictadas']);
                foreach($datosModificados['materiasDictadas'] as $idMateria)
                {//para pasar array por postman -> key = materiasDictadas[0] value = materiaUno
                    $materia = materia::where('nombre',$idMateria )->first();
                    $profesorMateria = new profesor_materia();
                    $profesorMateria->id_profesor = $usuarioAModificar->legajo;
                    $profesorMateria->id_materia = $materia['id'];
                    $profesorMateria->save();
                }                 
                $usuarioAModificar->save();
                $seGuardoUsuario=true;
                break;

                case 'admin':
                    $usuarioAModificar->email = $datosModificados['email'];
                    $usuarioAModificar->foto = usuarioControler::GuardarArchivoTemporal($archivos['foto'], __DIR__ . "../../../../img/",
                    $usuarioAModificar->legajo.$usuarioAModificar->tipo);
                    foreach($datosModificados['materiasDictadas'] as $idMateria)
                    {
                        $materia = materia::where('nombre',$idMateria )->first();
                        $profesorMateria = new profesor_materia();
                        $profesorMateria->id_profesor = $usuarioAModificar->legajo;
                        $profesorMateria->id_materia = $materia['id'];
                        $profesorMateria->save();
                        $seGuardoUsuario=true;
                    }
                    $usuarioAModificar->save();
                    
                break;
            }
        }         
        else
        {
            return $response->withJson("Error, El legajo no corresponde a un usuario", 200);
        }
        if($seGuardoUsuario){
            return $response->withJson("Usuario modificado correctamente", 200);
        }

		return 	$response->withJson("Error, el usuario no pudo guardarse, verifique el tipo de usuario", 200);
    }

    //Remplazo campo: "nombre" por "clave".
    public function LoginUsuario($request, $response, $args)
    {
        $datos = $request->getParsedBody();
        
        if(isset($datos["legajo"], $datos["clave"]))
        {
            $legajo= $datos["legajo"];
            $clave=$datos["clave"];

            $usuario = usuario::where('legajo',$legajo )->first();
            
            
            if($usuario != null)
            {
                if(hash_equals($usuario->clave, crypt($clave, self::$claveSecreta)))
                {
                    $datosUsuario = array(
                        'email' => $usuario->email,
                        'legajo' => $usuario->legajo,
                        'tipo' => $usuario->tipo
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