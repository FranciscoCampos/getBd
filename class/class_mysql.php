<?php 

// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================
// clases  para gestionar las consultas a la base de datos mysql


// archivos requeridos para el funcionamiento

require_once 'config/config.php';
require_once 'class_help.php';


//======= clase Conectar la clase  extiende de Mysql ==========

class ConectarMysql extends Mysql
{ 
   
   //atributos de la clase 
    public $result = array(); //almasena el resultado de la consulta
    public $consulta; //almacena el query a ejecutar



//metodo verificador de la consulta realizada retorna true de ser positivo y false negativo
 
  protected function verificador($consulta){

      if ($consulta > 0) {return true; }
      else{ return false; }
  }



 //************************** INSERT SQL ********************************* 
// metodo para insertar registros de la base de datos
	
  public  function InsertRegistro($sql)
	{
		$this->consulta = mysql_query($sql, self::conectar())
    or die(mysql_error()); 
        
        return self::verificador($this->consulta);
	}


  // motodo contador de los resultados de la consulta cuando se requiere los registros

  protected function contador($consulta){
    
     $contador = mysql_num_rows($consulta); 
     return $contador; // retorna 1 o cero 
  }


//************************** SELECT SQL *********************************  
// metodo para seleccionar registros de la base de datos

    public function SelectRegistro($sql)
    {  
       $this->consulta = mysql_query($sql,self::conectar())
       or die(mysql_error());
       
       if(self::contador($this->consulta)){return true;}   
       else{return false; } 
    }

// metodo para listar los  registros de la base de datos en un array asociativo

    public function ListRegistro()
    {  
        
          while ($res=mysql_fetch_assoc($this->consulta))
            {
               $this->result[] = $res;
            }

        return $this->result;
    }


//************************** UPDATE SQL *********************************
// metodo para actulizar registros de la base de datos

	public  function UpdateRegistro($sql)
	{
		$this->consulta = mysql_query($sql,self::conectar())
    or die(mysql_error());
       
      return self::verificador($this->consulta);
	}


//************************** DELETE SQL *********************************
//metodo para borrar registros de la base de datos

	public  function DeleteRegistro($sql)
	{
		$this->consulta = mysql_query($sql,self::conectar())
    or die(mysql_error());
      return self::verificador($this->consulta);
	}
    


}//final de la clase conectar








