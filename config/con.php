<?php
 error_reporting(E_ALL);
ini_set('display_errors', '1');

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

        $obj = require 'config.php';

        $this->localhost = $obj['mysql']['host'];
        $this->usuario = $obj['mysql']['user'];
        $this->password = $obj['mysql']['password'];
        $this->bd = $obj['mysql']['bd'];
    }

    private  function conectar(){ //funcion conectar que retorna la conexion 
       
        $con = mysql_connect($this->localhost,$this->usuario,$this->password);
        mysql_set_charset('utf8');
        mysql_select_db($this->bd);

        if ($con)
        {

          return $con;
        }
        else
        {
          return NULL;
              
        }

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
        $obj = require 'config.php';

        $this->localhost = $obj['postgres']['host'];
        $this->usuario = $obj['postgres']['user'];
        $this->password = $obj['postgres']['password'];
        $this->bd = $obj['postgres']['database'];

     $conectar = pg_connect("host=$this->host dbname=$this->bd user=$this->user password=$this->pass");
if ($conectar) {
    echo "listo";
}
    }


 }


//===============================configuracion de File ===============================
class ConfigFile
 {
    public $datos = array();
    public $sizes = array();
    public $style = array();
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
            'xl'=> 6291456, //6144 Kb
        );
        return $this->sizes;
    }

//configuracion de los tamanos permitidos

    public function setStyle(){
        $this->style = array( 
            //nombre / byts / kbs
            'w' => 'ancho' , //medidas en px
            'h' =>  'alto' , //medidas en px
            
        );
        return $this->style;
    }
 }