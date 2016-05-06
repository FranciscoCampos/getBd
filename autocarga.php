<?php 
 
/* Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================
// 
//AUTOCARGA DE LAS CLASES DE LA LIBRERIA GETBD
*/

function __autoload($class){

	$class = GETBD . DS .  str_replace( '\\', DS , $class ) . '.php';
	
	if (file_exists($class)) {

		require_once( $class );//retornando la clase indicada
	}
}




 