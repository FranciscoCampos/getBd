<?php 

// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================
// version BETA
require'../config/con.php';


/*
 //class para subir archivos al servidor de manera facil
//imagescale()
*/


class File extends ConfigFile 
{

   private $file;//archivo a subir
   private $dire;//directorio
   private $repuesta = array();//repuesta sobre la subida
   private $opc;//parametros opcionales en beta
   
   
   
//metodo para subir el archivo al servidor

   public function upFile($file , $dire , $opc = array())
   {

	   	 $this->file = $file;//recibe el archivo

	     if ($this->file["error"] > 0)//si no hay error
		  {
		     echo "Error Fatal: ";

		  }
		  else
		  {//continua el proceso
			  
			  //verificando los valores permitido "jpg , png , git etc" 
		 	   if ( self::permitido($this->file) && self::sizes($this->file)) 
		 	   {
		 	   	
			         $this->dire = $dire;//recibimos el directorio donde sera guardado
			         
				         if(!file_exists($this->dire))//comprobando el directorio
						  {
							
							if(!mkdir($this->dire, 0777, true))//creando el directorio
							{
							    die('Fallo al crear las carpetas...');
							
							}else {
				         
				             	return self::subido();//se realiza la subidadel archivo
				          
				             }
							
						  }
						  else 
						  { 
			
							return self::subido();//se realiza la subidadel archivo

						  }

			 	}

			 	else
			 	{

			 	   	return $err = NULL;//error sino cumple con 
			 	   	                                       //los valores permitdos
			 	}//final de else de comprobacion de tamaño y peso

			}//final de la llave del else del error

  	 }//final del motodo upladfile


//metodo para la validaciones permitidas para subir archivos al servidor.
  
	  public function permitido($file)
	  {
	  
	     $res = false;//repuesta del metodo por defecto esta en false
	     foreach ( self::setFormato() as $key => $value ) 
	     {
	     	//validando solo formato del archivo
			 	if ($file['type'] == $value ) 
			 	{
			 		$res = true;
			 	}
		  }
			return $res; //var_dump($res);

	  }  
 

 //*************************BETA****************************************
  //metodo para la validaciones permitidas para subir archivos al servidor.
  
  protected function sizes($file)
  {
      
     $res = false;//repuesta del metodo por defecto esta en false
     foreach ( self::setSize() as $key => $value ) 
     {
     	//validando solo tamano  del archivo
		 	if ($file['size'] <= $value ) 
		 	{
		 		$res = true;
		 		//size maximo 6mgb;
		 	}
	 }
		return $res; //var_dump($res);
  }

//metodo para subir un solo archivo al servidor

protected function subido()
{

	// se mueve el archivo a la ruta creada
   
	if(move_uploaded_file($this->file['tmp_name'], "".$this->dire."/" . $this->file['name'].""))
	{

		//se retorna un array con el primer valor true
		//si se gurdo correctamente , mas la ruta donde 
		//se guardo el archivo para ser ingresado a la bd

		return $this->repuesta = array(true , $this->dire."/" . $this->file['name']);			             	
	}

	else
	{

		return false;//si hay error retorna false
	}
}



// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================
// version BETA



//****************************** ARCHIVOS MULTIPLES ****************************************************
//metodo para multiples ficheros

public function upFiles($file , $dire , $conf = array())
{

        
	    $this->file = $file;//variable que armacena el archivo
	    $this->dire = $dire;//variable de la ruta donde se guarda el archivo
	    $statusFile = array();//almacena los status y los errores de los archivos subidos

        // se comprueba si el directorio existe
        if(!file_exists($this->dire))
        {
        	//se crea el directorio con los permiso totales
			if(!mkdir($this->dire, 0777, true))//creando el directorio
			 {
				die('Fallo al crear las carpetas...');

			 }else{

			 	return self::subiendoMultiple();//donde se subi el archivo
			 }
			 
        }else{
            //si ya existe el directorio solo se guarda el archivo
        	return self::subiendoMultiple();//donde se subi el archivo
        }


   }//final del metodo uploadFileMult


//metodo que subir los multiples archivos al servidor
  protected function subiendoMultiple()
  {

	  	for ($i= 0; $i < count($this->file['name']); $i++)
	  	{ 
	  		
			if(move_uploaded_file($this->file['tmp_name'][$i], "".$this->dire."/" . $this->file['name'][$i].""))
			{
				
				//agregando la ruta al arreglo sel archivo movido correctamente	             		
				$this->statusFile[] =  $this->dire."/" . $this->file['name'][$i];
				
        	
			}
			else
			{

				$this->statusFile[] = $this->file['error'][$i];

			}
			
	    }//llave de for o cliclo

	  return $this->statusFile;//retornamos el arreglo con la informacion de subida
  }



}//final de clase file
