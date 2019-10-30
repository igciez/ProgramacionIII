<?php 

require_once 'funciones/index.php';

class Pizza{

    public $precio;
    public $tipo;
    public $cantidad;
    public $sabor;
    public $imagenUno;
    public $imagenDos;
    public $id;

    function _construct($precio, $tipo, $cantidad, $sabor,$imagenUno,$imagenDos,$id){
        $this->precio=$precio;
        $this->tipo=$tipo;        
        $this->cantidad=$cantidad;
        $this->sabor=$sabor;
        $this->id=$id;

        if($imagenUno["name"] && $imagenDos["name"] ){
            $this->imagenUno=$imagenUno["name"];
            $this->imagenDos=$imagenDos["name"];

            move_uploaded_file($imagenUno["tmp_name"],"./imagenes/pizzas".$sabor.$imagenUno["name"]);
            move_uploaded_file($imagenDos["tmp_name"],"./imagenes/pizzas".$tipo.$imagenDos["name"]);
        }
        else{
            $this->imagenUno=$imagenUno["imagenUno"];
            $this->imagenDos=$imagenDos["imagenDos"];
        }
    }
   
    function pizzas($arrayDeParametros,$imagenUno,$imagenDos){
        $valorRetornado=false;
          
        if($arrayDeParametros){      
            
            if($arrayDeParametros["tipo"] === "molde" || $arrayDeParametros["tipo"] === "piedra" ||
                $arrayDeParametros["sabor"] === "muzza" || $auarrayDeParametrosxArray["sabor"] === "jamon" ||
                $arrayDeParametros["sabor"] === "especial")
            {
                        
                $this->_construct($arrayDeParametros["precio"],$arrayDeParametros["tipo"],$arrayDeParametros["cantidad"],$arrayDeParametros["sabor"],$imagenUno,$imagenDos,$arrayDeParametros["id"]);
                guardar("pizza.txt", $this, "a");
                echo("Se creeo el archivo");
                $valorRetornado=true;
            } 
        }
        if(!$valorRetornado){
            echo("no se pudo crear el archivo");
        }
         
    }

    function consultarPizzas($arrayDeParametros){
        $auxArray;
        $valorRetornado=false;
        $contador=0;
        $arrayDeParametrosDos = leer("pizza.txt");

        if($arrayDeParametrosDos){ 
            foreach($arrayDeParametrosDos as $key => $val){
                $auxArray= (array)$val;       
                
                if($auxArray){
                    if(strtolower($auxArray["sabor"])===strtolower($arrayDeParametros["sabor"]) || 
                        strtolower($auxArray["tipo"])===strtolower($arrayDeParametros["tipo"])){
                        $contador++;
                        $valorRetornado=true;
                        echo('Ocurrencia '.$contador.':'.' Sabor:'.$auxArray["sabor"].' Tipo:'.$auxArray["tipo"]."\n");
                    }
                }   
            }
            if(!$valorRetornado){
                echo('No existe:'.' Sabor:'.$arrayDeParametros["sabor"].' Tipo:'.$arrayDeParametros["tipo"]);
            } 
        }
    }

}