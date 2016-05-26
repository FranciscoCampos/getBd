<?php namespace Config;

/* 
* Copyright by Francisco Campos 
* **********Año 2015***********
* ==================================
*
* AUTOCARGA DE LAS CLASES DE LA LIBRERIA GETBD
*/


class Autoload{

	public static function load(){

		function __autoload($class){

			$class = GETBD . DS .  str_replace( '\\', DS , $class ) . '.php';
			
			if (file_exists($class)) {
				//retornando la clase indicada
				require_once( $class );
			}
		}
		
	}
	
}



?>

 