<?php 

// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================
// clases  para gestionar las consultas a la base de datos mysql


// archivos requeridos para el funcionamiento

require_once 'config/config.php';



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

       $this->consulta = mysql_query("SELECT * FROM $var[0] WHERE $var[1] = '$var[2]'")
       or die(mysql_error());
       
        if(self::contador($this->consulta) == true){
            $this->status = true;
            return $this;//si se registro corectamente

        }else{

           $this->status = false;
            return $this;//si se registro corectamente
        }

  }

//guarda el registro
  public  function save( $sql )
	{
    // verificamos si status no esta vacia
    if(is_null($this->status)){
      //creando el registro normal en la bd
        $this->consulta = mysql_query($sql)
                    or die(mysql_error());//errores de sintaxis
         return true;//si se registro corectamente        
     }
    else{
        if($this->status ==  true){
          return false;

        }else{
           //var_dump($this->status);
           //creando el registro normal en la bd
           $this->consulta = mysql_query($sql)
                                          or die(mysql_error());//errores de sintaxis
           return true;//si se registro corectamente   
        }
     }//llave de else
	}//final del metodo insert


  // metodo contador de los resultados de la consulta cuando se requiere los registros

  protected function contador($consulta){
    
     $contador = mysql_num_rows($consulta); 
     return $contador; // retorna 1 o cero 
  }


//************************** SELECT SQL  find(sql)->show()*********************************  
// metodo para seleccionar registros de la base de datos

    public function find($sql)
    {  
       $this->consulta = mysql_query($sql,self::conectar())
       or die(mysql_error());
       
       if(self::contador($this->consulta)){return $this;}   
       else{return $this; } 
    }


// metodo para listar los  registros de la base de datos en un array asociativo

    public function show()
    {  
        
          while ($res=mysql_fetch_assoc($this->consulta))
            {
               $this->result[] = $res;
            }

        return $this->result;
    }

//selecionar un registro unico de la base de datos

   public function findOne($var = []){

     $this->consulta = mysql_query("SELECT * FROM $var[0] WHERE $var[1] = $var[2]")
                                                             or die(mysql_error());

        return $fila = mysql_fetch_array($this->consulta);
          //var_dump($fila);
   }



//************************** UPDATE SQL update(sql , 'update')*********************************
// metodo para actulizar registros de la base de datos

	public  function update($sql, $conf)
	{ 
      if( $conf == 'update' ){ //seguro para evitar error en los metodos

      		$this->consulta = mysql_query($sql,self::conectar());

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

          $this->consulta = mysql_query($sql,self::conectar());

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
      return mysql_real_escape_string($var);

  }

}//final de la clase conectar








