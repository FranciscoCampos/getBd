<?php 

// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================
// version BETA

// class para subir archivos al servidor de manera facil


class FileUp{

   private $file;
   private $dire;
   private $repuesta = array();
   private $confi;
   
   
//metodo para subir el archivo al servidor

   public function uploadFile($file , $dire , $conf = array())
   {

	   	 $this->file = $file;

	     if ($this->file["error"] > 0)
		  {
		     echo "Error Fatal: ";

		  }else{
			  
			  //verificando los vlores permitido 
		 	   if ( self::permitido($this->file) != false ) {
		 	   	
				         $this->dire = $dire;
				         
					         if(!file_exists($this->dire))
							  {
								if(!mkdir($this->dire, 0777, true))//creando el directorio
								{
								    die('Fallo al crear las carpetas...');
								}else {
					         
					             	return self::subido();
					          
					             }
								
							  }else { 
				
								return self::subido();

							  }

			 	   }else{

			 	   	return "error no cumple los requicito";

			 	   }//final de else de comprobacion de tamaño y peso

			  }//final de la llave del else del error

  	 }//final del motodo upladfile


//metodo para la validaciones permitidas para subir archivos al servidor.
  
  public function permitido($file){
  
      $res = false;
  
     //validando solo formato img
  
      if ($file['type'] == 'image/jpeg') {
      	 $res = true;

      }else if($file['type'] == 'image/png'){//png
      	 $res = true;

      }else if($file['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'){ //word
      	 $res = true;

      }else if($file['type'] == 'application/pdf'){ //pdf
      	 $res = true;
      }

      return $res; //retornado el valor true si pasa
  }  
  
  //metodo para la validaciones permitidas para subir archivos al servidor.
  
  protected function taPermitido($file){
      
      $res = false;
     
     //validando solo tamaño
     
      if ($file['size'] <= 2048) {
      	 $res = true;

      }

      return $res; //retornado el valor true si pasa
  }

//metodo para subir el archivo al servidor

protected function subido(){

	// se mueve el archivo a la ruta creada

	if(move_uploaded_file($this->file['tmp_name'], "".$this->dire."/" . $this->file['name']."")){

		//se retorna un array con el primer volor true , mas la ruta donde se guardo el archivo

		return $this->repuesta = array(true , $this->dire."/" . $this->file['name']);
					             	
	}else{

		return false;//si hay error retorna false
	}
}



//****************************** ARCHIVOS MULTIPLES ****************************************************
//metodo para multiples ficheros

public function uploadFileMult($file , $dire , $conf = array()){

        
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
  protected function subiendoMultiple(){

	  	for ($i= 0; $i < count($this->file['name'])  ; $i++) { 
	  		//recore el arreglo de archios
	        //if ($this->file["error"][$i] > 0)//verifica los errores de subida
			//{
				//$statusFile[] = "error"; //se almacena en el arreglo los errores

			//}else{
				//movemos ya los archivos al servidor
				if(move_uploaded_file($this->file['tmp_name'][$i], "".$this->dire."/" . $this->file['name'][$i]."")){
					//agregando la ruta al arreglo sel archivo movido correctamente	             		
					$this->statusFile[] =  $this->dire."/" . $this->file['name'][$i];
					//array_push(	$this->statusFile[] ,   $this->dire."/" . $this->file['name'][$i]);          	
				}else{

					$this->statusFile[] = $this->file['error'][$i];
					//array_push(	$this->statusFile[] , $this->file['error'][$i]);
				}
			//}
	    }//llave de for o cliclo

	  return $this->statusFile;//retornamos el arreglo con la informacion de subida
  }

}//final de clase file
