
# Librería getBd 
**Mini librería Básica para CRUD y Gestión de  Consultas a la Base de Dato, y Manejos de File.**

------------------------------------------------------
 + Copyright by **FRANCISCO CAMPOS** 
 + Versión: BETA
 + Licencia: MIT  
 + Contactar: <camqui2011@gmail.com>
 + [https://gitlab.com/franpc/getBd.git](http://)
 + Requicito: ( php >=5.3.0 , mysql 5.0+ , postgres 9.1.1+)


Tiene soporte para:

+ Mysql
+ Mysqli
+ Postgres
+ Files


[TOC]


##Estructura de la Librería

```php
    -Src
        File.php
        GetbdM.php
        GetbdMi.php
        GetbdP.php

    -Config
        Connect
          Mysql.php
          Mysqly.php
          Postgre.php
        Files
          ConfigFile.php
        Base.php
		autocarga.php

	start.php

    - Documentación.md

```



##Descripción de la Librería

------------------------------------------------------

**Src:** Contiene las clases necesaria para el manejo rápido de las consultas a la base de datos.

    - GetbdM.php:

    - name: GetbdM()
Contiene las clases y métodos requerido el uso de Mysql.

     -GetbdMi.php:

    - name: GetbdMy()
Contiene las clases y métodos requerido el uso de Mysqli.

    - GetbdP.php:

    - name: GetbdP()
Contiene las clases y métodos requerido el uso de Postgres.

    - File.php:

    - name: File()
Contiene las clases nesesarias para la Subida de Archivos al servidor.



**Config:** Contiene las variables de configuración de la conexión a la base de datos, aquí se configura  las variables de la conexión: root , localhost , password, database, también  los parámetros de los archivos como: tamaño , formato permitidos etc.

    - Base.php

##Instalación

Instalación vía  Composer:

```php
 composer require getBd
```
Uso:

```php
require 'vendor/autoload.php'
```


Instalación Mediante Descarga:

[https://gitlab.com/franpc/getBd.git](http://)



Uso:

```php
require 'path/getbd/start.php
```



##Funcionamiento

Configuración de las variables de conexión.


`Config/Base.php`

 Inicializamos los parámetros del Drive a utilizar en el array de configuración.

**Driver para Mysql**

```php
    // DRIVER MYSQL
        'mysql' => array(
            'host' => 'host',
            'database' => 'database',
            'user' => 'username',
            'password' => 'password'

        ),
```

**Driver para Postgres**

```php
    // DRIVER POSTGRES
        'postgre' => array(
            'host' => 'host',
            'database' => 'database',
            'user' => 'postusername',
            'password' => 'password'
        ),
```

**Driver para Mysqli**

```php
     // DRIVER MYSQLI
        'mysqli' => array(
            'host' => 'host',
            'database' => 'database',
            'user' => 'username',
            'password' =>'password'
        ),

```


##GetBd Mysql

Para usar getBd con  Mysql


```php
<?php
use Src\GetbdM;
$obj = new GetbdM();
?>

```

##GetBd Mysql Insert

```php
save( sql , opcional)
```
Este método recibe dos parámetro, la consulta SQL , y una configuración opcional.

- **sql:**  consulta sql a insertar, Nota: la variable puede ser llamada de otra forma!

Valores de Retorno:

- **true:** Registro insertado correctamente.
- **false:** Registro no insertado .

Con getBd es posible verificar el registro antes de ser insertado, todo en una sola linea de código.

##GetBd Mysql Insert Verificado

Esto es posible solo agregando parámetros adicionales al  método save() de la siguiente forma.

```php
save( $sql , array('tabla' , 'campos' , 'valor') )
```
  valor adicional es un array con  iten  para la verificacion del registro.

- **tabla** : Nombre de la tabla donde sera verificado el registro.
- **campo**: Campos referencia para la condicion a cumplir.
- **valor**: Valor de verificación de la condición.

Valores de Retorno:

- **NULL**: Sí existe un registro que coincida con el array de verificación, el sql  no sera insertado.
- **true**: No se encotro registro similar a la verificación, se realiza el insert de manera correcta.

**Nota:** Para query más complejos usamos  check()
Ejemplo:
```php
 check( [ 'tabla' , 'campos' , 'valor'] )
```
```php
 check( 'SQL' )
```

Ejemplo: Realizando INSERT con su validación

```php
<?php 

use Src\GetbdM;

$obj = new GetbdM;

$sql = "INSERT INTO tabla (campos) Values (valores)";

//verificador del registro

$con->save($sql, ['tabla' , 'campo' , 'valor']);

 if(!is_null($con))
 {
   echo "Registro Insertado";
 }
 else
 {
   echo "Registro No Insertado";
 }
 
 ```
 
 ```php
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


##GetBd Mysql SELECT

Para ello tenemos los métodos:

`find( parametro )` consultas complejas

+ Recibe un parámetro que es la consulta SQL
+ Retorna **True:** Si hay registro
+ Retorna **False:**  Si no hay registro

`findAll( tabla )` consultas simples

+ Recibe un parámetro, el nombre de la tabla de la base de datos
+ Retorna **True:** Si hay registro
+ Retorna **False:**  Si no hay registro

Mostrando los datos:

`show()`

+ Retorna un Array Asociativo con los datos

`showObj()`

+ Retorna un Objeto con los datos

`showObjson()`

+ Retorna un Objeto JSON con los datos Ideal para REST API

**SELECT a la base de datos**

```php
find( sql_query ) show() 
```

```php
 <?php
 use Src\GetbdM;

  $obj = new GetbdM;
  
  $sql = "SELECT * FROM tabla ";

  $datos = $obj->find($sql)->show();

 //mostrando los registros
 
 foreach ($datos as $dato) {
    echo $dato['campo'] . "<br>";
 }
    
 ?>
```

```php
findAll( parámetro ) showObj() 
```

```php
 <?php
  use Src\GetbdM;

 $obj = new GetbdM();
  
  $datos = $obj->findAll("tabla")->showObj();

 //mostrando los registros
 
 foreach ($datos as $dato) {
    echo $dato->campo . "<br>";
 }
    
 ?>
```

```php
 <?php
  use Src\GetbdM;

 $obj = new GetbdM();
  
  $datos = $obj->findAll("tabla")->showObjson();

 //mostrando los registros en formato JSON
 
 foreach ($datos as $dato) {
    echo $dato.campo  "<br>";
 }
    
 ?>
```


##GetBd SELECT Único

Para ello tenemos el métodos:

`findOne( ['tabla' , 'campos', 'valor'] )`

+ Recibe un arreglo con 3 parámetros 
+ Retorna **True:** Sí hay registro
+ Retorna **False:** Sí no hay registro
+ Retorna un registro encontrado


```php
 <?php
  use Src\GetbdM;

$obj = new GetbdM;

$datos = $obj->findOne(['table' , 'id', 'valor']);

 //mostrando el registro

  print_r($dato );
 ?>
```

##GetBd Mysql UPDATE

Para ello tenemos el métodos:

```php
update( sql , 'string' )
```

+ Recibe dos parámetro que son: la consulta SQL , y la cadena 'update', para evitar error en la consulta. 
+ Retorna **True:** Sí se actualizó el registro
+ Retorna **False:** No se actualizó el registro
+ String: Debe ser igual a update

```php
 <?php
 use Src\GetbdM;

$obj = new GetbdM;

 $sql = "UPDATE  tabla SET campo = 'valor' where condición";

  if ( !$con->update($sql , 'update')) 
  {
     echo "No! se actualizÓ el registro";
  }
  else
  {   
     echo "Registro actualizado";
  }

 ?>
```


##GetBd Mysql DELETE

Para ello tenemos el métodos:

```php
remove(sql , 'string' )
```

+ Recibe dos parámetro que son : la consulta SQL , y la cadena 'delete', para evitar error en la consulta. 
+ Retorna **True:** Sí se elimino el registro.
+ Retorna **False:** No se elimino el registro.
+ String: Debe ser igual a delete.

```php
 <?php
 use Src\GetbdM;

 $obj = new GetbdM;
  
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

##GetBd  SQL injection

Usamos el método `Valid()` recibe la variable a verificar

**Retorna la consulta segura**

```php
GetbdM::Valid( $_POST['campos'])
```

```php

 <?php
 
  use Src\GetbdM;

  $var = GetbdM::Valid( $_POST['campos']);
  
  $sql = "SELECT * FROM  tabla WHERE campo = ( $var )";

  $con->save( $sql );

// todas las demas opciones 

 ?>
```

##GetBd Postgres y Mysqli

El uso de getBd con Postgres o Mysqli es igual al funcionamiento con Mysql tenemos los mismo métodos. Solo cambiar  **Instancia de la class.**

**Para usar getBd con  Mysqli:**

```php
<?php
use Src\GetbdMi;
$obj = new GetbdMi();
?>

```
**Para usar getBd con  Postgres:**

```php
<?php
use Src\GetbdP;
$obj = new GetbdP();
?>

```


**Tenemos los mismo métodos:**

`save( parámetro )`

`check( array )`

`find( parámetro )`

`findAll( parámetro )`

`findOne( array )`

`show()`

`showObj()`

`showObjson()`

`upadate( parámetro , 'string' )`

`remove( parámetro , 'string' )` 

`Valid( parámetro )`

**Nota:**
 >Puede ver los ejemplos de los métodos arriba.


##GetBd Files

Subir Archivos o files al servidor con getBd es muy fácil.
Para ello tenemos la clase ` File()` que contiene los métodos:

La clase ` File()` se puede configurar siertos parámetros para ello nos ubicamos en la  siguiente ruta:

*Config/Base.php*

// CONFIGURACIÓN DE LOS FILES O ARCHIVOS DE GETBD
```php

// EXTENCION DEL FILE PERMITIDO

        'exten' => array(

            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'word' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'pdf'  => 'application/pdf'

        ),

```

```php
		// TAMAÑO  DEL FILE PERMITIDO

        'sizes' => array( 

            's' => 4096000 , //500kb
            'm' =>  819200 , //800 Kb
            'l' => 1048576 , //1024 Kb
            'xl' => 6291456, //6144 Kb

        ),

```
**Nota:**
 >Puede agregar más valores al array de configuración del FILE en su campo correspondiente.

**Subir FILE Usando el Método upFile:**

```php
upFile( file , directorio)
```

* Recibe un primer parámetro. file a subir.
* Recibe un segundo parámetro el nombre de la carpeta donde se guarda el archivo.
* Retorna **Array:** con 2 valores el primero true , el sugundo la ruta final del archivo guardado.
* Retorna **False:** Sí no se guardo el archivo.

>Array retornado:

```php
 array respuesta = [ 'valid' => true , 'ruta'=> 'ruta del archivo' ];
```

**Ejemplo de uso:**

*index.html*

```php
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

```php

 <?php

use Src\File;

$file = $_FILES['archivo'];//reciben el archivo

$archivo = new File; //instancia de la clase

//usamos el método upFile(nombre del archivo , nombre de la carpeta)

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

**getBd con múltiples archivos:**

Para ello tenemos la clase ` File()` que contiene los métodos:

```php
upFiles(files, directorio)
```
* Recibe un primer parámetro. file a subir.
* Recibe un segundo parámetro el nombre de la carpeta donde se guarda el archivo.
* Retorna **Array:** con 2 valores el primero true , el sugundo la ruta final del archivo guardado.
* Retorna **Array:** con error  Si no se guardo el archivo.

```php
array respuesta = {
  [0] => 'true',
  [0] => 'ruta del archivo guardado1'
  [1] => 'true',
  [1] => 'ruta del archivo guardado2'
}

```

Ejemplo de uso:

**index.html**

```php
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


**demo.php**

```php
 <?php 

use Src\File;


$file = $_FILES['archivo'];//reciben el archivo

$archivo = new File; //instancia de la clase

//usamos el método upFiles(nombre del archivo , nombre de la carpeta)
//para la subida de varios archivos al servidor.

$var = $archivo->upFiles($file , "carpeta a guardar" );

echo "<pre>";

 print_r($var);//mostrando el resultado de la subida.

echo "</pre>";

?>
```
** GetBd Bajar archivo:**

```php
dowFile( ruta_file )
```

Ejemplo: Bajando un file

```php
 <?php 

use Src\File;

$archivo = new File; //instancia de la clase

$archivo->dowFile( " ruta fina del file " );

echo "Archivo Bajado...";

?>
```

**Comprimir un archivo a formato Zip:**

```php
zipFile( "ruta final del file" )
```
Este método Retorna la ruta Final del Archivo .zip.

** Comprimir un archivo a formato Zip y Bajarlo Al mismo tiempo:**

```php
dowFile( "ruta final del file"  , true )
```





