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


include '../class/class_postgre.php';

//GetbdP::Debug();
$postgre = new GetbdP();

$a  =  array('tabla' => 'beta', 'nombre'=>'nico' );
$b = ['tabla'=>'beta','nombre'=>'nico'];

//echo $a['tabla']  .  $a['nombre'];
echo $b['tabla']  .  $b['nombre'];
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

//$postgre->SelectRegistro($sql);

//$datos = $postgre->ListRegistro();
$datos = $postgre->find($sql)->show();


//if(count($datos) > 0){
foreach ($datos as $dato) {
	
  echo "<div class='bock'>
         <h5>$dato[nombre] | |  $dato[apellido] </h4>
         <img src='$dato[avatar]'/>
         <a href='$dato[id]'>Editar<a/>
         <a href='$dato[id]'>Eliminar<a/>
	</div>";
}
//}else{

	//echo "No hay Datos";
//}


 ?>