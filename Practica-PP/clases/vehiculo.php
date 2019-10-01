<?php 

require_once 'funciones/index.php';

class Vehiculo{

    public $marca;
    public $modelo;
    public $patente;
    public $precio;
    public $foto;

    function _construct($marca, $modelo, $patente, $precio, $foto){
        $this->marca=$marca;
        $this->modelo=$modelo;
        $this->patente=$patente;
        $this->precio=$precio;
        
        if($foto["name"]){
            $this->foto=$foto["name"];
            move_uploaded_file($foto["tmp_name"],"./imagenes/".$this->foto);
        }
        else{
            $this->foto=$foto["foto"];
        }
        
    }

    function cargarVehiculo($arrayDeParametros,$uploadedFiles){
        $valorRetornado=false;
        $auxArray;
        $arrayDeParametrosDos = leer("vehiculos.txt");
        
        //busca el valor en ambos arrays y
        //si lo encuentra devuelve el indice.
        if($arrayDeParametrosDos){
            foreach($arrayDeParametrosDos as $key => $val){
                $auxArray= (array)$val;
                //$valorRetornado=false;
                if($auxArray){
                    if($auxArray['patente']===$arrayDeParametros['patente']){
                        $valorRetornado=true;
                        break;
                    }
                }   
            }
        }     
        //si no encuentra devuelve false,
        //entonces guardo en el archivo
        if(!$valorRetornado){
            echo ('se guardo el obj: porque no esta repetiro');
            $this->_construct($arrayDeParametros['marca'],$arrayDeParametros['modelo'],$arrayDeParametros['patente'],$arrayDeParametros['precio'],$uploadedFiles);                
            guardar("vehiculos.txt", $this, "a");
        }
        else{
            echo('no se pudo guardar: porque el obj esta repetido');
        }        
    }

    function consultarVehiculo($arrayDeParametros){
        $auxArray;
        $valorRetornado=false;
        $contador=0;
        $arrayDeParametrosDos = leer("vehiculos.txt");

        if($arrayDeParametrosDos){ 
            foreach($arrayDeParametrosDos as $key => $val){
                $auxArray= (array)$val;          
                if($auxArray){
                    if(strtolower($auxArray['patente'])===strtolower($arrayDeParametros['patente']) || 
                        strtolower($auxArray['modelo'])===strtolower($arrayDeParametros['modelo']) || 
                        strtolower($auxArray['marca'])===strtolower($arrayDeParametros['marca']) ){
                        $contador++;
                        $valorRetornado=true;
                        echo('Ocurrencia '.$contador.':'.' Patente:'.$auxArray['patente'].' Marca:'.$auxArray['marca'].' Modelo:'.$auxArray['modelo']."\n");
                    }
                }   
            }
            if(!$valorRetornado){
                echo('No existe:'.' Patente:'.$arrayDeParametros['patente'].' Marca:'.$arrayDeParametros['marca'].' Modelo:'.$arrayDeParametros['modelo']);
            } 
        }
    }

    function modificarVehiculo($arrayDeParametros, $foto){
        $nombreArchivo="vehiculos.txt";    
        //obtengo el array
        $arrayObtenido= leer($nombreArchivo);
        //Obtengo el array sin el indice(id).
        if($arrayObtenido){
            $auxArrayIdBorrado= borrar($arrayObtenido,$arrayDeParametros['patente'], $foto);
        }  
        //guardo todo de nuevo en el archivo.
        if($auxArrayIdBorrado){            
            $this->_construct($arrayDeParametros['marca'],$arrayDeParametros['modelo'],$arrayDeParametros['patente'],$arrayDeParametros['precio'],$foto); 
            guardar("vehiculos.txt", $this, "w");

            foreach ($auxArrayIdBorrado as $key => $auxArray) {
                $value= (array)$auxArray;
                $this->_construct($value['marca'],$value['modelo'],$value['patente'],$value['precio'],$value);                
                guardar("vehiculos.txt", $this, "a");
            }
            echo ("\n".'Se modifico el array correctamente.');
        }
        else{
            echo ('No se pudo modificar el array!!!');
        }
    }

    function vehiculos(){
        
        $valorRetornado=false;
        $arrayDeParametrosVehiculos = leer("vehiculos.txt");
        $tabla;

        if( $arrayDeParametrosVehiculos){
            $tabla="<table border='1'>
                <caption>Vehiculos</caption>
                <thead>
                    <tr>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Patente</th>
                        <th>Precio</th>
                        <th>Foto</th>
                    </tr>
                </thead>
            <tabody>";
            foreach($arrayDeParametrosVehiculos as $key => $val){
                $auxArray= (array)$val;
                $tabla= $tabla."<tr>
                                <td>".$auxArray['marca']."</td>
                                <td>".$auxArray['modelo']."</td>
                                <td>".$auxArray['patente']."</td>
                                <td>".$auxArray['precio']."</td>
                                <td><img style='width: 100px; height: 100px;' src='../imagenes/".$auxArray['foto']."'></td>
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
}
?>