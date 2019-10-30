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
                 $foto = $_FILES["foto"];
                 $arrayDeParametros=array("patente"=>$patente,"marca"=>$marca,"kms"=>$kms,"foto"=>$foto);
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
    /**
     * 7- (2 pts.) caso: modificarVehiculo(post): Debe poder modificar todos los datos del vehículo menos la patente y
    *se debe cargar una imagen, si ya existía una guardar la foto antigua en la carpeta /backUpFotos , el nombre será
    *patente y la fecha.
     */
    else if($_POST["caso"]=="modificarVehiculo")
    {
        if(isset($_POST['patente'])){
            if(isset($_POST['marca'])){
                if(isset( $_FILES["foto"])){
                    if(isset($_POST['kms'])){
                    $patente=$_POST['patente'];
                     $marca=$_POST['marca'];
                     $kms=$_POST['kms'];
                     $foto = $_FILES["foto"];
                     $arrayDeParametros=array("patente"=>$patente,"marca"=>$marca,"kms"=>$kms,"foto"=>$foto);
                     $objeto = new Vehiculo();
                     $objeto->modificarVehiculo($arrayDeParametros,$foto);
                    }
                }
                
            }
        }
        
    }
}
else if($dato=="GET")
{
    if($_GET["caso"]=="consultarVehiculo"){ 
        if(isset($_GET['patente'])){
            if(isset($_GET['marca'])){
                $patente=$_GET['patente'];
                $marca=$_GET['marca'];
                $arrayDeParametros=array("patente"=>$patente,"marca"=>$marca);
                $objeto = new Vehiculo();
                echo ("entro");
                $objeto->consultarVehiculo($arrayDeParametros);
            }
        }
        
    }
    else if($_GET["caso"]=="sacarTurno")
    {
        if(isset($_GET['patente'])){
            if(isset($_GET['precio'])){                
                if(isset($_GET['fecha'])){
                    $patente=$_GET['patente'];
                    $precio=$_GET['precio'];
                    $fecha=$_GET['fecha'];
                    $arrayDeParametros=array("patente"=>$patente,"precio"=>$precio,"fecha"=>$fecha);
                    $objeto = new Turno(); //-->cambio "fecha" por el campo "idServicio"
                    $objeto->sacarTurno($arrayDeParametros);
                }                 
            }
        }

        
    }
    else if($_GET["caso"]=="turnos")
    {
        $objeto = new Turno();
        $objeto->turnos();
    }    
    else if($_GET["caso"]=="servicio")
    {
        if(isset($_GET['tipoServicio'])){
            if(isset($_GET['fecha'])){
                $tipoServicio=$_GET['tipoServicio'];
                $fecha=$_GET['fecha'];
                $arrayDeParametros=array("tipoServicio"=>$tipoServicio,"fecha"=>$fecha);
                $objeto = new Turno();
                $objeto->inscripciones($arrayDeParametros);
            }
        } 
       
    }   
    // else if($_GET["caso"]=="vehiculos")
    // {
    //     
    // }
}
?>