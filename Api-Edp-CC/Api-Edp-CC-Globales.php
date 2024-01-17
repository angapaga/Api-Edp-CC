<?php
include "Api-Edp-CC-Header.php";
///Mostrar errores
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

///Variables que navegaran en toda la app
$gl_empresa = 8;
$gl_sucursal = 9 ;

//Variable para recibir valores en php de las variables enviadas desde la app en .JSON
$postjson = json_decode(file_get_contents('php://input'), true);
//Empresa y sucursal 

$cod_usua = $postjson['cod_usua'];

$gl_anio = 2023;//intval(date('Y', strtotime($gd_today)));


///Hora actual del Sistema hora del server de API
$gd_hora = date('h:i');

$gs_aguaje = $postjson['periodo'] ;

$gl_muestras_sabor = 25;

?>