<?php 

require_once 'class/class_mysql.php';


$sql = "INSERT INTO otra (apellido) values ('otro')";

$con = new ConectarMysql();
$con->InsertRegistro($sql);

$sql= "SELECT * FROM otra";

if($con->selectRegistro($sql)){

   $dato = $con->listRegistro();

	for ($i=0; $i < sizeof($dato); $i++) { 
	
	echo $dato[$i]['id'] .  $dato[$i]['apellido'];
		echo "<br>";
	}
}else{

	echo "no hay resultado";
}
 
if ($con->updateRegistro("UPDATE  otra set apellido = 'camarada' where id = 5")) {
 	echo "actualizado";
 } 



 ?>
