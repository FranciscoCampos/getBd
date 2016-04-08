<?php 

// Copyright by Francisco Campos 
// **********Año 2015***********
// ==================================




//===============================configuracion de getBd ===============================

/*

 BASE DE DATOS
 CONFIGURACION DE LOS ARCHIVOS FILES


*/

return array(


/*
*
**** CONFIGURACION DE LAS VARIABLES
***  DE CONECION A LA BASE DE DATOS
***  NOMBRE DEL DRIVE 
***  HOSTS , USUARIO , PASSWORD , DATABASE 
*
*/

// DRIVES MYSQL

        'mysql' => array(
            
            'host' => 'localhost',
            'database' => 'crud',
            'user' => 'root',
            'password' => '123456'
           
        ),

// DRIVES POSTGRES

        'postgre' => array(
            
            'host' => 'localhost',
            'database' => 'beta',
            'user' => 'postgres',
            'password' => '123456'
        ),


// DRIVES MYSQLI   

       'mysqli' => array(
            
            'host' => 'localhost',
            'database' => 'beta',
            'user' => 'sistema',
            'password' =>'123456'
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








