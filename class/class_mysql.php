<?php 

// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================
// clases  para gestionar las consultas a la base de datos mysql


// archivos requeridos para el funcionamiento

require_once 'config/config.php';



//======= clase Conectar la clase  extiende de Mysql ==========

class ConectarMysql extends Mysql
{ 
   
   //atributos de la clase 
    public $result = array(); //almasena el resultado de la consulta
    public $consulta; //almacena el query a ejecutar




//metodo verificador de la consulta realizada retorna true de ser positivo y false negativo
 
  protected function verificador($var){

      if ($var > 0)
       {
        return true; 
       }
      else{ 
        return false; 
      }
  }



 //************************** INSERT SQL ********************************* 
// metodo para insertar registros de la base de datos
//con comprobacion del registro si  ya existe o no

  public  function InsertRegistro($sql , $sql2 = '', $valid = false )
	{
    //si es true verificamos si ya existe el registro
    if($valid == true ){
      //buscamos en la bd si el registro existe
        if(self::SelectRegistro($sql2) != true){

            $this->consulta = mysql_query($sql, self::conectar())
            or die(mysql_error());//errores de sintaxis

            return true;//si se registro corectamente

        }else{

          return false;//si ya existe el registro retordamos false para error
        }

// esto se ejecuta si no se envia la validacion del registro
// la insercion del registro normal
     }else{
      //creando el registro normal en la bd
          if($this->consulta = mysql_query($sql, self::conectar())
          or die(mysql_error()) > 0){
            return true;
          }     
          
        }
	}//final del metodo insert


  // metodo contador de los resultados de la consulta cuando se requiere los registros

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

	public  function UpdateRegistro($sql, $conf)
	{ 
      if( $conf == 'update' ){ //seguro para evitar error en los metodos

      		$this->consulta = mysql_query($sql,self::conectar());

          return $this->consulta;

      }else{

          return false ;
      }
    
	}


//************************** DELETE SQL *********************************
//metodo para borrar registros de la base de datos

	public  function DeleteRegistro($sql , $conf)
	{
		if( $conf == 'delete' ){ //seguro para evitar error en los metodos

          $this->consulta = mysql_query($sql,self::conectar());

          return $this->consulta;

      }else{

          return false ;
      }
	}
    
//************************** PROTEC SQL *********************************
//metodo para EVITAR  la inyec de sql registros de la base de datos

  public  function sqlValid( $var )
  {
    //seguro para evitar error en los metodos 
    //y la inyeccion de sql malo
      return mysql_real_escape_string($var);

  }

}//final de la clase conectar








