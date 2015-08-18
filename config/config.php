
<?php 
// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================



//===============================configuracion de Mysql ===============================

 class Mysql
 {

    private $usuario; //usuario de la base de datos
    private $localhost;//ruta local
    private $password ;//clave del host
    private $bd;  //nombre de la base de datos

    public function __construct()
    {  //inicializacion de los parametros de la conexion a la base datos mysql

        $this->localhost = 'localhost';
        $this->usuario = 'root';
        $this->password = '123456';
        $this->bd = 'PRUEBA';
    }

    protected  function conectar(){ //funcion conectar que retorna la conexion 
       
        $con = mysql_connect($this->localhost,$this->usuario,$this->password)
        or die(mysql_error());
        
        mysql_query("SET NAMES 'UTF8' ");
        mysql_select_db($this->bd)
        or die(mysql_error());
      
       return $con;
    }

 }


//===============================configuracion de Postgres ===============================

class Postgres
{

   private $host;
   private $user;
   private $pass;
   private $db;

    public function __construct()
    {
        $this->host = 'localhost';
        $this->user = 'postgres';
        $this->pass = '123456';
        $this->bd = 'prueba';

    $conectar = pg_connect("host=$this->host dbname=$this->bd user=$this->user password=$this->pass");

    }


 }

