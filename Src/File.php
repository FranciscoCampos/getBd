<?php namespace Src;

/* 
* Copyright by Francisco Campos 
* **********Año 2016***********
* ==================================
*
* CLASE PARA SUBIDA DE FILE
* CON GETBD ES MUY FACIL
* DESCARGA Y COMPRESION DEL FILE
* EN .ZIP SI LO DESEAN...
*
*/
use \Config\Files\ConfigFile;

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
								try {
									
										if(!mkdir($this->dire, 0775, true))//creando el directorio
										{
									    	throw new \Exception(' Upps !!');
									
										}else {
						         			chmod($this->dire, 0777);
						             		return self::subido();//se realiza la subidadel archivo
						          
						             	}

								} catch (\Exception $e) {
									echo "DIRECTORY NOT CREATED ┌∩┐(◕_◕)┌∩┐" . $e->getMessage();
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
			 	   	 los valores permitdos retorna 1 */
			 	   	return $err = 1;
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
        	try {
        		
		        	//se crea el directorio con los permiso totales
					if(!mkdir($this->dire, 0775, true))//creando el directorio
					 {
						throw new \Exception(' Upps !!');

					 }else{
					 	//le damos permisos por si acaso
					 	chmod($this->dire, 0777);
					 	return self::subiendoMultiple();//donde se subi el archivo
					 }

        	} catch (\Exception $e) {
        		echo "DIRECTORY NOT CREATED ┌∩┐(◕_◕)┌∩┐" . $e->getMessage();
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



//DESCARGA Y COMPRECION DE LOS FILES CON GETBD=>FILE()



 /*	
 * METODO PARA DESCARGAR EL FILE
 * PROTOTIPO DEL dowFile()
 * GETBD->dowfile(ruta, option)
 * SRC ES LA RUTA DEL ARCHIVO, A BAJAR
 * ZIP OPCIONAL POR DEFECTO ESTA EN FALSE,
 * SI SE CAMBIA A TRUE ACTIVA LA COMPRESION,
 * EN FORMATO ZIP...
 */

public function dowFile($srcFile, $zip = false){

	try {
		 
			if ($zip == TRUE && is_bool($zip)) {
				
				if(!empty($srcFile)){

                    $srcTem = self::zipFile( $srcFile );
                    /*
					* LLAMADO DE LA FUNCION DE HEADERFILE()
					* PARA SER DESCARGADO
				    */
					self::headerFile( $srcTem );
					/*
					* LIBERAMOS MEMORIA BORRANDO
					* EL .ZIP FINAL DESPUES DE BAJARLO
				    */
					unlink($srcTem);
					return TRUE;

				}else{
					throw new \Exception(' Upps !!');
				}

			}else{

				if(!empty($srcFile)){

					self::headerFile($srcFile);
					

				}else{

					throw new \Exception(' Upps !!');
				}
			}

	} catch (\Exception $e) {
		echo "Empty Route ٩(×̯×)۶ " . $e->getMessage();
	}

    
}//FINAL DEL METODO DONFILE()


/*
 * METODO PARA DERCARGAR ARCHIVO
 * HEADERFILE(RUTA_ARCHIVO)
 * SOLO LA RUTA Y LISTO...
*/

public function headerFile($src){

	/*
     * RUTA BASE /CARPETA/SUBCARPETA/ARCHIVO.PNG
     */
    $rutaBase = explode("/", $src);
    /*
	* ARRAY([0]=>'CARPETA',[1]=>'SUBCARPETA',[2]=>'ARCHIVO.PNG')
    */
	$numElem = count($rutaBase);
	/*
	* TAMANIO ARRAY() => 3 ELEMENTO')
    */
	$f = $rutaBase[$numElem - 1];
	/*
	* ARRAY(TAMANIO) - 1 = ARCHIVO.PNG 
    */
	array_pop($rutaBase); 
	/*
	* ARRAY([0]=>'CARPETA',[1]=>'SUBCARPETA')
    */
	$ruta = implode("/", $rutaBase);
	/*
	* RUTA BASE /CARPETA/SUBCARPETA/
    */
	$file = basename($f);
	/*
	* RUTA BASE REAL DEL ARCHIVO
    */
	$srcBase = $ruta ."/" . $file;
	/*
	* RUTA BASE /CARPETA/SUBCARPETA/ARCHIVO.PNG
    */
    try {
    	
		if (is_file($srcBase))
		{
		   header('Content-Type: application/force-download');
		   header('Content-Disposition: attachment; filename='. $file);
		   header('Content-Transfer-Encoding: binary');
		   header('Content-Length: '. filesize($srcBase));
		   readfile($srcBase);
		   /*
		    * RETURN TRUE O 1 PARA SU CONTROL
		    * EN EL CONTROLADOR O USO.
		   */
		   return true;
		   

		}else{
			throw new \Exception(' Upps !!');
		}

    } catch (\Exception $e) {
    	echo "Dead File ٩(×̯×)۶ " . $e->getMessage();
    }
	
}

/*
 * METODO PARA COMPRIMIR ARCHIVO
 * EN .ZIP ZIPFILE(RUTA_ARCHIVO, FALSE)
 * FALSE PARA UN ARCHIVO A LA VES
 * TRUE PARA MULTIPLES ARCHIVOS
*/

public function zipFile($addFile , $mult = false){
	
	$down = new \ZipArchive();
    /*
     * RUTA BASE /CARPETA/SUBCARPETA/ARCHIVO.PNG
     */
    $rutaBase = explode("/", $addFile);
    /*
	* ARRAY([0]=>'CARPETA',[1]=>'SUBCARPETA',[2]=>'ARCHIVO.PNG')
    */
	$elem = count($rutaBase);
	/*
	* TAMANIO ARRAY() => 3 ELEMENTO')
    */
	$file_ext = $rutaBase[$elem - 1];
	/*
	* ARRAY(TAMANIO) - 1 = ARCHIVO.PNG 
    */
	$file = preg_split('/([.])\w+/', $file_ext);
	/*
	* ARCHIVO.PNG => ('/([.])\w+/')
	* ARRAY([0]=>'ARCHIVO',[1]=>'PNG')
    */
    $fileName = $file[0];
    /*
	* FILE => ARCHIVO
    */
	array_pop($rutaBase); 
	/*
	* ARRAY([0]=>'CARPETA',[1]=>'SUBCARPETA')
    */
	$ruta = implode("/", $rutaBase);
	/*
	* RUTA BASE /CARPETA/SUBCARPETA/
    */
	$srcBase = $ruta ."/". $fileName .".zip";
	/*
	* RUTA BASE /CARPETA/SUBCARPETA/ARCHIVO.ZIP
    */

	try {
		if (!$down->open($srcBase, \ZipArchive::CREATE)) {

		   throw new \Exception(' Upps !!');

		}else{

			/*
			* AQUI LO DE MULTIPLE FILE EN UN .ZIP
			*
			*/
			$down->addFile( $addFile , $file_ext);
			$down->close();
			/*
			* RETURN LA RUTA FINAL DEL .ZIP
			*/
			return $srcBase;
		}
		
	} catch (\Exception $e) {
    	echo "Dead File  " . $e->getMessage();
    }
}



}//FINAL DE LA CLASE FILE
