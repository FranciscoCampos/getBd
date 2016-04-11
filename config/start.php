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
    {  

    //inicializacion de los parametros de la conexion a la base datos mysql
        $obj = require_once'base.php';
        $this->localhost = $obj['mysql']['host'];
        $this->usuario = $obj['mysql']['user'];
        $this->password = $obj['mysql']['password'];
        $this->bd = $obj['mysql']['database'];
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



 

//===============================configuracion de Mysqli ===============================

 class Mysqly
 {

    private $usuario; //usuario de la base de datos
    private $localhost;//ruta local
    private $password ;//clave del host
    private $bd;  //nombre de la base de datos

    public function __construct()
    {  

    //inicializacion de los parametros de la conexion a la base datos mysql
        $obj = require_once'base.php';
        $this->localhost = $obj['mysqli']['host'];
        $this->usuario = $obj['mysqli']['user'];
        $this->password = $obj['mysqli']['password'];
        $this->bd = $obj['mysqli']['database'];
    }

    protected  function conectar(){ //funcion conectar que retorna la conexion 

        $con = mysqli_connect($this->localhost,$this->usuario,$this->password,$this->bd);
          mysqli_set_charset($con,"utf8");
          
          if (!mysqli_connect_errno()){
              return $con;
          }else{
            
            exit(1);
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
        
        $obj = require_once 'base.php';
        $this->localhost = $obj['postgre']['host'];
        $this->usuario = $obj['postgre']['user'];
        $this->password = $obj['postgre']['password'];
        $this->bd = $obj['postgre']['database'];

        $conectar = pg_connect("host=$this->localhost dbname=$this->bd user=$this->usuario password=$this->password");

    }


 }





//===============================configuracion de File ===============================
class ConfigFile
 {
    public $datos = array();
    public $sizes = array();


    public function __construct(){

        $obj = require_once 'base.php';
        $this->datos = array(

            'jpg' => $obj['exten']['jpg'],
            'png' => $obj['exten']['png'],
            'word' => $obj['exten']['word'],
            'pdf'  => $obj['exten']['pdf']

        );

        $this->sizes = array( 
            //nombre / byts / kbs
            's' => $obj['sizes']['s'] , //500kb
            'm' =>  $obj['sizes']['m'], //800 Kb
            'l' => $obj['sizes']['l'] , //1024 Kb
            'xl' => $obj['sizes']['xl'], //6144 Kb
        );
    }


//regresa la configuracion de los formatos permitidos
     public function getFormato(){
        return $this->datos;
    }

//regresa la configuracion de los tamanos permitidos

    public function getSize(){
        return $this->sizes;
    }
 }