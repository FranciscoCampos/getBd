<?php namespace Src;

/* 
* Copyright by Francisco Campos 
* **********Año 2016***********
* ==================================
*
* CLASE PARA CONSULTAS
* CON MYSQL A LA BASE DE DATOS
*
*DRIVER MYSQL
*
* 
*
*/

use \Config\Connect\Mysql;


//======= clase Conectar la clase  extiende de Mysql ==========

class GetbdM extends Mysql
{ 
   
   //atributos de la clase 
    public $result = array(); //almasena el resultado de la consulta
    public $consulta; //almacena el query a ejecutar
    private $status = NULL;



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

static public function Debug(){
      error_reporting(-1);
      ini_set('display_errors', '1');
  }


 //************************** INSERT SQL save() ********************************* 
// metodo para insertar registros de la base de datos


  //validor de registro repetido


  public function check($var = []){
      
     if (is_array($var)) {
     	
       $this->consulta = mysql_query("SELECT * FROM $var[0] WHERE $var[1] = '$var[2]'")
       or die(mysql_error());
       
        if(self::contador($this->consulta)){
            $this->status = true;
            return $this;//si se registro corectamente

        }else{

           $this->status = false;
            return $this;//si se registro corectamente
        }
     }else{

        $this->consulta = mysql_query($var,self::conectar())
            or die(mysql_error());
       
       if(self::contador($this->consulta)){
       	    $this->status = true;
            return $this;//si se registro corectamente
        }   
       else{
       	    $this->status = false;
            return $this;//si se registro corectamente
       } 

     }

  }//final metodo


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

        $this->consulta = mysql_query($sql,self::conectar());//errores de sintaxis
         //self::verificador($this->consulta); 
        if($this->consulta){return true;}else{return false;}
     }
    else
    {  
       $sQ = "SELECT * FROM $var[0]  WHERE  $var[1]  = '$var[2]' LIMIT 1";
       $sq = explode(',',$sQ);
       $sql2 = implode($sq);
       $consulta = mysql_query($sql2 ,self::conectar());

       if(mysql_num_rows($consulta ) > 0)
        { 
          return null; //si el nombre esta registrado
        }
       else{

           $this->consulta = mysql_query($sql,self::conectar());
                                         // or die(mysql_error());//errores de sintaxis
          if($this->consulta){return true;}else{return false;}//si se registro corectamente   
          
        }
     }//llave de else
}//final del metodo insert



// metodo contador de los resultados de la consulta cuando se requiere los registros

  protected function contador($consulta){
    
     $contador = mysql_num_rows($consulta); 
     return $contador; // retorna 1 o cero 
  }



//************************** SELECT SQL  find(sql)->show() *********************************  
// metodo para seleccionar registros de la base de datos

    public function find($sql)
    {  
       $this->consulta = mysql_query($sql,self::conectar())
       or die(mysql_error());
       
       if(self::contador($this->consulta)){return $this;}   
       else{return $this; } 
    }


/*
* FINDALL('TABLA')
* RETORNA TODO LOS REGISTRO DE LA BASE DE DATOS
* SELECIONADA EN EL METEDO
*/

  public function findAll($tabla)
    {  
       $this->consulta = mysql_query("SELECT * FROM $tabla")
       or die(mysql_error());

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
        
          while ($res=mysql_fetch_assoc($this->consulta))
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
        
          while ($res=mysql_fetch_assoc($this->consulta))
            {
               $this->result[] = $res;
            }

        return json_encode($this->result);
       
    }



//selecionar un registro unico de la base de datos

   public function findOne($var = []){

     $this->consulta = mysql_query("SELECT * FROM $var[0] WHERE $var[1] = $var[2]")
                                                             or die(mysql_error());

        return $fila = mysql_fetch_array($this->consulta);
          //var_dump($fila);
   }

/*
* GETID(['TABLA','CAMPO','VALOR'])
* RETORNA EL ID DE LA CONSULTA 
*/



//************************** UPDATE SQL update(sql , 'update')*********************************
// metodo para actulizar registros de la base de datos

  public  function update($sql , $conf = '')
  { 
      try {
 
         //seguro para evitar error en los metodos
          if( !is_null($conf) && $conf == 'update' ){ 
              //sql con el query a realizar
              $this->consulta = mysql_query(self::conectar(),$sql);
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

              $this->consulta = mysql_query(self::conectar(),$sql);
              if($this->consulta ) return true; 
              else return false;
              
          }else{

               throw new \Exception(' Upps !!');
          }
        
      }catch (\Exception $e) {
          
          echo 'Falta Algumentos ' . $e->getMessage();
      }
   
    
  }
    
    
//************************** PROTEC SQL *********************************
//metodo para EVITAR  la inyec de sql registros de la base de datos

  static public  function Valid( $var )
  {
    //seguro para evitar error en los metodos 
    //y la inyeccion de sql malo
      return mysql_real_escape_string($var);

  }

/*
* REAL_SQL(SQL)==> RETORNA TRUE O FALSE
* METODO QUE VERIFICA EL SQL INGRESADO
* POR SEGURIDAD DEL LA LIBRERIA
*/


}//final de la clase conectar








