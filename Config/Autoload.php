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

		spl_autoload_register(function ($class){
			$class = GETBD . DS .  str_replace( '\\', DS , $class ) . '.php';
				
				if (file_exists($class)) {
					require_once( $class );
				}
	    });
		
	}
	
	
}



 