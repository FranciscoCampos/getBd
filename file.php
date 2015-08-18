<?php 

require_once 'class/class_mysql.php';




$file = $_FILES['archivo'];
	

$archivo = new FileUp();

 	

$var = $archivo->uploadFile( $file , "prueba" );



//$var = $archivo->uploadFileMult($file , "prueba" );


echo "<pre>";

 print_r($var);

echo "</pre>";
