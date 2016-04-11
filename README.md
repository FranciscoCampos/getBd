
# Libreria getBd 
![](http://i.imgur.com/q2CBZ1t.png?1)

#### Mini libreria básica para CRUD y gestión de  consultas a la base de dato.

------------------------------------------------------
 + Copyright by **FRANCISCO CAMPOS** 
 + Verción: BETA
 + Licencia: OpenSource 
 + Contactar: <camqui2011@gmail.com>
 + [https://gitlab.com/franpc/getBd.git](http://)
 + Requicito: ( php5+ , mysql 5.0+ , postgres 9.1.1+)

------------------------------------------------------ 

Tiene soporte para: 

+ Mysql
+ Mysqli
+ Postgres
+ Files

******************************************************

### Extructura de la Libreria:

#### getBd:

    -south
        class_file.php
        class_mysql.php
        class_mysqli.php
        class_postgre.php
    -config
        base.php
        start.php
    - README.md




### Descripción de la Libreria:

------------------------------------------------------

**Class:** contiene las class necesaria para el manejo rapido de las consultas a la base de datos.

    - class_mysql.php:

    - name: GetbdM()
Contiene las clases y métodos requerido el uso de Mysql.

     -class_mysqli.php:

    - name: GetbdMy()
Contiene las clases y métodos requerido el uso de Mysqli.

    - class_postgre.php:

    - name: GetbdP()
Contiene las clases y métodos requerido el uso de Postgres.

    - class_file.php:

    - name: File()
Contiene las clases nesesarias para la Subida de Archivos al servidor.



**Config:** Contiene las variables de configuración de la conexión a la base de datos, aqui se configura  las variables de la conexión: root , localhost , password, database, tambien  los parametros de los archivos como: tamaño , formato permitidos etc.

    - base.php:

## Funcionamiento:

Configuración de las variables de conexión.

*config/base.php*

 Inicializamos los parametros del Drive a utilizar en el array de configuración.

    // DRIVER MYSQL
        'mysql' => array(
            'host' => 'host',
            'database' => 'database',
            'user' => 'username',
            'password' => 'password'
           
        ),

    // DRIVER POSTGRES
        'postgre' => array(
            'host' => 'host',
            'database' => 'database',
            'user' => 'postusername',
            'password' => 'password'
        ),

     // DRIVER MYSQLI   
        'mysqli' => array(
            'host' => 'host',
            'database' => 'database',
            'user' => 'username',
            'password' =>'password'
        ),



Ejemplo de uso getBd implementación con el driver de Mysql:


**Archivo demo.php**
```
<?php

//Requerimos la clase para Mysql
require_once 'south/class_mysql.php';

//Instancisa del objeto para Mysql
 $obj = new GetbdM();

?>

```


Ejemplo de uso getBd implementación con el driver de Postgres:


**Archivo demo.php**
```
<?php

//Requerimos la clase para Postgres
require_once 'south/class_postgre.php';

//Instancisa del objeto para Postgres
$obj = new GetbdP();

?>
```

Ejemplo de uso getBd implementación con el driver de Mysqli:


**Archivo demo.php**
```
<?php

//Requerimos la clase para Mysqli
require_once 'south/class_mysqli.php';

//Instancisa del objeto para Mysqli
$obj = new GetbdMi();

?>
```



## getBd con Mysql

**Insertar registros en la base de datos:**

`save( sql )`

Este método recibe un parametro, la consulta SQL.

- **sql:**  consulta sql a insertar, Nota: la variable puede ser llamada de otra forma!

Valores de Retorno:

- **true:**  Si la consulta se realizó correctamente.
- **false:** Si la consulta no se realizó correctamente.
Con getBd es posible verificar el registro antes de ser insertado, todo en una sola linea de código.

Usamos el método: 

`check( [ 'tabla' , 'campos' , 'valor'] )`

- **tabla** : Nombre de la tabla donde sera verificado el registro.
- **campo**: Campos referencia para la condicion a cumplir.
- **valor**: Valor de verificación de la condición.

Valores de Retorno:

- **true**: Si existe el registro.
- **false**: No se encotro registro.

**Nota:** Uselo antes del método save()
Ejemplo:

    `obj->check( [ 'tabla' , 'campos' , 'valor'] )->save(sql)`



```
<?php 

require_once 'south/class_mysql.php';


$con = new GetbdM();

$sql = "INSERT INTO tabla (campos) Values (valores)";

//verificador del registro

$con->check(['tabla' , 'campo' , 'valor'])->save($sql);

 if(!$con)
 {
   echo "Registro Insertado";
 }
 else
 {
   echo "Registro No Insertado";
 }
 
 
//Sin verificar registro

$con->save($sql);

 if(!$con)
 {
   echo "Registro Insertado";
 }
 else
 {
   echo "Registro No Insertado";
 }
?>
```


## Consultar registro de la base de datos

Para ello tenemos los métodos:

`find( parametro )` consultas complejas

+ Recibe un parametro que es la consulta SQL
+ Retorna **True:** Si hay registro
+ Retorna **False:**  Si no hay registro

`findAll( parametro )` consultas simples

+ Recibe un parametro que es la consulta SQL
+ Retorna **True:** Si hay registro
+ Retorna **False:**  Si no hay registro

`show()`

+ Retorna un Array Asociativo con los datos

`showObj()`

+ Retorna un Objeto con los datos

## Consulta a la base de datos

`find( parametro ) show() `

```
 <?php
  require_once 'south/class_mysql.php';

  $obj = new GetbdM();
  
  $sql = "SELECT * FROM tabla ";

  $datos = $obj->find($sql)->show();

 //mostrando los registros
 
 foreach ($datos as $dato) {
    echo $dato['campo'] . "<br>";
 }
    
 ?>
```

`findAll( parametro ) showObj() `

```
 <?php
  require_once 'south/class_mysql.php';

  $obj = new GetbdM();
  
  $datos = $obj->findAll("tabla")->showObj();

 //mostrando los registros
 
 foreach ($datos as $dato) {
    echo $dato->campo . "<br>";
 }
    
 ?>
```

## Consultar un registro unico en la  base de datos

Para ello tenemos el métodos:

`findOne( ['tabla' , 'campos', 'valor'] )`

+ Recibe un arreglo con 3 parametros 
+ Retorna **True:** Si hay registro
+ Retorna **False:** Si no hay registro
+ Retorna un registro encontrado


```
 <?php
  require_once 'south/class_mysql.php';

  $obj = new GetbdM();
  
  $sql = "SELECT * FROM tabla ";

  $datos = $obj->findOne(['table' , 'id', 'valor']);

 //mostrando el registro

    print_r($dato );
 
    
 ?>
```

## Actualizar registro de la base de datos

Para ello tenemos el métodos:

`update( sql , 'string' )`

+ Recibe dos parametro que son: la consulta SQL , y la cadena 'update', para evitar error en la consulta. 
+ Retorna **True:** Si se actualizo el registro
+ Retorna **False:** Si no se actualizo el registro

```
 <?php
  require_once 'south/class_mysql.php';

 $obj = new GetbdM();
      
 $sql = "UPDATE  tabla SET campo = 'valor' where condicion";

  if ( !$con->update($sql , 'update')) 
  {
     echo "No! se actualizo el registro";
  }
  else
  {   
     echo "Registro actualizado";
  }

 ?>
```


## Eliminar registro de la base de datos

Para ello tenemos el métodos:

`remove(sql , string' )`

+ Recibe dos parametro que son : la consulta SQL , y la cadena 'delete', para evitar error en la consulta. 
+ Retorna **True:** Si se elimino el registro
+ Retorna **False:** Si no se elimino el registro

```
 <?php
  require_once 'south/class_mysql.php';

  $obj = new GetbdM();
  
  $sql = "DELETE FROM tabla WHERE condición";

  if($obj->remove($sql , 'delete'))
  {
  	echo "Registro eliminado";
  }
  else
  {
    echo "No! se elimino el registros";
  }

 ?>
```

## Evitar  SQL injection en los query necesarios...

Usamos el método `Valid()` recibe la variable a verificar

**Retorna la consulta segura**

`GetbdM::Valid( $_POST['campos'])`

```
 <?php
  require_once 'south/class_mysql.php';

  $var = GetbdM::Valid( $_POST['campos']);
  
  $sql = "SELECT * FROM  tabla WHERE campo = ( $var )";

  $con->find($sql);

// todas las demas opciones 

 ?>
```

## getBd  con  Postgres y Mysqli

El uso de getBd con Postgres o Mysqli es igual al funcionamiento con Mysql tenemos los mismo metodos. Solo cambia es el **include de la class**


`save( parametro )` 

`check( array )`

`find( parametro )`

`findAll( parametro )`

`findOne( array )`

`show()`

`showObj()`

`upadate( parametro , 'string' )`

`remove( parametro , 'string' )` 

`Valid( parametro )`

**Nota:** 
 >Puede ver los ejemplos de los métodos arriba.


## getBd subir archivos al servidor

Para ello tenemos la clase ` File()` que contiene los métodos:
    
`upFile()` 

* Recibe un primer parametro. file a subir.
* Recibe un segundo parametro el nombre de la carpeta donde se guarda el archivo.
* Retorna **Array:** con 2 valores el primero true , el sugundo la ruta final del archivo guardado.
* Retorna **False:** Si no se guardo el archivo.

>Array retornado:

```
 array respuesta = [ 'valid' => true , 'ruta'=> 'ruta del archivo' ];
```

Ejemplo de uso:

*index.html*

```
<!DOCTYPE html>

<html>
    <head>
    </head>
    <body>

        <form action="file.php" method="post" enctype="multipart/form-data">
         <input type="file" name="archivo" ></input><br>
         <input type="submit" value="Subir archivo"></input>
        </form>

    </body>

</html>
```

*demo.php*

```
 <?php 

require_once 'south/file.php';


$file = $_FILES['archivo'];//reciben el archivo

$archivo = new File(); //instancia de la clase

//usamos el metodo upFile(nombre del archivo , nombre de la carpeta)

$var = $archivo->upFile( $file , "nombre de la carpeta" );

if($var[0] == true){
    echo "Archivo subido";
    
    //ejemplo mostrando el archivo subido
    echo" <img src='$var[1]' /> ";
    
}else{
    echo "Error al subir archivo";
}

?>
```

## getBd con multiples archivos:

Para ello tenemos la clase ` File()` que contiene los métodos:
    
`upFiles()` 

* Recibe un primer parametro. file a subir.
* Recibe un segundo parametro el nombre de la carpeta donde se guarda el archivo.
* Retorna **Array:** con 2 valores el primero true , el sugundo la ruta final del archivo guardado.
* Retorna **Array:** con error  Si no se guardo el archivo.

```
array respuesta = {
  [0] => 'true',
  [0] => 'ruta del archivo guardado1'
  [1] => 'true',
  [1] => 'ruta del archivo guardado2'
}

```

Ejemplo de uso:

*index.html*

```
<!DOCTYPE html>

<html>
    <head>
    </head>
    <body>

        <form action="file.php" method="post" enctype="multipart/form-data">
         <input type="file" name="archivo[]" multiple="multiple" ></input><br>
         <input type="submit" value="Subir archivo"></input>
        </form>

    </body>

</html>
```


*file.php*
```
 <?php 

require_once 'south/file.php'; 


$file = $_FILES['archivo'];//reciben el archivo

$archivo = new File(); //instancia de la clase

//usamos el metodo upFiles(nombre del archivo , nombre de la carpeta)
//para la subida de varios archivos al servidor.

$var = $archivo->upFiles($file , "carpeta a guardar" );

echo "<pre>";

 print_r($var);//mostrando el resultado de la subida.

echo "</pre>";

?>
```

------------------------------------------------------
 + Copyright by **FRANCISCO CAMPOS** 
 + Verción: BETA
 + Licencia: OpenSource 
 + Contactar: <camqui2011@gmail.com>
 + [https://gitlab.com/franpc/getBd.git](http://)
 + Requicito: ( php5+ , mysql 5.0+ , postgres 9.1.1+)

------------------------------------------------------ 