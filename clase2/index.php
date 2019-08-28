<?php
 include_once './clases/alumno.php';

 $alumno=new Alumno ($_GET['nombre'], $_GET['apellido']);
 $datos=$alumno->saludar();
 echo $datos;


?>

