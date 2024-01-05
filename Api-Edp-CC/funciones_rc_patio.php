<?php

///////Aguaje nuevo periodo productivo seleccionar
function select_periodo1($db, $empresa, $sucursal, $fecha, $hora){
    $ll_anio = 0;
    $ls_aguaje = '';
    $lt_hora = '';

    //$ll_anio = date("Y");
    $ll_anio = intval(date('Y', strtotime($fecha)));
    $data = array();
    $query    = $db->prepare("  SELECT saecagua.cagua_char_cagua 
                                    FROM saecagua  
                                    WHERE ( saecagua.empr_cod_empr = $empresa ) AND  
                                        ( saecagua.sucu_cod_sucu = $sucursal ) AND  
                                        ( saecagua.cagua_anio_cagua = $ll_anio )  order by  saecagua.cagua_char_cagua desc");
    $query->execute();
    
    while($row = $query->fetch(PDO::FETCH_NUM)){

	$data[] = array(
           'periodo'   =>  $row[0],
           'anio' => $ll_anio,
        );
    }
    
    if($data) $result = json_encode(array('success'=>true,'result'=>$data));
    else $result = json_encode(array('success'=>false, 'msg'=>'No hay periodos Activos'));
    
    return $result;
}

///////Aguaje nuevo periodo productivo seleccionar
function select_periodo($db, $empresa, $sucursal, $fecha, $hora){
    $ll_anio = 0;
    $ls_aguaje = '';
    $lt_hora = '';

    //$ll_anio = date("Y");
    $ll_anio = intval(date('Y', strtotime($fecha)));
    $data = array();
    $query    = $db->prepare("  SELECT saecagua.cagua_char_cagua 
                                FROM saecagua  
                                WHERE ( saecagua.empr_cod_empr = $empresa) AND  
                                      ( saecagua.sucu_cod_sucu = $sucursal ) AND  
                                      (saecagua.cagua_fefe_cagua >=  today -5 )
                                order by  saecagua.cagua_char_cagua desc");
    $query->execute();
    
    while($row = $query->fetch(PDO::FETCH_NUM)){

	$data[] = array(
           'periodo'   =>  $row[0],
           'anio' => $ll_anio,
        );
    }
    
    if($data) $result = json_encode(array('success'=>true,'result'=>$data));
    else $result = json_encode(array('success'=>false, 'msg'=>'No hay periodos Activos'));
    
    return $result;
}

 

function fecha_fija($db, $empresa){
    
        $query1    = $db->prepare(" SELECT saesegp.segp_sno_ffija,   
                                    saesegp.segp_fec_ffija, saesegp.segp_fec_infi
                                    FROM saesegp  
                                    WHERE saesegp.segp_cod_empr = $empresa  --and
                                   -- saesegp.segp_sno_ffija = 'S'
                                    ");
        $query1->execute();

        while($row1 = $query1->fetch(PDO::FETCH_NUM)){

            $estado=  $row1[0];
            $fecha_fija=  $row1[1];
            $fecha_inv= $row1[2]; 
            
        }

        if ($estado == 'N'){
            $estado=  null;
            $fecha_fija=  null;
            $fecha_inv= null; 
        }
        //return array('s', '01/05/2022', '01/05/2022');
        return array($estado, $fecha_fija, $fecha_inv);
 }

////Funcion que extrae tipo sin uso
function letra_tipo($tipo){
    $tipo = trim($tipo);
    $letra = substr($tipo, 0,1 );
return $letra;
}

//Extrae la letra del lote
function letra_lote($lote){
    $lote = trim($lote);
    $letra = substr($lote, -1 );
return $letra;
}

////Funcion que crea un nuevo lote del proveedor a partir del último existente en la saeclote
function nuevo_lote_proveedor($db, $empresa, $sucursal, $char, $anio, $aguaje, $cod_clpv, $cod_usua){
    //// Obtiene los dígitos diferenciales del charclpv para obtener el max
    $query    = $db->prepare("    SELECT max(edpcrepl.crepl_num_lote) 
                                        FROM edpcrepl  
                                    WHERE ( edpcrepl.empr_cod_empr = $empresa ) AND  
                                            ( edpcrepl.sucu_cod_sucu = $sucursal ) AND  
                                            ( edpcrepl.clpv_cod_clpv = $cod_clpv ) AND  
                                            ( edpcrepl.crepl_cod_usua = $cod_usua )   ");
    $query->execute();
    //// Recorro la consulta y le sumo 1 al último lote
    while($row = $query->fetch(PDO::FETCH_NUM)){
        $num_lote = intval($row[0])+1;  
    }
    //Extraer los últimos dígitos del anio
    $anio = substr($anio,2);
    //Concatena el valor del nuevo lote
    $nuevo_lote = $anio.$aguaje.$char.$num_lote;
    
return $nuevo_lote;
}

////Funcion que inserta los num sobrantes en entero para determinar el max
function insertar_dif_lote($db, $empresa, $sucursal, $cod_clpv, $cod_usua, $aguaje, $anio){
    $db->beginTransaction();
    /// elimina datos existentes del proveedor
 
     //                               crepl_cod_usua = $cod_usua
    $query0    = $db->prepare("DELETE FROM edpcrepl  
                                    
                                    WHERE ( empr_cod_empr = $empresa and   
                                    sucu_cod_sucu = $sucursal and    
                                    clpv_cod_clpv = $cod_clpv )  
                            ");
    $query0->execute();
    //$db->commit();

    // Consulta de todos los lotes del proveedor
    $query    = $db->prepare("   SELECT distinct trim(saeclote.clote_cod_clote)
                                    FROM saeclote  
                                WHERE ( saeclote.empr_cod_empr = $empresa ) AND  
                                        ( saeclote.sucu_cod_sucu = $sucursal ) AND  
                                        ( saeclote.clpv_cod_clpv = $cod_clpv )AND
                                        ( saeclote.cagua_char_cagua = '$aguaje' ) AND  
                                        ( saeclote.clote_anio_clote = $anio )    ");
    $query->execute();
//// Recorro todos los lotes
    while($row = $query->fetch(PDO::FETCH_NUM)){
        //Obtengo cada lote
        $lote = utf8_decode($row[0]);   
        //echo 'lote '.$lote;  
        //Obtengo el Cod Char del proveedor
        $char = extraer_lote_char($db, $empresa, $sucursal, $cod_clpv);
        //echo 'char '.$char;  
        //Quitar espacios en blanco 
        $lote = trim($lote);
        $char = trim($char);
        //Obtener letra del lote
        $letra = letra_lote($lote);
        $long_char= strlen($char);
        //echo 'letra '.$letra. ' long_char'.$long_char;  
        //Extraer digitos adicionales al cod char
        if ($letra == 'C' || $letra == 'E')
        {
            $longitud = strlen($lote)-1;
            $lote = substr($lote, 0, $longitud);
            $digitos = substr($lote,$long_char , $longitud-1);
            $dif = strlen($long_char)+3 -strlen($digitos) ;
            $digitos = intval(substr($digitos, $dif));
            //$digitos = substr($digitos,$long_char );
            //echo 'SI........';
        }else{
            //2311PC-1117
            $longitud = strlen($lote);
            $lote = substr($lote, 0, $longitud);
            $digitos = substr($lote,$long_char, $longitud); ///estaba $long_char -1
            $dif = strlen($long_char)+3 -strlen($digitos) ;
            $digitos = intval(substr($digitos, $dif));
            //echo 'else........';
        } 
        //echo ' longitud '.$longitud.' digitos '.$digitos.'<br>';
        ///Convertir a entero
        $cod_clpv = intval($cod_clpv);
        $cod_usua = intval($cod_usua);

        /// Insertar todos los num de cada lote
        $query1    = $db->prepare("INSERT INTO edpcrepl  
                                        ( empr_cod_empr,   
                                        sucu_cod_sucu,   
                                        crepl_num_lote,   
                                        clpv_cod_clpv,   
                                        crepl_cod_usua,
                                        crepl_fes_crea )  
                                    VALUES ( $empresa,   
                                        $sucursal,   
                                        $digitos,   
                                        $cod_clpv,   
                                        $cod_usua,
                                        current )    ");
                        $query1->execute();
                        $inserted = $db->lastInsertId();
                
                        

    }    
$db->commit();
    
return $inserted;
}

////Extraer Cod Char del Clpv
function extraer_lote_char($db, $empresa, $sucursal, $cod_clpv){

    $query    = $db->prepare("  SELECT trim(saeclpv.clpv_cod_char )
                                FROM saeclpv  
                                WHERE ( saeclpv.clpv_cod_sucu = $sucursal ) AND  
                                    ( saeclpv.clpv_cod_empr = $empresa ) AND  
                                    ( saeclpv.clpv_cod_clpv = $cod_clpv )    ");
    $query->execute();
    //// Recorreto todos los items de la consulta y se los asigna a un array
    while($row = $query->fetch(PDO::FETCH_NUM)){
        $lote = utf8_decode($row[0]);     
    }
        return $lote;
}

///Crear lote a partir del cod char Clpv PC-0325
function nuevo_lote_proveedor_char($lote, $aguaje, $anio){
    $lote = trim($lote);
    $anio = substr($anio,2);
    $nuevo_lote = $anio.$aguaje.$lote.'1';
   
return $nuevo_lote;
}

/////////Obiente el lote y devuelve el nuevo lote
function mostrar_nuevo_lote($db, $empresa, $sucursal, $cod_clpv, $aguaje, $anio, $cod_usua)
{
    $data = array();
        $query    = $db->prepare("   SELECT max(saeclote.clote_cod_clote)
                                        FROM saeclote  
                                    WHERE ( saeclote.empr_cod_empr = $empresa ) AND  
                                            ( saeclote.sucu_cod_sucu = $sucursal ) AND  
                                            ( saeclote.clpv_cod_clpv = $cod_clpv )AND
                                            ( saeclote.cagua_char_cagua = '$aguaje' ) AND  
                                            ( saeclote.clote_anio_clote = $anio )    ");
    $query->execute();
    //// Recorreto todos los items de la consulta y se los asigna a un array
    while($row = $query->fetch(PDO::FETCH_NUM)){
        $lote = trim(utf8_decode($row[0]));     
        $lote_char = trim(extraer_lote_char($db, $empresa, $sucursal, $cod_clpv));
        insertar_dif_lote($db, $empresa, $sucursal, $cod_clpv, $cod_usua, $aguaje, $anio);

       // $num = extraer_dif_lote($lote);
    }

    if ($lote == null){
        $nuevo_lote= nuevo_lote_proveedor_char($lote_char, $aguaje, $anio);
    }else{
        $nuevo_lote=nuevo_lote_proveedor($db, $empresa, $sucursal, $lote_char, $anio, $aguaje, $cod_clpv, $cod_usua);
    }

    $data[] = array(
        'lote'   =>  $nuevo_lote,
        );

    if($data) $result = json_encode(array('success'=>true,'result'=>$data));
    else $result = json_encode(array('success'=>false, 'msg'=>'No hay datos'));
    
    return $result;
   
}

////Muestra los proveedores de los bines bloqueados
function mostrar_provee_bines_blo($db, $empresa, $sucursal)
{
    $data = array(); //edpcklib.cklib_cod_guia,
    $query    = $db->prepare("   SELECT distinct (SELECT trim(saeclpv.clpv_nom_clpv)  
                                                    FROM saeclpv  
                                                    WHERE ( saeclpv.clpv_cod_sucu = edpcklib.cklib_cod_sucu ) AND  
                                                        ( saeclpv.clpv_cod_empr = edpcklib.cklib_cod_empr ) AND  
                                                        ( saeclpv.clpv_cod_clpv = edpcklib.cklib_cod_clpv  ) ),

                                                edpcklib.cklib_cod_clpv,
                                                edpcklib.cklib_ani_cklib,
                                                edpcklib.cklib_cod_aguaje,
                                                
                                                (select saeclpv.clpv_cod_char 
                                                            from saeclpv  
                                                            where ( saeclpv.clpv_clopv_clpv = 'PV' ) and  
	                                                              (saeclpv.clpv_cod_empr = edpcklib.cklib_cod_empr ) and
		                                                          (saeclpv.clpv_cod_clpv = edpcklib.cklib_cod_clpv))
                                            FROM edpcklib  
                                            WHERE ( edpcklib.cklib_cod_empr = $empresa ) AND  
                                                ( edpcklib.cklib_cod_sucu = $sucursal ) AND  
                                                ( edpcklib.cklib_blo_cklib = 'S' ) AND  
                                                ( edpcklib.cklib_est_cklib = 'PE' ) AND
                                                ( edpcklib.cklib_est_calib = 'PE' )   order by 1   ");
    $query->execute();
    //// Recorreto todos los items de la consulta y se los asigna a un array
    while($row = $query->fetch(PDO::FETCH_NUM)){
        //$lote = mostrar_nuevo_lote($db, $empresa, $sucursal, $row[1], $row[3], $row[2]);
        $data[] = array(
            'proveedor'   =>  utf8_decode($row[0]),
            'codigo' => $row[1],
            'anio' => $row[2],
            'aguaje' => $row[3],      
            'cod_char' => $row[4],
            );
    }// 'cod_guia' => $row[4],

    if($data) $result = json_encode(array('success'=>true,'result'=>$data));
    else $result = json_encode(array('success'=>false, 'msg'=>'No ha recibido Bines Logística'));
    
    return $result;
   
}


////Mostar Guias Bines Bloqueados 
function mostrar_guias_bines_blo($db, $empresa, $sucursal, $cod_clpv)
{
    $data = array(); //edpcklib.cklib_cod_guia,
    $query    = $db->prepare("   SELECT  distinct edpcklib.cklib_cod_guia,   
                                    edpcklib.cklib_doc_guia,   
                                    edpcklib.cklib_ser_guia   
                                    
                                FROM edpcklib  
                                WHERE ( edpcklib.cklib_cod_empr = $empresa ) AND  
                                                ( edpcklib.cklib_cod_sucu = $sucursal ) AND 
                                                ( edpcklib.cklib_cod_clpv = $cod_clpv )  AND
                                                ( edpcklib.cklib_blo_cklib = 'S' ) AND  
                                                ( edpcklib.cklib_est_cklib = 'PE' ) AND
                                                ( edpcklib.cklib_est_calib = 'PE' )   ");
    $query->execute();
    //// Recorreto todos los items de la consulta y se los asigna a un array
    while($row = $query->fetch(PDO::FETCH_NUM)){
        //$lote = mostrar_nuevo_lote($db, $empresa, $sucursal, $row[1], $row[3], $row[2]);
        $data[] = array(
            'codigo' => $row[0],
            'docu' => $row[1],
            'serie' => $row[2],      
            );
    }// 'cod_guia' => $row[4],

    if($data) $result = json_encode(array('success'=>true,'result'=>$data));
    else $result = json_encode(array('success'=>false, 'msg'=>'No ha recibido Guias Logística'));
    
    return $result;
   
}

/////////////////////////////////////Validaciones///////////////////////////////////
////Compara Bienes guia y bines patio REC PATIO No dejar procesar si es Dif 0
function comparar_bin_blo_patio($db, $empresa, $sucursal)
{
    $query    = $db->prepare("    SELECT count(*) 
                                    FROM edpcrepd  
                                WHERE ( edpcrepd.crepd_cod_empr = $empresa ) AND  
                                        ( edpcrepd.crepd_cod_sucu = $sucursal ) AND  
                                        ( edpcrepd.crepd_cod_guia in (  SELECT DISTINCT edpcklib.cklib_cod_guia  
                                                                            FROM edpcklib  
                                                                        WHERE ( edpcklib.cklib_cod_empr = $empresa ) AND  
                                                                                ( edpcklib.cklib_cod_sucu = $sucursal ) AND  
                                                                                ( edpcklib.cklib_blo_cklib = 'S' ) AND  
                                                                                ( edpcklib.cklib_est_cklib <> 'AN' )   ) ) AND   
                                        ( edpcrepd.crepd_est_crepd = 'PE' )  ");
    $query->execute();
    //// Recorreto todos los items de la consulta y se los asigna a un array
    while($row = $query->fetch(PDO::FETCH_NUM)){
        $bines_patio = $row[0];
    }

    $query1    = $db->prepare("    SELECT count(*) 
                                    FROM edpcklib  
                                WHERE ( edpcklib.cklib_cod_empr = $empresa ) AND  
                                                ( edpcklib.cklib_cod_sucu = $sucursal ) AND  
                                                ( edpcklib.cklib_blo_cklib = 'S' ) AND
                                                ( edpcklib.cklib_est_cklib <> 'AN' )   ");
    $query1->execute();
    //// Recorreto todos los items de la consulta y se los asigna a un array
    while($row1 = $query1->fetch(PDO::FETCH_NUM)){
        $bines_blo = $row1[0];
    }

    $result = $bines_patio -  $bines_blo;
    
    return $result;
   
}

////Existe documento pendiente por proveedor
function valida_cabecera_pendiente_prov($db, $empresa, $sucursal, $proveedor)
{
    $query    = $db->prepare("    SELECT count(*) 
                                    FROM edpcrepc  
                                WHERE ( edpcrepc.empr_cod_empr = $empresa ) AND  
                                        ( edpcrepc.sucu_cod_sucu = $sucursal ) AND  
                                        ( edpcrepc.clpv_cod_clpv = $proveedor ) AND   
                                        ( edpcrepc.crepc_est_crepc = 'PE' )  ");
    $query->execute();
    //// Recorreto todos los items de la consulta y se los asigna a un array
    while($row = $query->fetch(PDO::FETCH_NUM)){
        $contar = $row[0];
    }
    
    return $contar;
   
}

/////Valida que existan bines pendientes recibidos por logis = 0 SALTA VALID
function valida_bines_pendientes_guia($db, $empresa, $sucursal, $guia)
{
    $query1    = $db->prepare("    SELECT count(*) 
                                    FROM edpcklib  
                                WHERE ( edpcklib.cklib_cod_empr = $empresa ) AND  
                                                ( edpcklib.cklib_cod_sucu = $sucursal ) AND  
                                                ( edpcklib.cklib_cod_guia = $guia ) AND  
                                                ( edpcklib.cklib_est_cklib = 'PE' )   ");
    $query1->execute();
    //// Recorreto todos los items de la consulta y se los asigna a un array
    while($row1 = $query1->fetch(PDO::FETCH_NUM)){
        $contar = $row1[0];
    }
    
    return $contar;
   
}

/////////////////////////////////////////Fin Validacioens/////////////////////////////////////////////////

//////CRUD///////////////////////////////////////////
////Gabrar Cabecera Documento de Patio
function grabar_cabecera($db, $empresa, $sucursal, $cod_clpv, $lote, $cod_usua, $aguaje, $anio){
    $cabecera_pe = valida_cabecera_pendiente_prov($db, $empresa, $sucursal, $cod_clpv);
     ////Valida que si existe lote ya no lo cree
     $existe_lote =validar_existe_lote($db, $empresa, $sucursal, $cod_clpv, $lote);
     ////Gabriel 26-05-2023 Salte la validacion de Doc PE
     $cabecera_pe = 0;

     //Gabriel 08-07-2023
     $proveedor_aguaje = validar_proveedor_aguaje($db, $empresa, $sucursal, $cod_clpv, $aguaje, $anio);

    if ($cabecera_pe > 0){
        $result = json_encode(array('success'=>false, 'msg'=>'No Se puede Grabar, Existe un documento pendiente para este proveedor!!!'));
    }else{
        if ($lote == null or $lote==''){
            $result = json_encode(array('success'=>false, 'msg'=>'Ingrese el Lote!!!'));
        }else{
            if ($existe_lote  > 0){
                $result = json_encode(array('success'=>false, 'msg'=>'El lote '.$lote.' ya existe en otro documento'));
            }else {
                if ($proveedor_aguaje  == 0){
                    $result = json_encode(array('success'=>false, 'msg'=>'El proveedor no pertenece al periodo '.$aguaje));
                }else {
                        $db->beginTransaction();
                        $query    = $db->prepare("INSERT INTO edpcrepc  
                                                    ( empr_cod_empr,   
                                                    sucu_cod_sucu,   
                                                    clpv_cod_clpv,   
                                                    crepc_cod_lote,   
                                                    crepc_est_crepc,   
                                                    crepc_fes_crea,   
                                                    crepc_usu_crea,   
                                                    crepc_agu_crepc,   
                                                    crepc_ani_crepc )  
                                                    VALUES ( $empresa,   
                                                    $sucursal,   
                                                    $cod_clpv,   
                                                    '$lote',   
                                                    'PE',   
                                                    current,   
                                                    $cod_usua,   
                                                    '$aguaje',   
                                                    $anio )    ");
                                        $query->execute();
                                        $inserted = $db->lastInsertId();
                                
                                        $db->commit();
                            if($query) $result = json_encode(array('success'=>true,'msg'=>'Documento de Recepcion de Patio Creado', 'codigo'=>$inserted));
                            else $result = json_encode(array('success'=>false, 'msg'=>'No se pudo Grabar'));
                        } /// if valida proveedor aguaje
                    }//If existe lote
                }//if Lote
        }///if documento pendiente

    return $result;
}

///Grabar detalle del documente
function grabar_detalle($db, $empresa, $sucursal, $guia, $cabecera, $cod_usua){
    //$existe_bin = existe_bin_guia($db, $empresa, $sucursal, $guia, $bin);
    //try {
        ////$result = json_encode(array('success'=>false, 'msg'=>'No se pudo Grabar, ya no hay bines bloqueados'.$guia));
    if ($guia == null or $guia == 'undefined' or $guia =='') {
        $result = json_encode(array('success'=>false, 'msg'=>'Seleccione una guía por favor'));
    }else{
            $bines_pe = valida_bines_pendientes_guia($db, $empresa, $sucursal, $guia);
            if ($bines_pe = 0) {
                $result = json_encode(array('success'=>false, 'msg'=>'No se pudo Grabar, ya no hay bines bloqueados'));
            }else{
                
                        $db->beginTransaction();
                        $query    = $db->prepare("INSERT INTO edpcrepd  
                                                    ( crepd_cod_empr,   
                                                    crepd_cod_sucu,   
                                                    crepc_cod_crepc,   
                                                    crepd_cod_guia,   
                                                    crepd_doc_guia,   
                                                    crepd_ser_guia,   
                                                    crepd_fes_rebin,   
                                                    crepd_uso_rebin,   
                                                    crepd_blo_crepd,   
                                                    crepd_cod_aguaje,   
                                                    crepd_cod_prog,   
                                                    crepd_sec_prog,   
                                                    crepd_est_crepd,   
                                                    crepd_sno_vacio,   
                                                    crepd_ani_crepd,   
                                                    crepd_cod_bin,   
                                                    crepd_fes_crea,   
                                                    crepd_usu_crea,   
                                                    cklib_cod_cklib )  

                                                    SELECT    
                                                        $empresa,   
                                                        $sucursal, 
                                                        $cabecera,  
                                                        edpcklib.cklib_cod_guia,   
                                                        edpcklib.cklib_doc_guia,   
                                                        edpcklib.cklib_ser_guia,   
                                                        edpcklib.cklib_fes_rebin,   
                                                        edpcklib.cklib_uso_rebin,   
                                                        edpcklib.cklib_blo_cklib,     
                                                        edpcklib.cklib_cod_aguaje,      
                                                        edpcklib.cklib_cod_prog,   
                                                        edpcklib.cklib_sec_prog,   
                                                        edpcklib.cklib_est_cklib,   
                                                        edpcklib.cklib_sno_vacio,   
                                                        edpcklib.cklib_ani_cklib,   
                                                        edpcklib.cklib_cod_bin,   
                                                        current,
                                                        $cod_usua,
                                                        edpcklib.cklib_cod_cklib
                                                        
                                                    FROM edpcklib 
                                                    WHERE ( edpcklib.cklib_cod_guia = $guia ) AND
                                                        ( edpcklib.cklib_cod_empr = $empresa ) AND  
                                                        ( edpcklib.cklib_cod_sucu = $sucursal ) AND  
                                                        ( edpcklib.cklib_blo_cklib = 'S' ) AND  
                                                        ( edpcklib.cklib_est_cklib = 'PE' ) AND
                                                        ( edpcklib.cklib_est_calib = 'PE' ) AND
                                                        ( edpcklib.cklib_cod_bin not in (SELECT edpcrepd.crepd_cod_bin 
                                                                                            FROM edpcrepd  
                                                                                        WHERE ( edpcrepd.crepd_cod_empr = $empresa ) AND  
                                                                                                ( edpcrepd.crepd_cod_sucu = $sucursal ) AND  
                                                                                                ( edpcrepd.crepd_cod_guia = $guia ) AND   
                                                                                                ( edpcrepd.crepd_est_crepd = 'PE' )) )    ");
                                        $query->execute();


                                        if($query){
                                            $que= $db->prepare(" UPDATE edpcklib
                                                                 SET edpcklib.cklib_est_calib = 'PR',
                                                                    edpcklib.cklib_fes_calib = current, 
                                                                    edpcklib.cklib_uso_calib = $cod_usua
                                                                 WHERE ( edpcklib.cklib_cod_guia = $guia ) AND
                                                                        ( edpcklib.cklib_cod_empr = $empresa ) AND  
                                                                        ( edpcklib.cklib_cod_sucu = $sucursal ) AND  
                                                                        ( edpcklib.cklib_blo_cklib = 'S' ) AND  
                                                                        ( edpcklib.cklib_est_cklib = 'PE' ) AND
                                                                        ( edpcklib.cklib_est_calib = 'PE' )
                                            ");

                                            $que->execute();
                                            
                                        }
                                
                                        $db->commit();
                                        $inserted = $db->lastInsertId();
                                    if($inserted > 0) $result = json_encode(array('success'=>true,'msg'=>'Detalles grabados correctamente'));
                                  else $result = json_encode(array('success'=>false, 'msg'=>'No hay nada que Grabar '));
                    }//if bines blo
                }///if guias
//}
// catch(Exception $e) {
//     $error = $e->getMessage();
//     $result = json_encode(array('success'=>false, 'msg'=> $error));
// }

    return $result;
    
}


///Procesar Documento de Patio
function procesar_documento($db, $empresa, $sucursal, $cabecera, $cod_usua, $cod_clpv){
    // $bines_faltantes = comparar_bin_blo_patio($db, $empresa, $sucursal, $cod_clpv);
    $sin_detalles = Validar_detalles($db, $empresa, $sucursal, $cabecera);

    if ($sin_detalles == 0)
    {
         $result = json_encode(array('success'=>false, 'msg'=>'No se puede Procesar, no hay detalles'));
    }else{
            $db->beginTransaction();
            $query    = $db->prepare(" UPDATE edpcrepc  
                                        SET crepc_est_crepc = 'PR',   
                                            crepc_fes_proc = current,   
                                            crepc_usu_proc = $cod_usua
                                        WHERE  crepc_cod_crepc = $cabecera and
                                               crepc_est_crepc <> 'AN'
                                    ");
            $query->execute();
                            //$inserted = $db->lastInsertId();

            if ($query){ 

                $query1    = $db->prepare("  UPDATE edpcrepd  
                                            SET crepd_est_crepd = 'PR',   
                                                crepd_blo_crepd = 'N',   
                                                crepd_fes_proc = current,   
                                                crepd_usu_proc = $cod_usua
                                            WHERE  crepc_cod_crepc = $cabecera and
                                                   crepd_est_crepd <> 'AN'
                                        ");
                            $query1->execute();
                            //$inserted1 = $db->lastInsertId();
                $db->commit();

            }
            if($query1) $result = json_encode(array('success'=>true,'msg'=>'Documento. '.$cabecera.' Procesado'));
            else $result = json_encode(array('success'=>false, 'msg'=>'No se pudo Procesar'));
        }//Sin detalles
    return $result;
}


////Mostar documentos pendientes
function mostrar_documentos_pe($db, $empresa, $sucursal)
{
    $data = array(); //edpcklib.cklib_cod_guia,
    $query    = $db->prepare("   SELECT edpcrepc.crepc_cod_crepc,   
                                        edpcrepc.clpv_cod_clpv,   
                                        edpcrepc.crepc_cod_lote,   
                                        edpcrepc.crepc_est_crepc,   
                                        edpcrepc.crepc_fes_crea,   
                                        edpcrepc.crepc_usu_crea,   
                                        edpcrepc.crepc_agu_crepc,   
                                        edpcrepc.crepc_ani_crepc,
                                        (SELECT trim(saeclpv.clpv_nom_clpv)
                                                FROM saeclpv  
                                            WHERE ( saeclpv.clpv_cod_sucu = $sucursal ) AND  
                                                    ( saeclpv.clpv_cod_empr = $empresa ) AND  
                                                    ( saeclpv.clpv_cod_clpv = edpcrepc.clpv_cod_clpv ) ),
                                        (   SELECT saeusua.usua_nom_usua  
                                         FROM saeusua  
                                         WHERE saeusua.usua_cod_usua = edpcrepc.crepc_usu_crea  ) 
                                    FROM edpcrepc  
                                    WHERE edpcrepc.empr_cod_empr = $empresa AND
                                          edpcrepc.sucu_cod_sucu = $sucursal AND
                                          edpcrepc.crepc_est_crepc = 'PE'   ");
    $query->execute();
    //// Recorreto todos los items de la consulta y se los asigna a un array
    while($row = $query->fetch(PDO::FETCH_NUM)){
        //$lote = mostrar_nuevo_lote($db, $empresa, $sucursal, $row[1], $row[3], $row[2]);
        $data[] = array(
            'codigo' => $row[0],
            'cod_clpv' => $row[1],
            'lote' => $row[2], 
            'estado' => $row[3],
            'fecha' => date( "d/m/Y H:i", strtotime($row[4])),
            'cod_usuario' => $row[5],
            'aguaje' => $row[6],
            'anio' => $row[7],  
            'proveedor' => utf8_decode($row[8]),    
            'usuario' => $row[9],    
            );
    }// 'cod_guia' => $row[4],

    if($data) $result = json_encode(array('success'=>true,'result'=>$data));
    else $result = json_encode(array('success'=>false, 'msg'=>'No hay Documentos Pendientes'));
    
    return $result;
   
}

////Mostar cabecera pendientes
function mostrar_cabecera_pe($db, $empresa, $sucursal, $cabecera)
{
    $data = array(); //edpcklib.cklib_cod_guia,
    $query    = $db->prepare("   SELECT edpcrepc.crepc_cod_crepc,   
                                        edpcrepc.clpv_cod_clpv,   
                                        edpcrepc.crepc_cod_lote,   
                                        edpcrepc.crepc_est_crepc,   
                                        edpcrepc.crepc_fes_crea,   
                                        edpcrepc.crepc_usu_crea,   
                                        edpcrepc.crepc_agu_crepc,   
                                        edpcrepc.crepc_ani_crepc,
                                        (SELECT trim(saeclpv.clpv_nom_clpv)  
                                                    FROM saeclpv  
                                                    WHERE ( saeclpv.clpv_cod_sucu = $sucursal ) AND  
                                                        ( saeclpv.clpv_cod_empr = $empresa ) AND  
                                                        ( saeclpv.clpv_cod_clpv = edpcrepc.clpv_cod_clpv  ) ) ,
                                        (   SELECT saeusua.usua_nom_usua  
                                         FROM saeusua  
                                         WHERE saeusua.usua_cod_usua = edpcrepc.crepc_usu_crea  )
                                    FROM edpcrepc  
                                    WHERE edpcrepc.crepc_cod_crepc = $cabecera AND
                                          edpcrepc.empr_cod_empr = $empresa AND
                                          edpcrepc.sucu_cod_sucu = $sucursal AND
                                          edpcrepc.crepc_est_crepc = 'PE'   ");
    $query->execute();
    //// Recorreto todos los items de la consulta y se los asigna a un array
    while($row = $query->fetch(PDO::FETCH_NUM)){
        //$lote = mostrar_nuevo_lote($db, $empresa, $sucursal, $row[1], $row[3], $row[2]);
        $data[] = array(
            'codigo' => $row[0],
            'cod_clpv' => $row[1],
            'lote' => $row[2], 
            'estado' => $row[3],
            'fecha' => $row[4],
            'cod_usuario' => $row[5],
            'aguaje' => $row[6],
            'anio' => $row[7],    
            'proveedor' => utf8_decode($row[8]),  
            'usuario' => utf8_decode($row[9]),       
            );
    }// 'cod_guia' => $row[4],

    if($data) $result = json_encode(array('success'=>true,'result'=>$data));
    else $result = json_encode(array('success'=>false, 'msg'=>'No hay Documentos Pendientes'));
    
    return $result;
   
}

////Mostar detalles pendientes
function mostrar_detalles_pe($db, $empresa, $sucursal, $cabecera)
{
    $data = array(); //edpcklib.cklib_cod_guia,
    $contar = 0;
    $query    = $db->prepare("    SELECT edpcrepd.crepd_cod_crepd,   
                                        edpcrepd.crepd_cod_guia,   
                                        edpcrepd.crepd_doc_guia,   
                                        edpcrepd.crepd_ser_guia,   
                                        edpcrepd.crepd_fes_rebin,   
                                        edpcrepd.crepd_uso_rebin,   
                                        edpcrepd.crepd_blo_crepd,   
                                        edpcrepd.crepd_cod_aguaje,   
                                        edpcrepd.crepd_cod_prog,   
                                        edpcrepd.crepd_sec_prog,   
                                        edpcrepd.crepd_est_crepd,   
                                        edpcrepd.crepd_sno_vacio,   
                                        edpcrepd.crepd_ani_crepd,   
                                        edpcrepd.crepd_cod_bin,   
                                        edpcrepd.crepd_fes_crea, 
                                        (   SELECT saeusua.usua_nom_usua  
                                         FROM saeusua  
                                         WHERE saeusua.usua_cod_usua = edpcrepd.crepd_usu_crea  ) ,   
                                        edpcrepd.cklib_cod_cklib,   
                                        edpcrepd.crepd_fes_proc,   
                                        edpcrepd.crepd_usu_proc, 
                                        edpcrepd.crepc_cod_crepc  
                                    FROM edpcrepd
                                    WHERE edpcrepd.crepc_cod_crepc = $cabecera AND
                                            edpcrepd.crepd_cod_empr = $empresa AND
                                            edpcrepd.crepd_cod_sucu = $sucursal AND
                                            edpcrepd.crepd_est_crepd = 'PE'   
                                            order by 3, 14
                            ");
    $query->execute();
    //// Recorreto todos los items de la consulta y se los asigna a un array
    while($row = $query->fetch(PDO::FETCH_NUM)){
        //$lote = mostrar_nuevo_lote($db, $empresa, $sucursal, $row[1], $row[3], $row[2]);
        $contar = $contar + 1 ;
        if (trim($row[11]) == '1') { $lleno = 'Lleno';} 
        else { $lleno = 'Vacío' ;}
        $data[] = array(
            'codigo' => $row[0],
            'cod_guia' => $row[1],
            'docu' => $lleno.' ---- '.$row[2], 
            'serie' => $row[3],
            'fecha_re' => $row[4],
            'usuario_re' => $row[5],
            'bloqueado' => $row[6],
            'aguaje' => $row[7],     
            'cod_prog' => $row[8],
            'sec_prog' => $row[9],
            'estado' => $row[10],
            'vacio' => $lleno,
            'anio' => $row[12],     
            'bin' => $contar.' ---- '.$row[13],     
            'fecha' => date( "d/m/Y H:i", strtotime($row[14])  ),
            'usuario' => $row[15],
            'cod_edpklib' => $row[16],
            'fecha_proc' => $row[17],   
            'usuario_proc' => $row[18], 
            'contar' => $contar, 
            'bines' => $row[13],
            'docum' => $row[2],
            'son' => $lleno,
            'cabecera' => $row[19],
            );
    }

    if($data) $result = json_encode(array('success'=>true,'result'=>$data));
    else $result = json_encode(array('success'=>false, 'msg'=>'No hay Documentos Pendientes'));
    
    return $result;
   
}



////Validar que existan detalles para procesar
function Validar_detalles($db, $empresa, $sucursal, $cabecera)
{
    $data = array(); //edpcklib.cklib_cod_guia,
    $contar = 0;
    $query    = $db->prepare("  SELECT count(*)  
                                FROM edpcrepd  
                                WHERE ( edpcrepd.crepd_cod_empr = $empresa ) AND  
                                    ( edpcrepd.crepd_cod_sucu = $sucursal ) AND  
                                    ( edpcrepd.crepc_cod_crepc = $cabecera )  
                            ");
    $query->execute();
    //// Recorreto todos los items de la consulta y se los asigna a un array
    while($row = $query->fetch(PDO::FETCH_NUM)){
        $contar = $row[0] ;
    }

    return $contar;
   
}


////Validar que lote ya exista 
function validar_existe_lote($db, $empresa, $sucursal, $cod_clpv, $lote)
{
    $data = array(); 
    $contar = 0;
    $query    = $db->prepare("  SELECT count(*)  
                                FROM edpcrepc  
                                WHERE ( edpcrepc.empr_cod_empr = $empresa ) AND  
                                            ( edpcrepc.sucu_cod_sucu = $sucursal ) AND  
                                            ( edpcrepc.clpv_cod_clpv = $cod_clpv ) AND  
                                            ( edpcrepc.crepc_cod_lote = '$lote' ) AND  
                                            ( edpcrepc.crepc_est_crepc <> 'AN' ) 
                            ");
    $query->execute();
    //// Recorreto todos los items de la consulta y se los asigna a un array
    while($row = $query->fetch(PDO::FETCH_NUM)){
        $contar = $row[0] ;
    }

    return $contar;
   
}



 ///Retirar bin de Documento
 function retirar_bin_guia($db, $empresa, $sucursal, $guia, $cabecera, $cod_usua, $bin){
   
                
    $db->beginTransaction();

    $bin = trim($bin);

    // (edpcrepd.crepd_cod_guia = $guia) AND
    //                             ( edpcrepd.crepd_cod_bin = '$bin') AND
    //                             ( edpcrepd.crepd_est_crepd = 'PE' ) 

    $que= $db->prepare(" UPDATE edpcrepd
                            SET edpcrepd.crepd_est_crepd = 'AN',
                            edpcrepd.crepd_fes_anula= current, 
                            edpcrepd.crepd_usu_anula = $cod_usua,
                            edpcrepd.crepd_obs_anula = 'Bin no Pertenece al Lote'
                            WHERE ( edpcrepd.crepd_cod_crepd = $cabecera ) AND  
                                ( edpcrepd.crepd_cod_empr = $empresa ) AND  
                                ( edpcrepd.crepd_cod_sucu = $sucursal )  
                                   ");

    $que->execute();

    if ($que){
        $quer= $db->prepare("   UPDATE edpcklib
                                SET edpcklib.cklib_est_calib = 'PE',
                                edpcklib.cklib_fes_calib = current, 
                                edpcklib.cklib_uso_calib = $cod_usua
                                WHERE ( edpcklib.cklib_cod_guia = $guia ) AND
                                    ( edpcklib.cklib_cod_empr = $empresa ) AND  
                                    ( edpcklib.cklib_cod_sucu = $sucursal ) AND  
                                    ( edpcklib.cklib_blo_cklib = 'S' ) AND  
                                    ( edpcklib.cklib_est_cklib = 'PE' ) AND
                                    ( edpcklib.cklib_est_calib = 'PR' )  ");

        $quer->execute();
    } 
                             
    $db->commit();
    $inserted = $db->lastInsertId();
    if($quer) $result = json_encode(array('success'=>true,'msg'=>'Bin retirado de este documento'));
    else $result = json_encode(array('success'=>false, 'msg'=>'No hay nada que Grabar '));

return $result;

}

////Validar el proveedor pertenezca al aguaje
function validar_proveedor_aguaje($db, $empresa, $sucursal, $cod_clpv, $aguaje, $anio)
{
    $data = array(); 
    $contar = 0;
    $query    = $db->prepare("  SELECT count(*)
                                FROM edpcklib  
                                WHERE ( edpcklib.cklib_cod_empr = $empresa ) AND  
                                        ( edpcklib.cklib_cod_sucu = $sucursal ) AND  
                                        ( edpcklib.cklib_blo_cklib = 'S' ) AND  
                                        ( edpcklib.cklib_cod_clpv = $cod_clpv ) AND	
                                        ( edpcklib.cklib_cod_aguaje = '$aguaje' ) AND  
                                        ( edpcklib.cklib_ani_cklib  = $anio )	
                            ");
    $query->execute();
    //// Recorreto todos los items de la consulta y se los asigna a un array
    while($row = $query->fetch(PDO::FETCH_NUM)){
        $contar = $row[0] ;
    }

    return $contar;
   
}

 

?>