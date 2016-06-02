<?php namespace Config\Files;

use Config\Base;


//===============================configuracion de File ===============================
class ConfigFile
 {
    public $datos = array();
    public $sizes = array();


    public function __construct(){

        $obj = Base::getConfig();
        $this->datos = array(

            'jpg' => $obj['exten']['jpg'],
            'png' => $obj['exten']['png'],
            'word' => $obj['exten']['word'],
            'pdf'  => $obj['exten']['pdf']

        );

        $this->sizes = array( 
            //nombre / byts / kbs
            's' => $obj['sizes']['s'] , //500kb
            'm' =>  $obj['sizes']['m'], //800 Kb
            'l' => $obj['sizes']['l'] , //1024 Kb
            'xl' => $obj['sizes']['xl'], //6144 Kb
        );
    }


//regresa la configuracion de los formatos permitidos
     public function getFormato(){
        return $this->datos;
    }

//regresa la configuracion de los tamanos permitidos

    public function getSize(){
        return $this->sizes;
    }
 }