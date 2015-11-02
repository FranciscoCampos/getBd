<?php 


include '../class/class_postgre.php';
include '../class/class_help.php';


error_reporting(-1);
      ini_set('display_errors', '1');
	
	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$avatar = $_FILES['avatar'];

//var_dump($_POST);
	$postgre = new GetbdP(); 
    $file = new File();

    //prosesando el archivo

    $var = $file->upFile($avatar , '../prueba2');
    $avataruta = $var[1];

	//sql
	$sql = "INSERT INTO beta (nombre , apellido , avatar) VALUES('$nombre' , '$apellido','$avataruta')";

	//var_dump($postgre->save($sql));
	if ($postgre->check(['beta','nombre',$nombre])->save($sql) > 0) {
	//if ($postgre->save($sql) > 0) {

		echo "Listo";
		echo "<a href='index.php'>Inicio </a>";

	}else{

		echo "Error: ya Existe!!!";
	}













 ?>