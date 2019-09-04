<!-- Archivos: se abre como en "C"

$ar= fopen($archivo,$modo);

fwrite($ar,"guardar");

Modos: r,w,a

salto de linea: /n -> PHP_EOL

fgets($ar) -> para pasar a array el json

function (arg1, arg2)
 funciont("hola","chau")
 a[id]->nombre= valorParametro->nombre
-->

<?php
$file = fopen("test.txt", "w");

fwrite($file,"hola");

fclose($file);
?>

<?php
$file = fopen("test.txt","r");
echo fread($file,filesize("test.txt"));
fclose($file);
?>


