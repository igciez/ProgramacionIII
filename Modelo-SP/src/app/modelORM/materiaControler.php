<?php
namespace App\Models\ORM;
use App\Models\ORM\materia;
use App\Models\ORM\inscripcion_alumno;
use App\Models\ORM\profesor_materia;
use App\Models\IApiControler;// --> si se va a usar un metodo.
use App\Models\AutentificadorJWT;

include_once __DIR__ . '/materia.php'; //--->si se va a usar un objeto (una clase)
include_once __DIR__ . '/inscripcion_alumno.php';
include_once __DIR__ . '/profesor_materia.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';
include_once __DIR__ . '../../modelAPI/AutentificadorJWT.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class materiaControler implements IApiControler 
{
    public function TraerTodos($request, $response, $args) {
        $token = $request->getHeader('token'); 
        $datos = AutentificadorJWT::ObtenerData($token[0]);
        
        switch ($datos->tipo) {
            case 'alumno':
                $aux = inscripcion_alumno::where('id_alumno',$datos->legajo )
                ->join('materias', 'inscripcion_alumnos.id_materia', '=', 'materias.id')
                ->select('materias.nombre', 'materias.cuatrimestre')
                ->get();
                $newResponse = $response->withJson($aux, 200);
                break;
            case 'profesor':
                $aux = profesor_materia::where('id_profesor', $datos->legajo)
                ->join('materias', 'profesor_materias.id_materia', '=', 'materias.id')
                ->select('materias.nombre', 'materias.cuatrimestre')
                ->get();
                $newResponse = $response->withJson($aux, 200);
                break;
            case 'admin':
                $aux = materia::all();
                $newResponse = $response->withJson($aux, 200);
                break;            
            default:
                $newResponse = $response->withJson("Error, Tipo de usuario invalido", 200);
                break;
        }        
        return  $newResponse;       
    }
    public function TraerUno($request, $response, $args) {
        $token = $request->getHeader('token');
        $datosToken = AutentificadorJWT::ObtenerData($token[0]);
        $usuario = usuario::where('legajo', $datosToken->legajo)->first();
        $idMateria = $args['id'];

        switch($usuario->tipo)
        {
            case 'admin':
                $datos = inscripcion_alumno::where('id_materia', $idMateria)
                        ->join('usuarios', 'inscripcion_alumnos.id_alumno', '=', 'usuarios.legajo')
                        ->select('usuarios.legajo', 'usuarios.email', 'usuarios.foto')
                        ->get();
                $newResponse = $response->withJson($datos, 200);
            break;

            case 'profesor':
                $dictaLaMateria = false;
                $materiasDictadas = profesor_materia::where('id_profesor', $usuario->legajo)->get();
        
                foreach($materiasDictadas as $auxMateria)
                {
                    if($auxMateria->id_materia == $idMateria)
                    {
                        $dictaLaMateria = true;
                    }
                }

                if($dictaLaMateria == true)
                {
                    $datos = alumno_materia::where('id_materia', $idMateria)
                        ->join('usuarios', 'alumno_materias.id_alumno', '=', 'usuarios.legajo')
                        ->select('usuarios.legajo', 'usuarios.email', 'usuarios.foto')
                        ->get();
                    $newResponse = $response->withJson($datos, 200);
                }
                else
                {
                    $newResponse = $response->withJson('No dicta la materia', 200);
                }
                break;

            default:
                $newResponse = $response->withJson('No tiene permiso para acceder', 200);
                break;
        }        
        return $newResponse;        
    }
    
    public function CargarUno($request, $response, $args) {
        $datos = $request->getParsedBody();      
        
        if(isset($datos['nombre'], $datos['cuatrimestre'], $datos['cupos']))
        {
            $materia = new materia();
            $materia->nombre = $datos['nombre'];
            $materia->cuatrimestre = $datos['cuatrimestre'];
            $materia->cupos = $datos['cupos'];
            
            $materia->save();
        
            $newResponse = $response->withJson("Materia cargada", 200); 
        }
        else{
            $newResponse = $response->withJson("No se completaron los campos necesarios", 200); 
        }

        return $newResponse;
    }

    public function InscripcionMateria($request, $response, $args)
    {
        $puedeInscribirse=false;
        $argsIdMateria= $args['idMateria'];
        $materia = materia::where('id',$argsIdMateria )->first();
        $inscripcion_alumno= inscripcion_alumno::where('id_materia',$argsIdMateria )->first();
        $token = $request->getHeader('token'); 
        $datos = AutentificadorJWT::ObtenerData($token[0]);
        
        if( $materia != null &&  $materia->cupos > 0)  
        {
            if($inscripcion_alumno == null){
                $puedeInscribirse=true;
            }
            else if($inscripcion_alumno->id_materia != $argsIdMateria || $inscripcion_alumno->id_alumno != $datos->legajo)
            {
                $puedeInscribirse=true; 
            }

            if($puedeInscribirse){
                $inscripcion_alumno= new inscripcion_alumno();
                $inscripcion_alumno->id_alumno=$datos->legajo;
                $inscripcion_alumno->id_materia=$argsIdMateria;
                $inscripcion_alumno->save();
    
                $materia->cupos-=1;
                $materia->save();
    
                return $response->withJson("Usuario se pudo inscribir", 200);
            }            
        }
        return $response->withJson("Error, Usuario no se pudo inscribir", 200);
    }
    
    public function BorrarUno($request, $response, $args) {}
    public function ModificarUno($request, $response, $args) {}
}

?>