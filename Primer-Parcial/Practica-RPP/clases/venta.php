<?php 

require_once 'funciones/index.php';
require_once 'pizza.php';


class Venta{

    public $tipo;
    public $cantidad;
    public $sabor;
    public $precioVenta;
    public $email;
    public $id;

    function _construct($tipo,$cantidad,$sabor,$precioVenta,$email,$id){
        $this->tipo=$tipo;
        $this->cantidad=$cantidad;
        $this->sabor=$sabor;
        $this->precioVenta=$precioVenta;
        $this->email=$email;
        $this->id=++$id;
    }

/**
 * 3- (1 pt.) A partir de este punto, se debe guardar en un archivo info.log la información de cada petición recibida
*por la API (ruta, metodo, hora).
*4-(2 pts.) Ruta: ventas (POST). Recibe el email del usuario y el sabor,tipo y cantidad ,si el item existe en Pizza.xxx,
*y hay stock guardar en el archivo de texto Venta.xxx todos los datos , más el precio de la venta, un id
*autoincremental y descontar la cantidad vendida. Si no cumple las condiciones para realizar la venta, informar el
*motivo.
 */

    function cargarVenta($arrayDeParametros){
        $valorRetornado=false;
        $auxArray;
        $arrayDeParametrosLeidosPizza = leer("pizza.txt");
        $arrayDeParametrosLeidosVenta = leer("venta.txt");
        $auxId;
        $auxIdPizza;
        $auxCantidad;
        $auxPrecioVenta;
        $auxArrayPizzas;
        $imagenUno;
        $imagenDos;
        $sabor;
        $precio;
        $tipo;
        
        //filtra pizza.txt
        if(isset($arrayDeParametrosLeidosPizza)){
            foreach($arrayDeParametrosLeidosPizza as $key => $val){
                $auxArray= (array)$val;               
                if(isset($auxArray)){
                    if($auxArray['tipo'] === $arrayDeParametros['tipo'] && $auxArray['sabor'] === $arrayDeParametros['sabor'] &&
                        ((float)$auxArray['cantidad']) > 0 && ((float)$arrayDeParametros['cantidad']) <= ((float)$auxArray['cantidad']) ){
                        $auxCantidad= ((float)$auxArray['cantidad']) - ((float) $arrayDeParametros['cantidad']);
                        $auxPrecioVenta=((float) $arrayDeParametros['cantidad']) * ((float)$auxArray['precio']);
                        //{"tipo":"molde","cantidad":"45","sabor":"muzza","precio":"125","imagenUno":"Chrysanthemum.jpg","imagenDos":"Desert.jpg","id":2}
                        $auxIdPizza=$auxArray['id'];
                        $imagenUno=$auxArray['imagenUno'];
                        $imagenDos=$auxArray['imagenDos'];
                        $sabor=$auxArray['sabor'];
                        $precio=$auxArray['precio'];
                        $tipo=$auxArray['tipo'];
                        $valorRetornado=true;
                        break;
                    }                   
                }   
            }
        }
        else{
            echo('Error, La cantidad ingresada es superior al stock'."\n");
        }
        
        
        if($valorRetornado){
            //itero por valores venta.txt y obtengo el ultimo Id. Si no se genero el .txt pongo id=0 
            if(isset($arrayDeParametrosLeidosVenta)){
                foreach($arrayDeParametrosLeidosVenta as $key => $val){
                    $auxArray= (array)$val;               
                    if(isset($auxArray)){
                        $auxId=$auxArray["id"];
                    }
                }
            }
            else{
                $auxId=0;
            }
            echo ('se guardo el obj: porque no esta repetiro');
            $this->_construct($arrayDeParametros['tipo'], $arrayDeParametros['cantidad'],$arrayDeParametros['sabor'],strval($auxPrecioVenta),$arrayDeParametros['email'],$auxId);                
            guardar("venta.txt", $this, "a");
            $auxArrayPizzas= borrar($arrayDeParametrosLeidosPizza,$auxIdPizza);        
            $objeto = new Pizza();
            $objeto->_construct($tipo,strval($auxCantidad),$sabor,$precio,$imagenUno,$imagenDos,$auxIdPizza);
            array_push($auxArrayPizzas,$objeto);
            $auxObjeto = new Pizza(); 
            $auxObjeto->cagarPizzas($auxArrayPizzas);
        }
        else{
            echo('no se pudo guardar');
        }
    }

}
?>