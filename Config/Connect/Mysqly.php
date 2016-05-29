<?php namespace Config\Connect;

// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================
use Config\Base;

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
        $obj = Base::getConfig();
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

?>