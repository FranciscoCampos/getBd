<?php 
/*
* Copyright by Francisco Campos 
* **********Año 2015***********
* ==================================
* ARCHIVO A INCLUIR PARA EL INICIO 
* DE GETBD
*
* USADO CON CARGA POR COMPOSER
*
*
*USADO CON CARGA MANUAL
*/

//CONSTANTE DEL LA LIBRERIA


//PATH
define('GETBD', dirname( __FILE__ ));

define('DS', DIRECTORY_SEPARATOR );

require_once (GETBD . DS . 'Config/Autoload.php');


//Config\Autoload::load();

Config\Autoload::load();
