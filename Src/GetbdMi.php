<?php namespace Src;
 
 
// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================
// clases  para gestionar las consultas a la base de datos mysql

// DRIVER MYSQLI

// archivos requeridos para el funcionamiento
use \Config\Connect\Mysqly;
//require '../config/start.php';



//======= clase Conectar la clase  extiende de Mysql ==========

class GetbdMi extends Mysqly
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



//guarda el registro
  public  function save( $sql , $var = array())
{
    // verificamos si status no esta vacia
    if (is_null($var))
    {

        $this->consulta = mysqli_query(self::conectar(),$sql);//errores de sintaxis
         //self::verificador($this->consulta); 
        if($this->consulta){return true;}else{return true;}
     }
    else
    {  
       $sQ = "SELECT * FROM $var[0]  WHERE  $var[1]  = '$var[2]' LIMIT 1";
       $sq = explode(',',$sQ);
       $sql = implode($sq);
       $consulta = mysqli_query(self::conectar(),$sql);

       if(mysqli_num_rows($consulta ) > 0)
        { 
          return null; //si el nombre esta registrado
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

 //consultas simples  de datos   
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

// metodo para listar los  registros de la base de datos en un array asociativo

    public function show()
    {  
        
          while ($res=mysqli_fetch_assoc($this->consulta))
            {
               $this->result[] = $res;
            }

        return $this->result;
        mysqli_free_result($this->consulta);
    }


// metodo para listar los  registros de la base de datos en un array con los objeto de los campos

/*
   
foreach ($datos as $dato ) {
  $dato->nombre;
}

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



//selecionar un registro unico de la base de datos

   public function findOne($var = array()){

     $this->consulta = mysqli_query(self::conectar(),"SELECT * FROM $var[0] WHERE $var[1] = $var[2]")
                                                             or die(mysql_error());

        return $fila = mysqli_fetch_array($this->consulta);
          //var_dump($fila);
        mysqli_free_result($this->consulta);
   }



//************************** UPDATE SQL update(sql , 'update')*********************************
// metodo para actulizar registros de la base de datos

	public  function update($sql, $conf)
	{ 
      if( $conf == 'update' ){ //seguro para evitar error en los metodos

      		$this->consulta = mysqli_query(self::conectar(),$sql);

          return $this->consulta;

      }else{

          return false ;
      }
    
	}


//************************** DELETE SQL remove(sql , 'delete')*********************************
//metodo para borrar registros de la base de datos

	public  function remove($sql , $conf)
	{
		if( $conf == 'delete' ){ //seguro para evitar error en los metodos

          $this->consulta = mysqli_query(self::conectar(),$sql);

          return $this->consulta;

      }else{

          return false ;
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
 


 
}//final de la clase conectar








