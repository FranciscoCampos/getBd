<?php namespace Config\Connect;

// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================
use Config\Base;
//===============================configuracion de Postgres ===============================

class Postgre
{

   private $host;
   private $user;
   private $pass;
   private $db;

    public function __construct()
    { //inicializacion de los parametros de la conexion a la base datos postgres
        
        $obj = Base::getConfig();
        $this->localhost = $obj['postgre']['host'];
        $this->usuario = $obj['postgre']['user'];
        $this->password = $obj['postgre']['password'];
        $this->bd = $obj['postgre']['database'];

        $conectar = pg_connect("host=$this->localhost dbname=$this->bd user=$this->usuario password=$this->password");

    }


 }

?>