<?php 

// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================
// version BETA


require'../config/start.php';
//require __DIR__ . '/config' . '/start.php';

/*
*
*class para subir archivos al servidor de manera facil
*
*/


class File extends ConfigFile 
{

   private $file;//archivo a subir
   private $newFile ;
   private $dire;//directorio
   private $repuesta = array();//repuesta sobre la subida
   private $opc;//parametros opcionales en beta
   
   
   
/*
	METOHODO PARA SUBIR UN FILE AL SERVIDOR
*/

   public function upFile($file , $dire , $opc = array())
   {

	   	 $this->file = $file;//recibe el archivo

	     if ($this->file["error"] > 0)//si no hay error
		  {
		     echo "Error Fatal: ";

		  }
		  else //continua el proceso
		  {
			  
			  //verificando los valores permitido "jpg , png , git etc" 
		 	   if ( self::permitido($this->file) && self::sizes($this->file)) 
		 	   {
		 	   	
			         $this->dire = $dire;//recibimos el directorio donde sera guardado
			         
				         if(!file_exists($this->dire))//comprobando el directorio
						  {
							
								if(!mkdir($this->dire, 0775, true))//creando el directorio
								{
							    	exit('Fallo al crear las carpetas...');
							
								}else {
				         			chmod($this->dire, 0777);
				             		return self::subido();//se realiza la subidadel archivo
				          
				             	}
							
						  }
						  else 
						  { chmod($this->dire, 0777);
							return self::subido();//se realiza la subidadel archivo
						  }

			 	}
			 	else
			 	{
			 		/*error sino cumple con 
			 	   	 los valores permitdos retorna NULL */
			 	   	return $err = NULL;
			 	}//final de else de comprobacion de tamaño y peso

			}//final de la llave del else del error

  	 }//final del motodo upladfile


//METOHODO QUE VALIDA LOS FORMATOS PERMITIDOS HANTES DE SUBIR.
  
	  public function permitido($file)
	  {
	  
	     $res = false;//repuesta del metodo por defecto esta en false
	     foreach ( self::getFormato() as $key => $value ) 
	     {
	     	//validando solo formato del archivo
			 	if ($file['type'] == $value ) 
			 	{
			 		$res = true;
			 	}
		  }
			return $res; //var_dump($res);

	  }  
 

/*
*
* METOHODO QUE VALIDA LOS TAMAÑOS PERMITIDOS HANTES DE SUBIR.
*/
  
  protected function sizes($file)
  {
      
     $res = false;//repuesta del metodo por defecto esta en false
     foreach ( self::getSize() as $key => $value ) 
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

//METOHODO PARA SUBIR UN FILE AL SERVIDOR EL FINAL

protected function subido()
{

	// se mueve el archivo a la ruta creada

	//REMPRAZANDO EL NOMBRE DE LA IMAGEN PARA QUE SE SOBRE ESCRIBA

	/*
		FOTO_MIA.JPG => +time().rand() =  290190FOTO MIA.JPG
		FOTO MIA.JPG => +time().rand() => strtolower(str_replace(' ', '_', 290190FOTO_MIA.JPG)) 
		=> FILE FINAL  (290190FOTO_MIA.JPG)
	*/

	// LE SUMAMOS EL RANDON PARA EVITAR LA SOBRE ESCRITURA DEL ARCHIVO
	$noCopi = time().rand().$this->file['name']; 

    // LE REMPLAZAMOS LOS ESPACIOS POR _ AL ARCHVIO
	$this->newFile = strtolower(str_replace(' ', '_', $noCopi));
   
	if(move_uploaded_file($this->file['tmp_name'], "".$this->dire."/" . $this->newFile .""))
	{
		//AQUI LE DAMOS PERMISO AL ARCHIVO
		
		chmod($this->dire."/" . $this->newFile, 0777);
		//se retorna un array con el primer valor true
		//si se gurdo correctamente , mas la ruta donde 
		//se guardo el archivo para ser ingresado a la bd
		//unlink($this->file['tmp_name'].$this->newFile);
		//error al devolver el nombre
		return $this->repuesta = array(true , $this->dire."/" . $this->newFile);
	}

	else
	{

		return false;//si hay error retorna false
	}
}//FINAL DEL METHODO SUBIDO




/****************************** ARCHIVOS MULTIPLES ****************************************************/

//METHODO PARA FILES MULTIPLES 

public function upFiles($file , $dire , $conf = array())
{

        
	    $this->file = $file;//variable que armacena el archivo
	    $this->dire = $dire;//variable de la ruta donde se guarda el archivo
	    $statusFile = array();//almacena los status y los errores de los archivos subidos

        // se comprueba si el directorio existe
        if(!file_exists($this->dire))
        {
        	//se crea el directorio con los permiso totales
			if(!mkdir($this->dire, 0775, true))//creando el directorio
			 {
				die('Fallo al crear las carpetas...');

			 }else{
			 	//le damos permisos por si acaso
			 	chmod($this->dire, 0777);
			 	return self::subiendoMultiple();//donde se subi el archivo
			 }
			 
        }else{
        	//le damos permisos por si acaso
        	chmod($this->dire, 0777);
            //si ya existe el directorio solo se guarda el archivo
        	return self::subiendoMultiple();//donde se subi el archivo
        }


   }//final del metodo uploadFileMult


//metodo que subir los multiples archivos al servidor
  protected function subiendoMultiple()
  {

	  	for ($i= 0; $i < count($this->file['name']); $i++)
	  	{ 
	  		//REMPRAZANDO EL NOMBRE DE LA IMAGEN PARA QUE SE SOBRE ESCRIBA

			/*
				FOTO_MIA.JPG => +time().rand() =  290190FOTO MIA.JPG
				FOTO MIA.JPG => +time().rand() => strtolower(str_replace(' ', '_', 290190FOTO_MIA.JPG)) 
				=> FILE FINAL  (290190FOTO_MIA.JPG)
			*/

			// LE SUMAMOS EL RANDON PARA EVITAR LA SOBRE ESCRITURA DEL ARCHIVO
			$noCopi = time().rand(). $this->file['name'][$i]; 
			// LE REMPLAZAMOS LOS ESPACIOS POR _ AL ARCHVIO
			$newFile = strtolower(str_replace(' ', '-', $noCopi));

			if(move_uploaded_file($this->file['tmp_name'][$i], "".$this->dire."/" . $newFile .""))
			{
				
				//agregando la ruta al arreglo sel archivo movido correctamente	             		
				$this->statusFile[] =  $this->dire."/" . $newFile;
				
			}
			else
			{

				$this->statusFile[] = $this->file['error'][$i];

			}
			
	    }//llave de for o cliclo

	  return $this->statusFile;//retornamos el arreglo con la informacion de subida
  }



}//final de clase file
