<?php 

require_once 'funciones/index.php';


class Pizza{

    public $tipo;
    public $cantidad;
    public $sabor;
    public $precio;
    public $imagenUno;
    public $imagenDos;
    public $id;

    function _construct($tipo,$cantidad,$sabor,$precio,$imagenUno,$imagenDos,$id){
        $this->tipo=$tipo;
        $this->cantidad=$cantidad;
        $this->sabor=$sabor;
        $this->precio=$precio;
        $this->id=++$id;
        
        if(isset($imagenUno["name"]) && isset($imagenDos["name"]) ){
            $this->imagenUno=$this->tipo.$this->id.$imagenUno["name"];
            $this->imagenDos=$this->sabor.$this->id.$imagenDos["name"];
            move_uploaded_file($imagenUno["tmp_name"],"./imagenes/pizzas/".$this->tipo.$this->id.$this->imagenUno);
            move_uploaded_file($imagenDos["tmp_name"],"./imagenes/pizzas/".$this->sabor.$this->id.$this->imagenDos);
        }
        else{
            $this->imagenUno=$imagenUno;
            $this->imagenDos=$imagenDos;
        }
    }
/**
 * Tipo (“molde” o “piedra”), cantidad( de unidades),sabor
*(muzza;jamón; especial), precio y dos imágenes (guardarlas en la carpeta images/pizzas y cambiarles el nombre
*para que sea único). Se guardan los datos en en el archivo de texto Pizza.xxx, tomando un id autoincremental
*como identificador, la combinación tipo - sabor debe ser única.
 */
    function cargarPizza($arrayDeParametros,$imagenUno,$imagenDos){
        $valorRetornado=false;
        $auxArray;
        $arrayDeParametrosLeidos = leer("pizza.txt");
        $auxId;
        
        if($arrayDeParametrosLeidos){
            foreach($arrayDeParametrosLeidos as $key => $val){
                $auxArray= (array)$val;                
                if(isset($auxArray)){
                    if($auxArray['sabor']===$arrayDeParametros['sabor'] && $auxArray['tipo']===$arrayDeParametros['tipo'] ){
                        $valorRetornado=true;
                        break;
                    }
                    $auxId=$auxArray["id"];
                }   
            }
        }
        else{
            $auxId=0;
        }
        
        //si no encuentra devuelve false,
        //entonces guardo en el archivo  //muzza;jamón; especial
        if(!$valorRetornado){
            if(($arrayDeParametros['tipo'] === "molde" || $arrayDeParametros['tipo'] === "piedra") &&
            ($arrayDeParametros['sabor'] === 'muzza' || $arrayDeParametros['sabor'] === 'jamon' || $arrayDeParametros['sabor'] === 'especial')){
                echo ('se guardo el obj: porque no esta repetiro');
                $this->_construct($arrayDeParametros['tipo'],$arrayDeParametros['cantidad'],$arrayDeParametros['sabor'],$arrayDeParametros['precio'],$imagenUno,$imagenDos,$auxId);                
                guardar("pizza.txt", $this, "a");
            } 
            else{
                echo('no se pudo guardar: porque debe elegir tipo=molde o piedra; o, Sabor= muzza o jamon o especial');
            }            
        }
        else{
            echo('no se pudo guardar: porque el obj esta repetido');
        } 
    }

    /**
 * 2- (2 pts.) Ruta: pizzas : (GET): Recibe Sabor y Tipo, si coincide con algún registro del archivo Pizza.xxx, retornar la
*cantidad de producto disponible, de lo contrario informar si no existe el tipo o el sabor. La consulta debe ser case
*insensitive .
 */
    function consultarPizza($arrayDeParametros){
        $auxArray;
        $valorRetornado=false;
        $contador=0;
        $arrayDeParametrosDos = leer("pizza.txt");

        if($arrayDeParametrosDos){ 
            foreach($arrayDeParametrosDos as $key => $val){
                $auxArray= (array)$val;          
                if($auxArray){
                    if(strtolower($auxArray['sabor'])===strtolower($arrayDeParametros['sabor']) &&
                        strtolower($auxArray['tipo'])===strtolower($arrayDeParametros['tipo']) ){
                        $contador++;
                        $valorRetornado=true;
                        echo('Ocurrencia '.$contador.':'.' Sabor:'.$auxArray['sabor'].' Tipo:'.$auxArray['tipo'].' Cantidad:'.$auxArray['cantidad']."\n");
                    }
                }   
            }
            if(!$valorRetornado){
                echo('No existe:'.' Sabor:'.$arrayDeParametros['sabor'].' Tipo:'.$arrayDeParametros['Tipo']);
            } 
        }
    } 

    /**
     * carga cada elemento del array al archivo txt;
     */
    function cagarPizzas($arrayPizzas){
        $flag=false;

        foreach($arrayPizzas as $key => $val){
            $auxArray= (array)$val;          
            if($auxArray){
                $this->_construct($auxArray['tipo'],$auxArray['cantidad'],$auxArray['sabor'],$auxArray['precio'],$auxArray['imagenUno'],$auxArray['imagenDos'],$auxArray['id']);                
                if(!$flag){
                    guardar("pizza.txt", $this, "w");
                    $flag=true;
                }
                else{
                    guardar("pizza.txt", $this, "a");
                }
                
            }
        }
    }
}

?>