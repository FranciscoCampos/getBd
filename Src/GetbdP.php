<?php namespace Src;

// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================
// clase  para gestionar las consultas 
// a la base de datos de postgres

//// DRIVER POSTGRES

//require '../Config/Start.php';


use \Config\Connect\Postgre;

class GetbdP  extends Postgre{

 //atributos de la clase

    public $result = array();
    public $consulta;
    private $status = NULL;

    
  //metodo verificador de la consulta realizada retorna true y false
  protected function verificador($consulta){

      if ($consulta > 0) {return true; }
      else{ return false; }
  }

// METOHOD QUE ACTIVA LOS HERRORES DE EJECUCION

  static public function Debug(){
      error_reporting(-1);
      ini_set('display_errors', '1');
  }




//************************** INSERT SQL *********************************  

//validor de registro repetido

  public function check($var= array()){
       
       if (is_array($var)) 
       {
       	
	       $this->consulta = pg_query("SELECT * FROM $var[0] WHERE $var[1] = '$var[2]'")
	       or die('Fatal Error: ' . pg_last_error());
	       
	        if(self::contador($this->consulta)){
	            $this->status = true;
	            return $this;//si se registro corectamente

	        }else{

	           $this->status = false;
	            return $this;//si se registro corectamente RETORNO EL OBJETO EN SI
	        }
       }
       else
       {
       	    $this->consulta = pg_query($var) //SI NO ES UN ARRAY EJECUTO LA CONSULTA NORMAL
		       or die('Fatal Error: ' . pg_last_error());

		       if(self::contador($this->consulta))
           {
			        $this->status = false;
		            return $this;//si se registro corectamente
		       }   
		       else
           {
		         $this->status = false;
	             return $this;//si se registro corectamente
		       } 
       }

  }//FINAL DE METOHOD CHECK


//METODO SAVE() PARA GUARDAR REGISTROS Y TAMBIEN COMPRUEBA REGISTRO
public  function save( $sql , $var = array())
{
    // verificamos si status no esta vacia
    if (is_null($var))
    {
        $this->consulta = pg_query($sql )or die('Fatal Error: ' . pg_last_error());//errores de sintaxis
         //self::verificador($this->consulta); 
        if($this->consulta){return true;}else{return true;}
     }
    else
    {  
       $sQ = "SELECT * FROM $var[0]  WHERE  $var[1]  = '$var[2]' LIMIT 1";
       $sq = explode(',',$sQ);
       $sql = implode($sq);
       $consulta = pg_query($sql)or die('Fatal Error: ' . pg_last_error());

       if(pg_num_rows($consulta ) > 0)
        { 
          return null; //si el nombre esta registrado
        }
       else{

           $this->consulta = pg_query($sql)or die('Fatal Error: ' . pg_last_error());
                                         // or die(mysql_error());//errores de sintaxis
          if($this->consulta){return true;}else{return false;}//si se registro corectamente   
          
        }
     }//llave de else
}//final del metodo insert






// contador de los resultados de la consulta 
  protected function contador($consulta){
     $contador = pg_num_rows($consulta); 
     return $contador;
  }
   

//************************** SELECT SQL *********************************  
// metodo para seleccionar registros de la base de datos COMPLEJAS

    public function find($sql)
    {  
       $this->consulta = pg_query($sql)
       or die('Fatal Error: ' . pg_last_error());

       if(self::contador($this->consulta)){
        return $this;//RETORNAMOS EL OBJETO PARA SER ENCADENADO
      }   
       else{
        return $this; //RETORNAMOS EL OBJETO PARA SER ENCADENADO
      } 
    }

//consultas simples  de datos
    public function findAll($tabla)
    {  
       $this->consulta = pg_query("SELECT * FROM $tabla")
       or die('Fatal Error: ' . pg_last_error());

       if(self::contador($this->consulta)){
        return $this;
      }   
       else{
        return $this; 
      } 
    }


// metodo para listar los  registros de la base de datos en un array asociativo

    public function show()
    {  
        
          while ($res=pg_fetch_assoc($this->consulta))
            {
               $this->result[] = $res; //REGRESA UN ARREGLO ASOCIATIVO
            }

        return $this->result;
    }



    public function showObj()
    {  
        
          while ($res=pg_fetch_object($this->consulta))
            {
               $this->result[] = $res;
            }

        return $this->result;
       
    }



//selecionar un registro unico de la base de datos

 public function findOne($var = array()){

   $this->consulta = pg_query("SELECT * FROM $var[0] WHERE $var[1] = $var[2]")
         or die('Fatal Error: ' . pg_last_error());

      return $fila = pg_fetch_array($this->consulta);
        //var_dump($fila);
 }


//************************** UPDATE SQL *********************************
// metodo para actulizar registros de la base de datos


	public  function update($sql, $conf)
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


	public  function remove($sql, $conf)
	{
      if( $conf == 'delete' ){ //seguro para evitar error en los metodos

         $this->consulta = pg_query($sql)
              or die('Fatal Error: ' . pg_last_error());

          return $this->consulta;

      }else{

          return false ;
      }
	}

//seguro en el query
  static public  function Valid( $var )
  {
    //seguro para evitar error en los metodos 
    //y la inyeccion de sql malo
      return pg_escape_string($var);

  }
    



}//final de clase postgres


