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
  public function verificador($consulta){

      if ($consulta > 0) {return true; }
      else{ return false; }
  }


  
// metodo para insertar registros de la base de datos
	public  function InsertRegistro($sql)
	{
		$this->consulta = pg_query($sql) 
        or die('Fatal Error: ' . pg_last_error());
        return self::verificador($this->consulta);
	}


  // contador de los resultados de la consulta 

  public function contador($consulta){
    
     $contador = pg_num_rows($consulta); 
     return $contador;
  }
    
// metodo para seleccionar registros de la base de datos

    public function selectRegistro($sql)
    {  
       $this->consulta = pg_query($sql)
       or die('Fatal Error: ' . pg_last_error());
       if(self::contador($this->consulta)){return true;}   
       else{return false; } 
    }

// metodo para listar los  registros de la base de datos en un array asociativo

    public function listRegistro()
    {  
        
          while ($res=pg_fetch_assoc($this->consulta))
            {
               $this->result[] = $res;
            }

        return $this->result;
    }


// metodo para actulizar registros de la base de datos


	public  function updateRegistro($sql)
	{
		$this->consulta = pg_query($sql)
		or die('Fatal Error: ' . pg_last_error());
       
      return self::verificador($this->consulta);
	}

//metodo para borrar registros de la base de datos


	public  function deleteRegistro($sql)
	{
		$this->consulta = pg_query($sql)
		or die('Fatal Error: ' . pg_last_error());
      return self::verificador($this->consulta);
	}
    



}



