<?php
/**
 * funcion que guardar un objeto,
 * en un archivo, bajo el formato JSON
 */
function guardar($nombreArchivo, $obj, $mode){
        $strigJs = json_encode($obj);
        //$mode = [a | w];
        $archivo = fopen($nombreArchivo, $mode);    
        fwrite($archivo, $strigJs.PHP_EOL);
        //fwrite($archivo, $strigJs);    
        fclose($archivo);
}

/**
 * funcion que devuelve un array y 
 * parsea a obj json
 */
function leer ($nombreArchivo){
    $arrayLineas = array();    
    $file = fopen($nombreArchivo, "r");

    if($file){
        while(!feof($file)){    
            $obj = json_decode(fgets($file));
            if($obj){
                array_push($arrayLineas, $obj);
            }            
        }
        fclose($file);
    }   
    return $arrayLineas;
} 

/**
 * recibe un array y un id, 
 * si lo encuentra elimina el indice del array.
 * devuelve un array sin lo que coinciden con el id.
 */
function borrar ($arrayLineas,$id){
    $valorRetornado=false;

    foreach ($arrayLineas as $key => $value) {
        $auxArray= (array)$value; 
        if($auxArray){
            if($auxArray["patente"] === $id){
                unset($arrayLineas[$key]);
                $valorRetornado=true;
                break;
            }
        }     
    }     
    if($valorRetornado){
        echo("Se Removio: ".$id."\n\n");
    }
    else{
        echo('No se encontro'."\n\n");
        $arrayLineas=null;
    }    
    return $arrayLineas;
}

/**
 * Modifica el array y 
 * lo devuelve
 */
// function modificar($arrayAmodificar,$nombreArchivo){
//     //obtengo el array
//     $arrayObtenido= leer($nombreArchivo);
//     //Obtengo el array sin el indice(id).
//     if($arrayObtenido){
//         $auxArrayIdBorrado= borrar($arrayObtenido,$arrayAmodificar['patente']);
//     } 
//     //var_dump($arrayAmodificar); 
//     //var_dump($auxArrayIdBorrado); 
//     //guardo todo de nuevo en el archivo.
//     if($auxArrayIdBorrado){
//         array_push($auxArrayIdBorrado, $arrayAmodificar);
//         var_dump($auxArrayIdBorrado); 
//         guardar($nombreArchivo, $auxArrayIdBorrado, "w");
//         echo ("\n".'Se modifico el array correctamente.');
//         //return $auxArrayIdBorrado;
//     }
//     else{
//         echo ('No se pudo modificar el array!!!');
//         //return null;
//     }
// }

function BackUp(){
    //ToDo
}


?>