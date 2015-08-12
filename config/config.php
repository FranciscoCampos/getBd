
<?php 


// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================



 class Mysql{

    private $usuario = 'root';
    private $localhost = 'localhost';
    private $password = '123456';
    private $bd = 'PRUEBA';

    public function __construct(){

        $this->localhost = 'localhost';
        $this->usuario = 'root';
        $this->password = '123456';
        $this->bd = 'prueba';
    }

    protected  function conectar(){
       
        $con = mysql_connect($this->localhost,$this->usuario,$this->password)
        or die(mysql_error());
        
        mysql_query("SET NAMES 'UTF8' ");
        mysql_select_db($this->bd)
        or die(mysql_error());
      
       return $con;
    }

 }


//========================================================================

class Postgres{

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




