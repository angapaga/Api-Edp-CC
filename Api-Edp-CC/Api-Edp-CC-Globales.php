<?php
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

////Funcion de fecha Fija
//$gs_estado_fecha = fg_fecha_fija($db, $gl_empresa)[0];
// if ($gs_estado_fecha == null){
    $gd_today = date('m/d/Y');
// }else{
//         $gd_today = date_create( fecha_fija($db, $gl_empresa)[1]);
//         $gd_today = date_format($gd_today, 'm/d/Y');
        
// }


$gl_anio = intval(date('Y', strtotime($gd_today)));


///Hora actual del Sistema hora del server de API
$gd_hora = date('h:i');

$gs_aguaje = $postjson['periodo'] ;

?>