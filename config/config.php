
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

        $this->localhost = '';
        $this->usuario = '';
        $this->password = '';
        $this->bd = '';
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
    { //inicializacion de los parametros de la conexion a la base datos postgres
        $this->host = 'localhost';
        $this->user = 'fran';
        $this->pass = '123456';
        $this->bd = 'beta';

     $conectar = pg_connect("host=$this->host dbname=$this->bd user=$this->user password=$this->pass");

    }


 }


//===============================configuracion de File ===============================
class ConfigFile
 {
    public $datos = array();
    public $sizes = array();

//formatos permitidos
     public function setFormato(){
        $this->datos = array(

            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'word' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'pdf'  => 'application/pdf'

        );
        return $this->datos;
    }

//configuracion de los tamanos permitidos

    public function setSize(){
        $this->sizes = array( 
            //nombre / byts / kbs
            's' => 4096000 , //500kb
            'm' =>  819200 , //800 Kb
            'l' => 1048576 , //1024 Kb
            'xl' => 6291456, //6144 Kb
        );
        return $this->sizes;
    }
 }



