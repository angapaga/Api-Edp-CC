<?php
//CONEXION A EDPACIF
include "Api-Edp-CC-Globales.php";
include "Api-Edp-CC-General.php";
include "Api-Edp-CC-Funciones-Generales.php";
include "Api-Edp-CC-Funciones-Listas.php";
include "Api-Edp-CC-Funciones-Transac.php";

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

////Resolver Peticion Lista_Detalles_Remuestreo_Fisico_Por_IdCabecera ($p_db, $p_cabecera, $p_empresa, $p_sucursal){
if ($postjson['peticion'] == 'detalles_remuestra_fisico_cabecera')
{
    $ll_cabecera = $postjson['cabecera'] ;
    echo Lista_Detalles_Remuestreo_Fisico_Por_IdCabecera ($db, $ll_cabecera, $gl_empresa, $gl_sucursal);
}
//// Fin Peticion Lista_Detalles_Remuestreo_Fisico_Por_IdCabecera 

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

//// Resolver peticion Lista_Detalles_Cabezas_Por_IdCabecera ($p_db, $p_cabecera, $p_empresa, $p_sucursal)
if ($postjson['peticion'] == 'detalles_remuestra_cabezas_cabecera')
{
    $cabecera = $postjson['cabecera'] ;
    echo Lista_Detalles_Cabezas_Por_IdCabecera ($db, $cabecera, $gl_empresa, $gl_sucursal);
}
/// Fin Lista_Detalles_Cabezas_Por_IdCabecera ($p_db, $p_cabecera, $p_empresa, $p_sucursal)

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

////Resolver Peticion Lista_Defectos_Activos_Bajar($p_db, $p_empresa, $p_sucursal)
if ($postjson['peticion'] == 'Defectos_Activos_Bajar')
{
    echo Lista_Defectos_Activos_Bajar($db, $gl_empresa, $gl_sucursal);
}
////Fin Lista_Defectos_Activos_Bajar

////Resolver Peticion Lista_Defectos_Activos_Bajar($p_db, $p_empresa, $p_sucursal)
if ($postjson['peticion'] == 'Defectos_Activos_Bajar_No_Deta')
{
    $ll_cabecera = $postjson['cabecera'] ;
    echo Lista_Defectos_Activos_Bajar_No_Deta_Fisica($db, $gl_empresa, $gl_sucursal, $ll_cabecera);
}
////Fin Lista_Defectos_Activos_Bajar

///Resolver Peticion para Ingresar Detalles Analisis Fisico 
// Insertar_detalles_Remuestra_fisica($p_db, $p_empresa, $p_sucursal, $p_cabecera, $p_defecto, $p_cantidad, $p_muestras, $usuario)
if ($postjson['peticion'] == 'Insertar_detalles_fisico')
{
    $cabecera = $postjson['cabecera'] ;
    $defecto = $postjson['defecto'] ;
    $cantidad = $postjson['cantidad'] ;
    $muestras = $postjson['muestras'] ;
    echo Insertar_detalles_Remuestra_fisica($db, $gl_empresa, $gl_sucursal, $cabecera, $defecto, $cantidad, $muestras, $cod_usua);
} 
///Fin Peticion para Ingresar Detalles Analisis Fisico

////Resolver Peticion dos ultimos periodos fg_select_dos_periodos($db, $empresa, $sucursal, $fecha, $hora)
if ($postjson['peticion'] == 'Dos_periodos_activos')
{
    echo fg_select_dos_periodos($db, $gl_empresa, $gl_sucursal, $gd_today, $gd_hora);
}
////Fin Peticion dos ultimos periodos 

////Resolver Peticion dos  periodos del anio fg_select_periodos_anio($db, $empresa, $sucursal, $fecha, $hora)
if ($postjson['peticion'] == 'Periodos_anio')
{
    echo fg_select_periodos_anio($db, $gl_empresa, $gl_sucursal, $gd_today, $gd_hora);
}
////Fin Peticion periodos anio

///// Resolver Petición para actualizar muestras af Actualiza_Muestras_Remuestra_fisica($p_db, $p_empresa, $p_sucursal, $p_cabecera, $p_muestras, $p_usuario)
if ($postjson['peticion'] == 'Actualiza_muestras_fisica')
{
    $cabecera = $postjson['cabecera'] ;
    $muestras = $postjson['muestras'] ;
    echo Actualiza_Muestras_Remuestra_fisica($db, $gl_empresa, $gl_sucursal, $cabecera, $muestras, $cod_usua);
}
//////Fin Peticion de actualizar muestras 


//// Resolver peticion para actualizar estado de cabeceras fisica Procesa_Remuestra_fisica($p_db, $p_empresa, $p_sucursal, $p_cabecera, $p_usuario)
if ($postjson['peticion'] == 'Procesa_muestras_fisica')
{
    $cabecera = $postjson['cabecera'] ;
    echo Procesa_Remuestra_fisica($db, $gl_empresa, $gl_sucursal, $cabecera, $cod_usua);
}
/// Fin Procesa_Remuestra_fisica($p_db, $p_empresa, $p_sucursal, $p_cabecera, $p_usuario)


?>