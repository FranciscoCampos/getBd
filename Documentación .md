## Libreria getBd 
#### libreria basica para gestionar consultas a la base de dato.

------------------------------------------------------
 + Copyright by **FRANCISCO CAMPOS** 
 + Vercion: BETA
 + Licencia: OpenSource 
 + Contactar: <camqui2011@gmail.com>

------------------------------------------------------ 

Tiene soporte para: 

+ Mysql
+ Postgres
+ Help

******************************************************

### Extructura de la Libreria:

#### getBd:

    -class
        class_help.php
        class_mysql.php 
        class_postgre.php  
    -config
        config.php
    - documentacion.md
    - index.php



###Descripcion de la Libreria:

------------------------------------------------------

**Class:** contiene las class necesaria para el manejo rapido de las consultas a la base de datos.

    - class_mysql.php:
contiene las clases y metodos requerido el uso de Mysql.

    - class_postgre.php:
contiene las clases y metodos requerido el uso de Postgres.

    - class_help.php:
contiene las clases nesesarias para trabajos.  

+ Sessiones.
+ Subida de Archivos al servidor.
+ Manejos de Errores.


**Config:** contiene las class dode se crea la conexion a la base de datos, aqui configuraremos las variables de la conexion: root , localhost , password.

    - config.php:
contiene las clases y metodos requerido para el  uso de Mysql y Postgres.

    - index.php: 
archivo para ver el facil funcionamiento de la libreria.


##Funcionamiento:

Configuracion de las variables de conexion.

*config/config.php*
 
 **Class Mysql:**

 Inicializamos los valores en el  constructor de la clase.

    public function __construct()
    {  
        $this->localhost = 'nombre del host';
        $this->usuario = 'usuario del host';
        $this->password = 'clave del host';
        $this->bd = 'nombre de base de datos';
    }

Class Postgres:

 Inicializamos los valores en el  constructor de la clase.

    public function __construct()
    {  
        $this->localhost = 'nombre del host';
        $this->usuario = 'usuario del host';
        $this->password = 'clave del host';
        $this->bd = 'nombre de base de datos';
    }

Ejemplo de uso en Mysql:


**Archivo index.php**
```
<?php

//Requerimos la clase para Mysql
require_once 'class/class_mysql.php';

//Instancisa del objeto para Mysql
$con = new ConectarMysql();

?>

```


Ejemplo de uso en Postgres:


**Archivo index.php**
```
<?php

//Requerimos la clase para Postgres
require_once 'class/class_postgre.php';

//Instancisa del objeto para Postgres
$con = new ConectarPostgre();

?>
```

##getBd con Mysql

**Insertar registros en la base de datos:**

`InsertRegistro( parametro )`

Este metodo recibe un parametro que es la consulta SQL
Retorna:

- **true:**  si la consulta se realizo correctamente
- **false:** si la consulta no se realizo correctamente


Archivo index.php

```
<?php 

require_once 'class/class_mysql.php';


$con = new ConectarMysql();

$sql = "INSERT INTO tabla (campos) Values (valores)";

$con->InsertRegistro($sql);

    if($con > 0)
    {
        echo "Registro Insertado";
    }
    else
    {
        echo "Registro No Insertado";
    }

?>
```


##Consultar registro de la base de datos

Para ello tenemos 2 metodos:

`SelectRegistro( parametro )`

+ Recibe un parametro que es la consulta SQL
+ Retorna **True:** Si hay registro
+ Retorna **False:**  Si no hay registro

`ListRegistro()`

+ Retorna un Array Asociativo con los datos

##Consulta a la base de datos

```
 <?php
  require_once 'class/class_mysql.php';

  $con = new ConectarMysql();
  
  $sql = "SELECT * FROM tabla ";

  $con->SelectRegistro($sql);

     if ( $con > 0 ) 
     {
        $dato = ListRegistro();

        for ($i=0; $i < sizeof($dato); $i++) { 
            echo $dato[$i]['campo'] . "<br>";
        }
     }
     else
     {
        echo "No! hay registros";
     }

 ?>
```

##Actualizar registro de la base de datos

Para ello tenemos el metodos:

`UpdateRegistro( parametro )`

+ Recibe un parametro que es la consulta SQL
+ Retorna **True:** Si se actualizo el registro
+ Retorna **False:** Si no se actualizo el registro

```
 <?php
  require_once 'class/class_mysql.php';

  $con = new ConectarMysql();
  
  $sql = "UPDATE  tabla SET campo = 'valor' where condicion";

  $con->UpdateRegistro($sql);

     if ( $con > 0 ) 
     {
        echo "Registro actualizado";
     }
     else
     {
        echo "No! se actualizo el registro";
     }

 ?>
```


##Eliminar registro de la base de datos

Para ello tenemos el metodos:

`DeleteRegistro( parametro )`

+ Recibe un parametro que es la consulta SQL
+ Retorna **True:** Si se elimino el registro
+ Retorna **False:** Si no se elimino el registro

```
 <?php
  require_once 'class/class_mysql.php';

  $con = new ConectarMysql();
  
  $sql = "DELETE FROM tabla WHERE condición";

  $con->DeleteRegistro($sql);

     if ( $con > 0 ) 
     {
        echo "Registro eliminado";
     }
     else
     {
        echo "No! se elimino el registros";
     }

 ?>
```

##getBd  con  Postgres

El uso de getBd con Postgres es igual al funcionamiento con Mysql tenemos los mismo metodos. Solo cambia es el **include de la class**

```
<?php

//Requerimos la clase para Postgres
require_once 'class/class_postgre.php';

//Instancisa del objeto para Postgres
$con = new ConectarPostgre();

?>
```

`InsertRegistro( parametro )` 

`SelectRegistro( parametro )`

`ListRegistro()`

`UpdateRegistro( parametro )`

`DeleteRegistro( parametro )` 

**Nota:** 
 >puede ver los ejemplos de los metodos arriba.

##getBd subir archivos al servidor

Para ello tenemos la clase ` FileUp()` que contiene los metodos:
    
`uploadFile()` 

* Recibe un primer parametro. file a subir.
* Recibe un segundo parametro el nombre de la carpeta donde se guarda el archivo.
* Retorna **Array:** con 2 valores el primero true , el sugundo la ruta final del archivo guardado.
* Retorna **False:** Si no se guardo el archivo.

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

*file.php*

```
 <?php 

require_once 'class/class_mysql.php'; //se puede usar con postgres


$file = $_FILES['archivo'];//reciben el archivo

$archivo = new FileUp(); //instancia de la clase

//usamos el metodo uploadFile(nombre del archivo , nombre de la carpeta)
$var = $archivo->uploadFile( $file , "prueba" );

if($var[0] == true){
    echo "Archivo subido";
}else{
    echo "Error al subir archivo";
}

?>
```

##getBd con multiples archivos:

Para ello tenemos la clase ` FileUp()` que contiene los metodos:
    
`uploadFileMult()` 

* Recibe un primer parametro. file a subir.
* Recibe un segundo parametro el nombre de la carpeta donde se guarda el archivo.
* Retorna **Array:** con 2 valores el primero true , el sugundo la ruta final del archivo guardado.
* Retorna **Array:** con error  Si no se guardo el archivo.

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

require_once 'class/class_mysql.php'; //se puede usar con postgres


$file = $_FILES['archivo'];//reciben el archivo

$archivo = new FileUp(); //instancia de la clase

//usamos el metodo uploadFileMult(nombre del archivo , nombre de la carpeta)
//para la subida de varios archivos al servidor.

$var = $archivo->uploadFileMult($file , "prueba" );

echo "<pre>";

 print_r($var);//mostrando el resultado de la subida.

echo "</pre>";

?>
```


------------------------------------------------------
##Creditos:
 + Copyright by **FRANCISCO CAMPOS** 
 + Vercion: 0.1
 + Licencia: OpenSource 
 + Contactar: <camqui2011@gmail.com>