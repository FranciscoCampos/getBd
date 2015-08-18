<?php 

// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================


// class para subir archivos al servidor de manera facil


class FileUp{

   private $file;
   private $dire;
   private $repuesta = array();
   
   
//metodo para subir el archivo al servidor

   public function uploadFile($file , $dire , $opc=array())
   {

	   	 $this->file = $file;
	     if ($this->file["error"] > 0)
		  {
		     echo "Error Fatal: " . $this->file["error"]['error'];
		  }

		 else{
			  
			  //verificando los vlores permitido 
		 	   if (self::permitido($this->file) != false && self::taPermitido($this->file) != false) {
		 	   	
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
  protected function permitido($file){
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
      if (($file['size'] / 1024) <= 2048) {
      	 $res = true;

      }

      return $res; //retornado el valor true si pasa
  }

protected function subido(){
	if(move_uploaded_file($this->file['tmp_name'], "".$this->dire."/" . $this->file['name']."")){
					             		
		return $this->repuesta = array(true , $this->dire."/" . $this->file['name']);
					             	
	}else{

		return false;
	}
}

//metodo para multiples ficheros


public function uploadFileMult($file , $dire ){

        
	    $this->file = $file;
	    $this->dire = $dire;
	    $statusFile = array();

        if(!file_exists($this->dire))
        {

			if(!mkdir($this->dire, 0777, true))//creando el directorio
			 {
				die('Fallo al crear las carpetas...');

			 }else{

			 	return self::subiendoMultiple();
			 }
			 
        }else{

        	return self::subiendoMultiple();
        }


   }

 
  protected function subiendoMultiple(){

	  	for ($i= 0; $i < sizeof($this->file)  ; $i++) { 

	        if ($this->file["error"][$i] > 0)
			{
				//echo "Error Fatal:";
				$statusFile[] = "error";
			}else{

				if(move_uploaded_file($this->file['tmp_name'][$i], "".$this->dire."/" . $this->file['name'][$i]."")){
						             		
					$statusFile[] =  $this->dire."/" . $this->file['name'][$i];
						             	
				}
			}
	    }//llave de for o cliclo

	  return $statusFile;
  }

}//final de clase file

