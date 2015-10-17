<?php 

require_once 'class/class_mysql.php';




$file = $_FILES['archivo'];	

$archivo = new FileUp();

 	

//$var = $archivo->uploadFile( $file , "prueba2" );



$var = $archivo->uploadFileMult($file , "prueba2" );


echo "<pre>";

 print_r($var);

echo "</pre>";
