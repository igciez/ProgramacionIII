<?php 

require_once 'funciones/index.php';

class Servicio{

    public $id;
    public $tipo;
    public $precio;
    public $demora;

    function _construct($id, $tipo, $precio, $demora){
        $this->id=$id;
        $this->tipo=$tipo;        
        $this->precio=$precio;
        $this->demora=$demora;
    }

    function cargarTipoServicio($arrayDeParametros){
        $valorRetornado=false;
        $auxArray;
        //$arrayDeParametrosDos = array();
        $arrayDeParametrosDos = leer("tiposServicio.txt");
        
        //busca el valor en ambos arrays y
        //si lo encuentra devuelve el indice.
        if($arrayDeParametrosDos){
            foreach($arrayDeParametrosDos as $key => $val){
                $auxArray= (array)$val;
                //$valorRetornado=false;
                if($auxArray){
                    if($auxArray['id']===$arrayDeParametros['id']){
                        $valorRetornado=true;
                        break;
                    }
                }   
            }
        }
        //Si no esta dentro del rango del 'tipo', 
        //entonces no se puede setear el campo tip
        if($arrayDeParametros['tipo'] !== "10000" && $arrayDeParametros['tipo'] !== "20000" && $arrayDeParametros['tipo'] !== "50000"){
            $valorRetornado=true;
            echo('error, el "tipo" debe ser: 10000 o 20000 o 50000'."\n");
        }
        //si no encuentra devuelve false,
        //entonces guardo en el archivo
        if(!$valorRetornado){
            echo ('se guardo el obj: porque no esta repetiro');
            $this->_construct($arrayDeParametros['id'],$arrayDeParametros['tipo'],$arrayDeParametros['precio'],$arrayDeParametros['demora']);
            guardar("tiposServicio.txt", $this, "a");
        }
        else{
            echo('no se pudo guardar: porque el obj esta repetido o fuera de rango del "tipo"');
        }       
    }
}

?>