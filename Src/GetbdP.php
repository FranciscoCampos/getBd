<?php namespace Src;

/* Copyright by Francisco Campos 
 **********Año 2016***********
 ==================================
*
* CLASE PARA CONSULTAS
* CON POSTGRES A LA BASE DE DATOS
*
*DRIVER POSTGRES
*
* 
*
*/
use \Config\Connect\Postgre;

class GetbdP  extends Postgre{

 //atributos de la clase

    public $result = array();
    public $consulta;
    private $status = NULL;

    
  //metodo verificador de la consulta realizada retorna true y false
  protected function verificador($consulta){

      if ($consulta > 0){
        return true; 
      }
      else{ 
        return false; 
      }
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


/*
* METODO SAVE() PARA GUARDAR REGISTROS Y TAMBIEN COMPRUEBA REGISTRO
*
* SAVE(SQL , NULL) INSERT NORMAL
* RETURN TRUE Y FALSE
* SAVE(SQL , ARRAY()) INSERT CON VALIDACION DE DATOS
* RETURN TRUE Y FALSE Y NULL PARA LA VALIDACION
*/

public  function save( $sql , $var = array())
{
    // verificamos si status no esta vacia
    if (is_null($var))
    {
        $this->consulta = pg_query($sql )or die('Fatal Error: ' . pg_last_error());//errores de sintaxis
         //self::verificador($this->consulta); 
        if($this->consulta){return true;}else{return false;}
     }
    else
    {  
       $sQ = "SELECT * FROM $var[0]  WHERE  $var[1]  = '$var[2]' LIMIT 1";
       $sq = explode(',',$sQ);
       $sql2 = implode($sq);
       $consulta = pg_query($sql2)or die('Fatal Error: ' . pg_last_error());

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
// Metodo para seleccionar registros de la base de datos COMPLEJAS

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

/*
* FINDALL('TABLA')
* RETORNA TODO LOS REGISTRO DE LA BASE DE DATOS
* SELECIONADA EN EL METEDO
*/
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

/*
* METODO
* SHOWOBJ() ==> RETORNA UN OBJETO TIPO ARRAY ASOCIATIVO,
* DEL RESULTADO DEL QUERY , VAR['CAMPO']
*/
    public function show()
    {  
        
          while ($res=pg_fetch_assoc($this->consulta))
            {
               $this->result[] = $res; //REGRESA UN ARREGLO ASOCIATIVO
            }

        return $this->result;
    }


/*
* SHOWOBJ() ==> RETORNA UN OBJETO TIPO OBJETO,
* DEL RESULTADO DEL QUERY
*/
    public function showObj()
    {  
        
          while ($res=pg_fetch_object($this->consulta))
            {
               $this->result[] = $res;
            }

        return $this->result;
       
    }

/*
* SHOWOBJSON() ==> RETORNA UN OBJETO JSON
*/
    public function showObJson()
    {  
        
          while ($res=pg_fetch_object($this->consulta))
            {
               $this->result[] = $res;
            }

       return json_encode($this->result);
       
    }

//selecionar un registro unico de la base de datos



 public function findOne($var = array()){

   $this->consulta = pg_query("SELECT * FROM $var[0] WHERE $var[1] = $var[2] LIMIT 1")
         or die('Fatal Error: ' . pg_last_error());

      return $fila = pg_fetch_array($this->consulta);
        //var_dump($fila);
 }


/*
* GETID(['TABLA','CAMPO','VALOR'])
* RETORNA EL ID DE LA CONSULTA 
*/

//************************** UPDATE SQL update(sql , 'update')*********************************
// metodo para actulizar registros de la base de datos

  public  function update($sql, $conf = '')
  { 
      try {
 
         //seguro para evitar error en los metodos
          if( !is_null($conf) && $conf == 'update' ){ 
              //sql con el query a realizar
              $this->consulta = pg_query($sql);
              if($this->consulta ) return true; 
              else return false;
              
          }else{

               throw new \Exception(' Upps !!');
          }
        
      }catch (\Exception $e) {
          
          echo 'Falta Algumentos ' . $e->getMessage();
      }
    
  }


//************************** DELETE SQL remove(sql , 'delete')*********************************
//metodo para borrar registros de la base de datos

  public  function remove($sql , $conf = '' )
  {  
     try {

         //seguro para evitar error en los metodos
          if( !is_null($conf) && $conf == 'delete' ){ 

              $this->consulta = pg_query($sql);
              if($this->consulta ) return true; 
              else return false;
              
          }else{

               throw new \Exception(' Upps !!');
          }
        
      }catch (\Exception $e) {
          
          echo 'Falta Algumentos ' . $e->getMessage();
      }
   
    
  }
    

//VALIDAR DE QUERY
  static public  function Valid( $var )
  {
    //seguro para evitar error en los metodos 
    //y la inyeccion de sql malo
      return pg_escape_string($var);

  }

/*
* REAL_SQL(SQL)==> RETORNA TRUE O FALSE
* METODO QUE VERIFICA EL SQL INGRESADO
* POR SEGURIDAD DEL LA LIBRERIA
*/


}//final de clase postgres


