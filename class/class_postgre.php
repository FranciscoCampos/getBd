<?php 

// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================
// clase  para gestionar las consultas 
// a la base de datos de postgres

require_once 'config/config.php';
require_once 'class_help.php';


class ConectarPostgre extends Postgres {

 //atributos de la clase

    public $result = array();
    public $consulta;

    
  //metodo verificador de la consulta realizada retorna true y false
  protected function verificador($consulta){

      if ($consulta > 0) {return true; }
      else{ return false; }
  }


//************************** INSERT SQL *********************************  
// metodo para insertar registros de la base de datos
	public  function InsertRegistro($sql)
	{
		$this->consulta = pg_query($sql) 
        or die('Fatal Error: ' . pg_last_error());
        return self::verificador($this->consulta);
	}


  // contador de los resultados de la consulta 

  protected function contador($consulta){
    
     $contador = pg_num_rows($consulta); 
     return $contador;
  }
   
//************************** SELECT SQL *********************************  
// metodo para seleccionar registros de la base de datos

    public function SelectRegistro($sql)
    {  
       $this->consulta = pg_query($sql)
       or die('Fatal Error: ' . pg_last_error());
       if(self::contador($this->consulta)){return true;}   
       else{return false; } 
    }

// metodo para listar los  registros de la base de datos en un array asociativo

    public function ListRegistro()
    {  
        
          while ($res=pg_fetch_assoc($this->consulta))
            {
               $this->result[] = $res;
            }

        return $this->result;
    }


//************************** UPDATE SQL *********************************
// metodo para actulizar registros de la base de datos


	public  function UpdateRegistro($sql)
	{
		$this->consulta = pg_query($sql)
		or die('Fatal Error: ' . pg_last_error());
       
      return self::verificador($this->consulta);
	}


//************************** DELETE SQL *********************************
//metodo para borrar registros de la base de datos


	public  function DeleteRegistro($sql)
	{
		$this->consulta = pg_query($sql)
		or die('Fatal Error: ' . pg_last_error());
      return self::verificador($this->consulta);
	}
    



}//final de clase postgres



