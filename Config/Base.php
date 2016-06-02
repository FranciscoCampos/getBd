<?php namespace Config;

/* Copyright by Francisco Campos 
 **********Año 2015***********
 ==================================
*
* CONFIGURACION DE LA CONEXION DE GETBD
* CONFIGURACION DE LOS FORMATOS PERMITIDOS
* PARA LOS FILES
*
*DRIVER POSTGRES
*DRIVER MYSQL
*DRIVER ,YSQLI
*FILES
*/

class Base{

    public static function getConfig()
    {

        return array(


        /*
        *
        ***  CONFIGURACION DE LAS VARIABLES
        ***  DE CONECION A LA BASE DE DATOS
        ***  NOMBRE DEL DRIVE 
        ***  HOSTS , USUARIO , PASSWORD , DATABASE 
        *
        */

        // DRIVES MYSQL

                'mysql' => array(
                    
                    'host' => 'name_host',
                    'database' => 'name_data_base',
                    'user' => 'name_root',
                    'password' => 'password'
                   
                ),

        // DRIVES POSTGRES


                'postgre' => array(
                    
                    'host' => 'name_host',
                    'database' => 'name_data_base',
                    'user' => 'name_root',
                    'password' => 'password'
                ),



        // DRIVES MYSQLI   

               'mysqli' => array(
                    
                    'host' => 'name_host',
                    'database' => 'name_data_base',
                    'user' => 'name_root',
                    'password' =>'password'
                ),


        /* CONFIGURACION DE LOS FILES O ARCHIVOS DE GETBD*/


        // EXTENCION DEL FILE PERMITIDO

                'exten' => array(

                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'word' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'pdf'  => 'application/pdf'

                ),

        // TAMAÑO  DEL FILE PERMITIDO

                'sizes' => array( 
                   
                    's' => 4096000 , //500kb
                    'm' =>  819200 , //800 Kb
                    'l' => 1048576 , //1024 Kb
                    'xl' => 6291456, //6144 Kb

                )

               

        );
    }//final de geConfig
}//final de Base


