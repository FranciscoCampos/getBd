<?php namespace Config\Connect;

// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================

use Config\Base;
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
        $obj = Base::getConfig();
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

?>