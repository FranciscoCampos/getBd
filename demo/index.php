<style>
.bock{
	width: 150px;
	display: inline-block;
}
	img{
		width: 100px;
		height: 100px;
	}
</style>

<?php 

error_reporting(-1);
      ini_set('display_errors', '1');

include '../class/class_postgre.php';

//GetbdP::Debug();
$postgre = new GetbdP();










//var_dump(unlink('../prueba2/grunt-logo.png'));
echo "<h1> CRUD de Usuarios con getBd</h1>";

echo "

<br><br>
<form method='POST' action='procesa.php' enctype='multipart/form-data'>

	<input type='text' name='nombre' placeholder='Nombre'/><br><br>
	<input type='text' name='apellido' placeholder='Apellido'/><br><br>
	<input type='file' name='avatar'/><br><br>
	<input type='submit' name='enviar'value='Guardar'/>

</form>

<br><br>
";

$sql =" SELECT * FROM beta";
$datos = $postgre->find($sql)->show();
//$datos = $postgre->find($sql)
if(count($datos) > 0){
	foreach ($datos as $dato) {
		
	  echo "<div class='bock'>
	         <h5>$dato[nombre] | |  $dato[apellido] </h4>
	         <img src='$dato[avatar]'/>
	         <a href='editar.php?var=editar&id=$dato[id]'>Editar<a/>
	         <a href='eliminar.php?var=eliminar&id=$dato[id]'>Eliminar<a/>
		</div>";
		echo $dato['avatar'];
	}
}else{

	echo "No hay Datos";
}


//rename("/tmp/archivo_tmp.txt", "/home/user/login/docs/mi_archivo.txt");

?>