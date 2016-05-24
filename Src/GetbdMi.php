<?php namespace Src;
 
/* Copyright by Francisco Campos 
 **********Año 2016***********
 ==================================
*
* CLASE PARA CONSULTAS
* CON MYSQLI A LA BASE DE DATOS
*
*DRIVER MYSQLI
*
* 
*
*/
use \Config\Connect\Mysqly;


//======= clase Conectar la clase  extiende de Mysql ==========

class GetbdMi extends Mysqly
{ 
   
   //atributos de la clase 
    public $result ; //almasena el resultado de la consulta
    public $consulta; //almacena el query a ejecutar
    private $status;

   

//metodo verificador de la consulta realizada retorna true de ser positivo y false negativo
 
  public function verificador($var){

      if ($var)
       {
        return 1; 
       }
      else{ 
        return 0; 
      }
  }

static public function Debug(){
      error_reporting(-1);
      ini_set('display_errors', '1');
  }


 //************************** INSERT SQL save() ********************************* 
// metodo para insertar registros de la base de datos


  //validor de registro repetido


  public function check($var = array()){
      
     if (is_array($var)) {
     	
       $this->consulta = mysqli_query(self::conectar(),"SELECT * FROM $var[0] WHERE $var[1] = '$var[2]'")
       or die(mysqli_error());
       
        if(self::contador($this->consulta)){
            $this->status = true;
            return $this;//si se registro corectamente

        }else{

           $this->status = false;
            return $this;//si se registro corectamente
        }
     }else{

        $this->consulta = mysqli_query(self::conectar(),$var)
            or die(mysqli_error());
       
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

        $this->consulta = mysqli_query(self::conectar(),$sql);//errores de sintaxis
         //self::verificador($this->consulta); 

        if($this->consulta){return true;}else{return false;}
     }
    else
    {  
       $sQ = "SELECT * FROM $var[0]  WHERE  $var[1]  = '$var[2]' LIMIT 1";
       $sq = explode(',',$sQ);
       $sql2 = implode($sq);
       $consulta = mysqli_query(self::conectar(),$sql2);
       if(self::contador($consulta ) > 0)
        { 
          return NULL; //si el nombre esta registrado
          exit();
        }
       else{

           $this->consulta = mysqli_query(self::conectar(),$sql);
                                         // or die(mysql_error());//errores de sintaxis
          if($this->consulta){return true;}else{return false;}//si se registro corectamente   
          
        }
     }//llave de else
}//final del metodo insert


// metodo contador de los resultados de la consulta cuando se requiere los registros

  protected function contador($consulta){
    
     $contador = mysqli_num_rows($consulta); 
     return $contador; // retorna 1 o cero 
  }



//************************** SELECT SQL  find(sql)->show() *********************************  
// metodo para seleccionar registros de la base de datos

    public function find($sql)
    {  
       $this->consulta = mysqli_query(self::conectar(),$sql)
       or die(mysqli_error());
       
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
       $this->consulta = mysqli_query(self::conectar(),"SELECT * FROM $tabla");
       //or die(mysqli_error());

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
        
          while ($res=mysqli_fetch_assoc($this->consulta))
            {
               $this->result[] = $res;
            }

        return $this->result;
        mysqli_free_result($this->consulta);
    }

/*
* SHOWOBJ() ==> RETORNA UN OBJETO TIPO OBJETO,
* DEL RESULTADO DEL QUERY
*/

    public function showObj()
    {  
        
          while ($res=mysqli_fetch_object($this->consulta))
            {
               $this->result[] = $res;
            }

        return $this->result;
        mysqli_free_result($this->consulta);
    }

/*
* SHOWOBJSON() ==> RETORNA UN OBJETO JSON
*/
    public function showObJson()
    {  
        
          while ($res=mysqli_fetch_object($this->consulta))
            {
               $this->result[] = $res;
            }

        return json_encode($this->result);
       mysqli_free_result($this->consulta);
    }

//selecionar un registro unico de la base de datos

   public function findOne($var = array()){

     $this->consulta = mysqli_query(self::conectar(),"SELECT * FROM $var[0] WHERE $var[1] = $var[2]")
           or die(mysql_error());

        return $fila = mysqli_fetch_array($this->consulta);
          //var_dump($fila);
        mysqli_free_result($this->consulta);
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
              $this->consulta = mysqli_query(self::conectar(),$sql);
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

              $this->consulta = mysqli_query(self::conectar(),$sql);
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
      return mysqli_real_escape_string(self::conectar(),$var);

  }
 
/*
* REAL_SQL(SQL)==> RETORNA TRUE O FALSE
* METODO QUE VERIFICA EL SQL INGRESADO
* POR SEGURIDAD DEL LA LIBRERIA
*/
 
}//final de la clase conectar








