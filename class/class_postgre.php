<?php 

// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================
// clase  para gestionar las consultas 
// a la base de datos de postgres

require'config/con.php';




class GetbdP extends Postgres {

 //atributos de la clase

    public $result = array();
    public $consulta;
    private $status = NULL;
    
  //metodo verificador de la consulta realizada retorna true y false
  protected function verificador($consulta){

      if ($consulta > 0) {return true; }
      else{ return false; }
  }

  static public function Debug(){
      error_reporting(-1);
      ini_set('display_errors', '1');
  }

//************************** INSERT SQL *********************************  

//validor de registro repetido


  public function check($var = []){
       
       if (is_array($var)) {
       	
	       $this->consulta = pg_query("SELECT * FROM $var[0] WHERE $var[1] = '$var[2]'")
	       or die('Fatal Error: ' . pg_last_error());
	       
	        if(self::contador($this->consulta)){
	            $this->status = true;
	            return $this;//si se registro corectamente

	        }else{

	           $this->status = false;
	            return $this;//si se registro corectamente
	        }
       }else{

       	     $this->consulta = pg_query($var)
		       or die('Fatal Error: ' . pg_last_error());

		       if(self::contador($this->consulta)){
			        $this->status = false;
		            return $this;//si se registro corectamente
		      }   
		       else{
		         $this->status = false;
	             return $this;//si se registro corectamente
		      } 
       }

  }



// metodo para insertar registros de la base de datos
	public  function save($sql )
	{
	    // verificamos si status no esta vacia
    if(is_null($this->status)){
      //creando el registro normal en la bd
          $this->consulta = pg_query($sql)
                    or die('Fatal Error: ' . pg_last_error());//errores de sintaxis
         return true;//si se registro corectamente        
     }
    else{
        if($this->status ==  true){
          return false;

        }else{
           //var_dump($this->status);
           //creando el registro normal en la bd
           $this->consulta = pg_query($sql)
                    or die('Fatal Error: ' . pg_last_error());//errores de sintaxis
           return true;//si se registro corectamente   
        }
    }//llave de else
	}//final de metodo save()




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
        return $this;
      }   
       else{
        return $this; 
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
               $this->result[] = $res;
            }

        return $this->result;
    }


//selecionar un registro unico de la base de datos

 public function findOne($var = []){

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


/*

$sql = array(); 
foreach( $data as $row ) {
    $sql[] = '("'.mysql_real_escape_string($row['text']).'", '.$row['category_id'].')';
}
mysql_query('INSERT INTO table (text, category) VALUES '.implode(',', $sql));




$data = array(
   array(
      'title' => 'My title' ,
      'name' => 'My Name' ,
      'date' => 'My date'
   ),
   array(
      'title' => 'Another title' ,
      'name' => 'Another Name' ,
      'date' => 'Another date'
   )
);

$this->db->insert_batch('mytable', $data);

// Produces: INSERT INTO mytable (title, name, date) VALUES ('My title', 'My name', 'My date'), ('Another title', 'Another name', 'Another date')
*/
