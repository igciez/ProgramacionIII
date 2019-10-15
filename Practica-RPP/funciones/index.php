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
            if($auxArray["id"] === $id){
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

function guardarInfoLog($request){
    $aux=$request->getUri();
    $method = $request->getMethod();
    $string='{Ruta: '.$aux->getBaseUrl().$aux->getPath().', Metodo: '.$method.', Date: '.date("F j, Y, g:i a").'}';
    var_dump($string);
    $archivo = fopen('info.log', 'a');    
    fwrite($archivo, $string.PHP_EOL);  
    fclose($archivo);
}

?>