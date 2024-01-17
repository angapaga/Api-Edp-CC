<?php
include "Api-Edp-CC-Header.php";
// INFORMIX SQL permite la conexión usando sql driver PDO
 try {
    ///Zona horaria local
    date_default_timezone_set('America/Guayaquil');
    ///Conexión
    $db = new PDO("informix:host=192.168.0.2;service=1526;database=edpacif;server=ol_server;protocol=onsoctcp;EnableScrollableCursors=1;CLIENT_LOCALE=es_ES.819", "informix", "informix"); //
     $conexion = 1;
    }
    
     catch (Exception $e) { 

        $conexion = 0;

    }
    
?>