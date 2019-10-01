<?php 

require_once 'funciones/index.php';

class Turno{

    public $fecha;    
    public $patente;
    public $marca;
    public $modelo;
    public $precio;
    public $tipoServicio;

    function _construct($fecha, $patente,$marca,$modelo, $precio,$tipoServicio){
        $this->fecha=$fecha;
        $this->patente=$patente;
        $this->marca=$marca;
        $this->modelo=$modelo;
        $this->precio=$precio;
        $this->tipoServicio=$tipoServicio;
    }

    function sacarTurno($arrayDeParametros){
        $valorRetornado=false;
        $arrayDeParametrosTurnos = leer("turnos.txt");
        $arrayDeParametrosVehiculos = leer("vehiculos.txt");
        $arrayDeParametrosServicio = leer("tiposServicio.txt");
        
        if($arrayDeParametrosVehiculos && $arrayDeParametrosServicio){

            if($arrayDeParametrosTurnos){ 
                //busco que el id ingresado ya no este asignado a otro turno
                foreach($arrayDeParametrosTurnos as $key => $val ){
                    $auxArrayTurnos= (array)$val;
                    if($auxArrayTurnos){
                        if($auxArrayTurnos['patente']===$arrayDeParametros['patente']){
                            $valorRetornado=true;
                            break;
                        }
                    }
                }
            }
            if(!$valorRetornado || !$arrayDeParametrosTurnos ){
                //si id ingresado no esta asignado a otro turno, obtengo los valores del vehiculo
                foreach($arrayDeParametrosVehiculos as $key => $val){
                    $auxArrayVehiculos= (array)$val;
                    
                    if($auxArrayVehiculos){
                        if($auxArrayVehiculos['patente']===$arrayDeParametros['patente']){                                 
                            foreach($arrayDeParametrosServicio as $key => $val){
                                $auxArrayServicio= (array)$val;
                                
                                if($auxArrayServicio){
                                    if($auxArrayServicio['id']===$arrayDeParametros['idServicio']){
                                        echo ('se guardo el obj');
                                        //$fecha, $patente,$marca,$modelo, $precio,$tipoServicio
                                        $this->_construct($auxArrayServicio['demora'],$arrayDeParametros['patente'],
                                                $auxArrayVehiculos['marca'],$auxArrayVehiculos['modelo'],$auxArrayVehiculos['precio'],$arrayDeParametros['idServicio']);
                                        guardar("turnos.txt", $this, "a");
                                        $valorRetornado=true;
                                        break;
                                    }
                                }
                            }
                        }
                    }   
                }
            }
        }       
        if(!$valorRetornado){
            echo('no se pudo guardar, porque la patente o el id del servicio, no se encuentra');
        }       
    }
    /**
     * Funcion que genera una tabla,
     * en base a los datos ingresados.
     */
    function turnos(){
        $valorRetornado=false;
        $arrayDeParametrosTurnos = leer("turnos.txt");
        $tabla;

        if( $arrayDeParametrosTurnos){
            $tabla="<table border='1'>
                <caption>Turnos</caption>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Patente</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Precio</th>
                        <th>Tipo Servicio</th>
                    </tr>
                </thead>
            <tabody>";
            foreach($arrayDeParametrosTurnos as $key => $val){
                $auxArray= (array)$val;
                $tabla= $tabla."<tr>
                                <td>".$auxArray['fecha']."</td>
                                <td>".$auxArray['patente']."</td>
                                <td>".$auxArray['marca']."</td>
                                <td>".$auxArray['modelo']."</td>
                                <td>".$auxArray["precio"]."</td>
                                <td>".$auxArray["tipoServicio"]."</td>
                                </tr>";
            }
            $tabla = $tabla."</tbody>
                            </table>";
            echo $tabla;
        }
        else{
            echo('No se pudo abrir el archivo');
        }
    }

    function inscripciones($arrayDeParametros){
        $valorRetornado=false;
        $arrayDeParametrosTurnos = leer("turnos.txt");
        $tabla;

        if( $arrayDeParametrosTurnos){
            $tabla="<table border='1'>
                    <caption>Turnos</caption>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Patente</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Precio</th>
                            <th>Tipo Servicio</th>
                        </tr>
                    </thead>
                <tabody>";            
            foreach ($arrayDeParametrosTurnos as $key => $val) {
                $auxArray= (array)$val;

                if($auxArray['tipoServicio'] === $arrayDeParametros['tipoServicio'] || $auxArray['patente'] === $arrayDeParametros['patente'] ){
                    $valorRetornado=true;
                    $tabla= $tabla."<tr>
                                <td>".$auxArray['fecha']."</td>
                                <td>".$auxArray['patente']."</td>
                                <td>".$auxArray['marca']."</td>
                                <td>".$auxArray['modelo']."</td>
                                <td>".$auxArray["precio"]."</td>
                                <td>".$auxArray["tipoServicio"]."</td>
                                </tr>";
                }
            }

            if($valorRetornado){
                $tabla = $tabla."</tbody>
                </table>";
                echo $tabla;
            }
            else{
                echo('No se encontraron ocurrencias.');
            }
        }
    }
}
?>