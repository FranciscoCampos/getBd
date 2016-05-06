<?php 

//CONSTANTE DEL LA LIBRERIA

//PATH
define('GETBD', dirname( __FILE__ ));

define('DS', DIRECTORY_SEPARATOR );


//ARCHIVO A INCLUIR PARA EL INICIO 
// DE  GETBD

//	USADO CON CARGA POR COMPOSER

//require_once 'vendor/autoload.php';

//	USADO CON CARGA MANUAL

require_once (GETBD . DS . 'autocarga.php');
