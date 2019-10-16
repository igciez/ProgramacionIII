<?php
ini_set('max_input_vars', 3000);
$dato = $_SERVER['REQUEST_METHOD'];
require_once 'clases/vehiculo.php';
require_once 'clases/servicio.php';
require_once 'clases/turno.php';

if($dato=="POST")
{
    if($_POST["caso"]=="cargarVehiculo")
    {        
        if(isset($_POST['patente'])){
            if(isset($_POST['marca'])){
                if(isset($_POST['kms'])){          
                 $patente=$_POST['patente'];
                 $marca=$_POST['marca'];
                 $kms=$_POST['kms'];
                 $arrayDeParametros=array("patente"=>$patente,"marca"=>$marca,"kms"=>$kms);
                 $objeto = new Vehiculo();
                 $objeto->cargarVehiculo($arrayDeParametros);
                }
            }
        }  
        
    }
    else if($_POST["caso"]=="cargarTipoServicio")
    {
        if(isset($_POST['id'])){
            if(isset($_POST['tipo'])){
                if(isset($_POST['precio'])){
                    if(isset($_POST['demora'])){
                        $id=$_POST['id'];
                        $tipo=$_POST['tipo'];
                        $precio=$_POST['precio'];
                        $demora=$_POST['demora'];
                        $arrayDeParametros=array("id"=>$id,"tipo"=>$tipo,"precio"=>$precio,"demora"=>$demora);
                        $objeto = new Servicio();
                        $objeto->cargarTipoServicio($arrayDeParametros);
                    }
                }

            }
        }
        
    }
    else if($_POST["caso"]=="modificarVehiculo")
    {
        require_once "./Funciones/modificarVehiculo.php";   
    }
}
else if($dato=="GET")
{
    if($_GET["caso"]=="consultarVehiculo")
    {
        if(isset($_POST['patente'])){
            if(isset($_POST['marca'])){
                $patente=$_POST['patente'];
                $marca=$_POST['marca'];
                $arrayDeParametros=array("patente"=>$patente,"marca"=>$marca);
                $objeto = new Vehiculo();
                $objeto->consultarVehiculo($arrayDeParametros);
            }
        }
        
    }
    else if($_GET["caso"]=="sacarTurno")
    {
        require_once "./Funciones/sacarTurno.php";
    }
    else if($_GET["caso"]=="turnos")
    {
        require_once "./Funciones/turnos.php";
    }    
    else if($_GET["caso"]=="inscripciones")
    {
        require_once "./Funciones/inscripciones.php";
    }   
    else if($_GET["caso"]=="vehiculos")
    {
        require_once "./Funciones/vehiculos.php";
    }
}
?>