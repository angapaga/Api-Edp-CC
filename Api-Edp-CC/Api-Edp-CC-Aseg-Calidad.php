<?php
//CONEXION A EDPACIF
include "Api-Edp-CC-Globales.php";
include "Api-Edp-CC-General.php";
include "Api-Edp-CC-Funciones-Generales.php";
include "Api-Edp-CC-Funciones-Listas.php";

///Todas las consultas reciben por defecto 
//"peticion":"",
//"cod_usua" : "",
//"periodo": "", 

//  ini_set('display_errors', 1);
//  error_reporting(E_ALL);

/////// Resolver petición Lista_Cabecera_Paneles_Sabores_Por_Estado($p_db, $p_empresa, $p_sucursal, $p_anio, $p_estado, $p_empleado)
if ($postjson['peticion'] == 'cabecera_panel_estado')
{
    $ls_estado = $postjson['estado'] ;
    $ls_empleado = $postjson['empleado'] ;
    echo Lista_Cabecera_Paneles_Sabores_Por_Estado($db, $gl_empresa, $gl_sucursal, $gl_anio, $ls_estado, $ls_empleado);
}
/////// Fin petición Lista_Cabecera_Paneles_Sabores_Por_Estado

/////// Resolver petición Lista_Cabecera_Paneles_Sabores_Por_IdCabecera($p_db, $p_empresa, $p_sucursal, $p_anio, $p_cabecera, $p_empleado
if ($postjson['peticion'] == 'cabecera_panel_cabecera')
{
    $ll_cabecera = $postjson['cabecera'] ;
    $ls_empleado = $postjson['empleado'] ;
    echo Lista_Cabecera_Paneles_Sabores_Por_IdCabecera($db, $gl_empresa, $gl_sucursal, $gl_anio, $ll_cabecera, $ls_empleado);
}
/////// Fin petición Lista_Cabecera_Paneles_Sabores_Por_IdCabecera

/////// Resolver petición Lista_Cabecera_Remuestreo_Fisico_Por_Estado($p_db, $p_empresa, $p_sucursal, $p_anio, $p_estado, $p_empleado)
if ($postjson['peticion'] == 'cabecera_remuestra_fisico_estado')
{
    $ls_estado = $postjson['estado'] ;
    $ls_empleado = $postjson['empleado'] ;
    echo Lista_Cabecera_Remuestreo_Fisico_Por_Estado($db, $gl_empresa, $gl_sucursal, $gl_anio, $ls_estado, $ls_empleado);
}
/////// Fin petición Lista_Cabecera_Remuestreo_Fisico_Por_Estado

/////// Resolver petición Lista_Cabecera_Remuestreo_Fisico_Por_IdCabecera($p_db, $p_empresa, $p_sucursal, $p_anio, $p_cabecera, $p_empleado)
if ($postjson['peticion'] == 'cabecera_remuestra_fisico_cabecera')
{
    $ll_cabecera = $postjson['cabecera'] ;
    $ls_empleado = $postjson['empleado'] ;
    echo Lista_Cabecera_Remuestreo_Fisico_Por_IdCabecera($db, $gl_empresa, $gl_sucursal, $gl_anio, $ll_cabecera, $ls_empleado);
}
/////// Fin petición Lista_Cabecera_Remuestreo_Fisico_Por_IdCabecera

/////// Resolver petición Lista_Cabecera_Remuestreo_Cabezas_Por_Estado($p_db, $p_empresa, $p_sucursal, $p_anio, $p_estado, $p_empleado)
if ($postjson['peticion'] == 'cabecera_remuestra_cabezas_estado')
{
    $ls_estado = $postjson['estado'] ;
    $ls_empleado = $postjson['empleado'] ;
    echo Lista_Cabecera_Remuestreo_Cabezas_Por_Estado($db, $gl_empresa, $gl_sucursal, $gl_anio, $ls_estado, $ls_empleado);
}
/////// Fin petición Lista_Cabecera_Remuestreo_Cabezas_Por_Estado

/////// Resolver petición Lista_Cabecera_Remuestreo_Cabezas_Por_IdCabecera($p_db, $p_empresa, $p_sucursal, $p_anio, $p_cabecera, $p_empleado)
if ($postjson['peticion'] == 'cabecera_remuestra_cabezas_cabecera')
{
    $ll_cabecera = $postjson['cabecera'] ;
    $ls_empleado = $postjson['empleado'] ;
    echo Lista_Cabecera_Remuestreo_Cabezas_Por_IdCabecera($db, $gl_empresa, $gl_sucursal, $gl_anio, $ll_cabecera, $ls_empleado);
}
/////// Fin petición Lista_Cabecera_Remuestreo_Cabezas_Por_IdCabecera

/// Resolver peticion Lista_empleados_Por_Cedula($p_db, $p_empresa, $p_sucursal, $p_empleado)
if ($postjson['peticion'] == 'empleados_cedula')
{
    $ls_empleado = $postjson['empleado'] ;
    echo Lista_Empleados_Por_Cedula($db, $gl_empresa, $gl_sucursal, $ls_empleado);
}
////Fin Lista_empleados_Por_Cedula

/// Resolver peticion Lista_Usuarios_Por_Cedula($p_db, $p_empresa, $p_sucursal, $p_empleado)
if ($postjson['peticion'] == 'usuarios_cedula')
{
    $ls_empleado = $postjson['empleado'] ;
    echo Lista_Usuarios_Por_Cedula($db, $gl_empresa, $gl_sucursal, $ls_empleado);
}
////Fin Lista_Usuarios_Por_Cedula
?>