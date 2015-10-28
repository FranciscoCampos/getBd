<?php 

// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================
// clase  para gestionar las consultas 
// a la base de datos de postgres

require_once 'config/config.php';



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
	public  function InsertRegistro($sql , $sql2 = '', $valid = false )
	{
	
    //si es true verificamos si ya existe el registro
    if($valid == true ){
      //buscamos en la bd si el registro existe
        if(self::SelectRegistro($sql2) != true){

            $this->consulta = $this->consulta = pg_query($sql) 
        or die('Fatal Error: ' . pg_last_error());//errores de sintaxis

            return true;//si se registro corectamente

        }else{

          return false;//si ya existe el registro retordamos false para error
        }

// esto se ejecuta si no se envia la validacion del registro
// la insercion del registro normal
     }else{
      //creando el registro normal en la bd
          if($this->consulta = $this->consulta = pg_query($sql)) 
        or die('Fatal Error: ' . pg_last_error());//errores de sintaxis

            return true;//si se registro corectamente

          }     
          
        }
	}//final de metodo insert


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


	public  function UpdateRegistro($sql, $conf)
	{
		 
    if( $conf == 'update' ){ //seguro para evitar error en los metodos

          $this->consulta = pg_query($sql)
    or die('Fatal Error: ' . pg_last_error());

          return $this->consulta;

      }else{

          return false ;
      }
	}


//************************** DELETE SQL *********************************
//metodo para borrar registros de la base de datos


	public  function DeleteRegistro($sql, $conf)
	{
      if( $conf == 'delete' ){ //seguro para evitar error en los metodos

         $this->consulta = pg_query($sql)
              or die('Fatal Error: ' . pg_last_error());

          return $this->consulta;

      }else{

          return false ;
      }
	}
    



}//final de clase postgres



