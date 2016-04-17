<?php 

// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================
// clases  para gestionar las consultas a la base de datos mysql

//// DRIVER MYSQL
// archivos requeridos para el funcionamiento

require'./config/start.php';



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

// INSERT INTO lista_emails(email,nombre)
// SELECT 'juan@gmail.com','Juan'
// FROM dual
// WHERE NOT EXISTS (SELECT email FROM lista_emails WHERE email='juan@gmail.com' LIMIT 1)
// INSERT IGNORE INTO lista_emails(email,nombre) VALUES ('juan@gmail.com','Juan Rodriguez')

// INSERT IGNORE saltará el registro si existe.

// REPLACE INTO lista_emails(email,nombre) VALUES ('juan@gmail.com','Juan Rodriguez')

// REPLACE actualizará el registro si existe, y si no hará un insert.



public  function save( $sql , $var = array())
{
    // verificamos si status no esta vacia
    if (is_null($var))
    {

        $this->consulta = mysql_query($sql,self::conectar());//errores de sintaxis
         //self::verificador($this->consulta); 
        if($this->consulta){return true;}else{return true;}
     }
    else
    {  
       $sQ = "SELECT * FROM $var[0]  WHERE  $var[1]  = '$var[2]' LIMIT 1";
       $sq = explode(',',$sQ);
       $sql = implode($sq);
       $consulta = mysql_query($sql ,self::conectar());

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

 //consultas simples  de datos   
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

      		$this->consulta = mysql_query($sql , self::conectar())
          or die(mysql_error());
       
         if($this->consulta){return true;}   
         
        }else{

            return false ;
        }
    
	}


//************************** DELETE SQL remove(sql , 'delete')*********************************
//metodo para borrar registros de la base de datos

	public  function remove($sql , $conf)
	{
		if( $conf == 'delete' ){ //seguro para evitar error en los metodos

        $this->consulta = mysql_query($sql , self::conectar())
          or die(mysql_error());
         if($this->consulta){return true;}

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








