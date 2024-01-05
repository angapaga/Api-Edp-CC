<?php
//CABECERA API
include "Api-Edp-CC-Header.php";
//CONEXION A EDPACIF
include "Api-Edp-CC-General.php";
include "Api-Edp-CC-Funciones-Generales.php";
include "Api-Edp-CC-Globales.php";


// Mostrar periodo
if($postjson['resp'] == 'mostrar_periodo'){
    echo fg_select_dos_periodos($db, $empresa, $sucursal, $today, $hora);    
}


// Mostrar proveedores de los bines bloqueados
if($postjson['resp'] == 'mostrar_proveedores_blo'){
    echo mostrar_provee_bines_blo($db, $empresa, $sucursal);    
}

///Mostrar Guias de los bines bloqueados
if($postjson['resp'] == 'mostrar_guias_blo'){
    $cod_clpv=$postjson['cod_clpv']; 
    echo mostrar_guias_bines_blo($db, $empresa, $sucursal, $cod_clpv);    
}

///Crea el siguiente lote del proveedor
if($postjson['resp'] == 'crear_lote_prov'){
    $cod_clpv=$postjson['cod_clpv']; 
    echo mostrar_nuevo_lote($db, $empresa, $sucursal, $cod_clpv, $gs_aguaje, $ll_anio, $cod_usua);    
}

///Gabar Cabecera
if($postjson['resp'] == 'grabar_cabecera'){
    $cod_clpv=$postjson['cod_clpv']; 
    $lote=$postjson['lote']; 

    echo grabar_cabecera($db, $empresa, $sucursal, $cod_clpv, $lote, $cod_usua, $gs_aguaje, $ll_anio);    
}

//Grabar Detalles
if($postjson['resp'] == 'grabar_detalles'){
    $guia=$postjson['guia']; 
    $cabecera=$postjson['cabecera']; 

    echo grabar_detalle($db, $empresa, $sucursal, $guia, $cabecera, $cod_usua);    
}

//Mostrar cabecera Pendiente por codigo
if($postjson['resp'] == 'mostrar_cabecera'){
    $cabecera=$postjson['cabecera']; 

    echo mostrar_cabecera_pe($db, $empresa, $sucursal, $cabecera);    
}


//Mostrar Detalles Pendientes
if($postjson['resp'] == 'mostrar_detalles'){
    $cabecera=$postjson['cabecera']; 

    echo mostrar_detalles_pe($db, $empresa, $sucursal, $cabecera);    
}

////Mostrar Los documentos Pendientes
if($postjson['resp'] == 'procesar_documento'){
    $cabecera=$postjson['cabecera']; 
    $cod_clpv=$postjson['cod_clpv']; 
    echo procesar_documento($db, $empresa, $sucursal, $cabecera, $cod_usua, $cod_clpv);    
}



////Mostrar Los documentos Pendientes
if($postjson['resp'] == 'mostrar_documentos_pe'){
    echo mostrar_documentos_pe($db, $empresa, $sucursal);    
}

//////Retirar bin guia
if($postjson['resp'] == 'retirar_bin'){
    $cabecera=$postjson['cabecera']; 
    $detalle=$postjson['cod']; 
    $bin=$postjson['bin']; 
    $cod_guia=$postjson['cod_guia']; 
    echo retirar_bin_guia($db, $empresa, $sucursal, $cod_guia, $detalle, $cod_usua, $bin);    
}











 
?>