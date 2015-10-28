# Libreria getBd 
![](http://i.imgur.com/q2CBZ1t.png?1)

#### libreria basica para gestionar consultas a la base de dato.

------------------------------------------------------
 + Copyright by **FRANCISCO CAMPOS** 
 + Vercion: BETA
 + Licencia: OpenSource 
 + Contactar: <camqui2011@gmail.com>
 + [https://gitlab.com/franpc/getBd.git](http://)

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
    - README.md
    



### Descripcion de la Libreria:

------------------------------------------------------

**Class:** contiene las class necesaria para el manejo rapido de las consultas a la base de datos.

    - class_mysql.php:
Contiene las clases y metodos requerido el uso de Mysql.

    - class_postgre.php:
Contiene las clases y metodos requerido el uso de Postgres.

    - class_help.php:
Contiene las clases nesesarias para trabajos.  

+ Sessiones.
+ Subida de Archivos al servidor.



**Config:** Contiene las class dode se crea la conexion a la base de datos, aqui configuraremos las variables de la conexion: root , localhost , password.

    - config.php:

## Funcionamiento:

Configuracion de las variables de conexión.

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

**Class Postgres:**

 Inicializamos los valores en el  constructor de la clase.

    public function __construct()
    {  
        $this->localhost = 'nombre del host';
        $this->usuario = 'usuario del host';
        $this->password = 'clave del host';
        $this->bd = 'nombre de base de datos';
    }

Ejemplo de uso en Mysql:


**Archivo demo.php**
```
<?php

//Requerimos la clase para Mysql
require_once 'class/class_mysql.php';

//Instancisa del objeto para Mysql
 $con = new ConectarMysql();

?>

```


Ejemplo de uso en Postgres:


**Archivo demo.php**
```
<?php

//Requerimos la clase para Postgres
require_once 'class/class_postgre.php';

//Instancisa del objeto para Postgres
$con = new ConectarPostgre();

?>
```

## getBd con Mysql

**Insertar registros en la base de datos:**

`InsertRegistro( sql , opcional , opcional )`

Este metodo recibe tres parametro el primero que es la consulta SQL.
Los dos metodos restantes son opcionales. Si los enviamos podemos verificar si el  registro existe! antes de ser insertado todo en una sola linea de codigo.

- **sql:**  consulta sql a insertar
- **sql2 opcional:** consulta sql de verificacion opcional
- **opcional:**  se envia de forma TRUE para activar la verificacion del registro opcional.


Retorna:

- **true:**  si la consulta se realizo correctamente
- **false:** si la consulta no se realizo correctamente


Archivo demo.php

```
<?php 

require_once 'class/class_mysql.php';


$con = new ConectarMysql();

$sql = "INSERT INTO tabla (campos) Values (valores)";
//verificador del registro
$sql2 = " SELECT * FROM tabla WHERE campo = campos";

$con->InsertRegistro($sql , $sql2 , true);

    if($con != false)
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

Para ello tenemos 2 metodos:

`SelectRegistro( parametro )`

+ Recibe un parametro que es la consulta SQL
+ Retorna **True:** Si hay registro
+ Retorna **False:**  Si no hay registro

`ListRegistro()`

+ Retorna un Array Asociativo con los datos

## Consulta a la base de datos

```
 <?php
  require_once 'class/class_mysql.php';

  $con = new ConectarMysql();
  
  $sql = "SELECT * FROM tabla ";

  $con->SelectRegistro($sql);

     if ( $con > 0 ) 
     {
        $datos = ListRegistro();
        
        //mostrando los registros
        foreach ($datos as $dato) {
            echo $dato['campo'] . "<br>";
        }
     }
     else
     {
        echo "No! hay registros";
     }

 ?>
```

## Actualizar registro de la base de datos

Para ello tenemos el metodos:

`UpdateRegistro( sql , 'string' )`

+ Recibe dos parametro que son: la consulta SQL , y la cadena 'update', para evitar error en la consulta. 
+ Retorna **True:** Si se actualizo el registro
+ Retorna **False:** Si no se actualizo el registro

```
 <?php
  require_once 'class/class_mysql.php';

     $con = new ConectarMysql();
      
     $sql = "UPDATE  tabla SET campo = 'valor' where condicion";

     if ( $con->UpdateRegistro($sql , 'update') != false  ) 
     {
        echo "Registro actualizado";
     }
     else
     {
        echo "No! se actualizo el registro";
     }

 ?>
```


## Eliminar registro de la base de datos

Para ello tenemos el metodos:

`DeleteRegistro(sql , string' )`

+ Recibe dos parametro que son : la consulta SQL , y la cadena 'delete', para evitar error en la consulta. 
+ Retorna **True:** Si se elimino el registro
+ Retorna **False:** Si no se elimino el registro

```
 <?php
  require_once 'class/class_mysql.php';

  $con = new ConectarMysql();
  
  $sql = "DELETE FROM tabla WHERE condición";

  $con->DeleteRegistro($sql , 'delete');

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

## getBd  con  Postgres

El uso de getBd con Postgres es igual al funcionamiento con Mysql tenemos los mismo metodos. Solo cambia es el **include de la class**

```
<?php

//Requerimos la clase para Postgres
require_once 'class/class_postgre.php';

//Instancisa del objeto para Postgres
$con = new ConectarPostgre();

?>
```

`InsertRegistro( parametro , parametro , true )` 

`SelectRegistro( parametro )`

`ListRegistro()`

`UpdateRegistro( parametro , 'string' )`

`DeleteRegistro( parametro , 'string' )` 

**Nota:** 
 >puede ver los ejemplos de los metodos arriba.

## getBd subir archivos al servidor

Para ello tenemos la clase ` FileUp()` que contiene los metodos:
    
`uploadFile()` 

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

require_once 'class/class_help.php';


$file = $_FILES['archivo'];//reciben el archivo

$archivo = new FileUp(); //instancia de la clase

//usamos el metodo uploadFile(nombre del archivo , nombre de la carpeta)

$var = $archivo->uploadFile( $file , "nombre de la carpeta" );

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

Para ello tenemos la clase ` FileUp()` que contiene los metodos:
    
`uploadFileMult()` 

* Recibe un primer parametro. file a subir.
* Recibe un segundo parametro el nombre de la carpeta donde se guarda el archivo.
* Retorna **Array:** con 2 valores el primero true , el sugundo la ruta final del archivo guardado.
* Retorna **Array:** con error  Si no se guardo el archivo.

```
array respuesta = {
  [0] => 'true',
  [1] => 'ruta del archivo guardado'
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

require_once 'class/class_mysql.php'; //se puede usar con postgres


$file = $_FILES['archivo'];//reciben el archivo

$archivo = new FileUp(); //instancia de la clase

//usamos el metodo uploadFileMult(nombre del archivo , nombre de la carpeta)
//para la subida de varios archivos al servidor.

$var = $archivo->uploadFileMult($file , "carpeta a guardar" );

echo "<pre>";

 print_r($var);//mostrando el resultado de la subida.

echo "</pre>";

?>
```


------------------------------------------------------
## Creditos:
 + Copyright by **FRANCISCO CAMPOS** 
 + Vercion: 0.1
 + Licencia: OpenSource 
 + Contactar: <camqui2011@gmail.com>