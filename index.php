<?php 

/*require_once 'class/class_mysql.php';


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

multiple="multiple"
multiple="multiple"
multiple="multiple"
multiple="multiple"
multiple="multiple"
multiple="multiple"
multiple="multiple"

*/

 ?>

<!DOCTYPE html>

<html>

    <head>

    </head>

    <body>

        <form action="file.php" method="post" enctype="multipart/form-data">
       
         <input type="file" name="archivo" multiple="multiple"></input><br>
        

            <input type="submit" value="Subir archivo"></input>

        </form>

    </body>

</html>
