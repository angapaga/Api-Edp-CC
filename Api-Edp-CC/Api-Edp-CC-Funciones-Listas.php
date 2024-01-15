<?php
/// Solo Se habilita las 2 lineas de errores si la api no responde para probrar
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
$code = 500;
$message = 'NO';

///Funcion que devuelve lista de paneles de sabores por anio y estado
function Lista_Cabecera_Paneles_Sabores_Por_Estado($p_db, $p_empresa, $p_sucursal, $p_anio, $p_estado, $p_empleado){

    try {
        $query    = $p_db->prepare("  SELECT distinct (edpkpscp.kpscp_cod_kpscp) cod_panel ,   
                                                    (edpkpscp.cccre_cod_cccre) cod_cali,   
                                                trim(edpkpscp.clote_cod_clote) lote_cali, 
                                                trim(saecccre.cccre_docu_cccre) docu_cali, 
                                                trim(saecccre.cccre_seri_cccre) serie_cali, 
                                                trim(edpkpsap.kpsap_cod_panel )   cod_analista, 
                                                ( SELECT trim (saeusua.usua_nom_corto ) 
                                                        FROM saeusua  
                                                        WHERE ( saeusua.usua_cod_empl = '$p_empleado' ) AND  
                                                                ( saeusua.usua_cod_sucu = $p_sucursal )  ) analista,
                                                CASE edpkpscp.kpscp_est_kpscp 
                                                    WHEN 'PE' THEN 'PENDIENTE'
                                                    WHEN 'PR' THEN 'PROCESADO'
                                                    WHEN 'CE' THEN 'CERRADO'
                                                    WHEN 'AN' THEN 'ANULADO'
                                                END AS estado
                                            FROM edpkpscp,     
                                                saecccre,
                                                edpkpsap
                                            WHERE ( edpkpscp.kpscp_cod_kpscp = edpkpsap.kpscp_cod_kpscp ) and  
                                                ( edpkpscp.empr_cod_empr = edpkpsap.empr_cod_empr ) and  
                                                ( edpkpscp.sucu_cod_sucu = edpkpsap.sucu_cod_sucu )  and 
                                                ( edpkpscp.cccre_cod_cccre = saecccre.cccre_cod_cccre ) and  
                                                ( edpkpscp.empr_cod_empr = saecccre.empr_cod_empr ) and  
                                                ( edpkpscp.sucu_cod_sucu = saecccre.sucu_cod_sucu ) and 
                                                ( edpkpscp.empr_cod_empr = $p_empresa) and
                                                ( edpkpscp.sucu_cod_sucu = $p_sucursal) and
                                                ( edpkpscp.kpscp_est_kpscp = '$p_estado' ) and 
                                                ( year(edpkpscp.kpscp_fes_crea) = $p_anio) and 
                                                ( trim(edpkpsap.kpsap_cod_panel) = '$p_empleado') and
                                                ( edpkpscp.kpscp_est_kpscp <> 'AN' ) and
                                                ( edpkpsap.kpsap_est_kpsap <> 'AN' )   ");
        $query->execute();

        //// Asigna los Items de la consulta a un array
        //$result =  $query->fetchAll(PDO::FETCH_ASSOC);
        while($row = $query->fetch(PDO::FETCH_NUM)){
            $result[] = array(
                   'cod_panel'   =>  $row[0],
                   'cod_cali' => $row[1], 
                   'lote_cali' => mb_convert_encoding($row[2], 'UTF-8', 'ISO-8859-15'),
                   'docu_cali' => $row[3], 
                   'serie_cali' => $row[4],
                   'cod_analista' => $row[5],
                   'analista' => mb_convert_encoding($row[6], 'UTF-8', 'ISO-8859-15'),
                   'estado' => mb_convert_encoding($row[7], 'UTF-8', 'ISO-8859-15'),
                );
        }
        
        ////Si la consulta no devuelve datos devuelve mensaje
        if (empty($result))
        {
            $code = 204;
            $message = 'No hay datos';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);

        ////Caso contrario devuelve el array con los valores
        }else{
            $code = 200;
            $message = 'SI';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);
        }
        
    } catch (PDOException $e) {
        
        $code = 204;
        $message =$e->getMessage();
        return   json_encode([
            'code' => $code,
            'message' => $message,
            'result' => $result,
    ]);
    }
}
//// Fin funcion Lista_Cabecera_Paneles_Sabores_Por_Estado

///Funcion que devuelve lista de paneles de sabores por anio e id_cabecera
function Lista_Cabecera_Paneles_Sabores_Por_IdCabecera($p_db, $p_empresa, $p_sucursal, $p_anio, $p_cabecera, $p_empleado){

    try {
        $query    = $p_db->prepare("  SELECT distinct (edpkpscp.kpscp_cod_kpscp) cod_panel ,   
                                                    (edpkpscp.cccre_cod_cccre) cod_cali,   
                                                trim(edpkpscp.clote_cod_clote) lote_cali, 
                                                trim(saecccre.cccre_docu_cccre) docu_cali, 
                                                trim(saecccre.cccre_seri_cccre) serie_cali, 
                                                trim(edpkpsap.kpsap_cod_panel )   cod_analista, 
                                                ( SELECT trim (saeusua.usua_nom_corto ) 
                                                        FROM saeusua  
                                                        WHERE ( saeusua.usua_cod_empl = '$p_empleado' ) AND  
                                                                ( saeusua.usua_cod_sucu = $p_sucursal )  ) analista,
                                                CASE edpkpscp.kpscp_est_kpscp 
                                                    WHEN 'PE' THEN 'PENDIENTE'
                                                    WHEN 'PR' THEN 'PROCESADO'
                                                    WHEN 'CE' THEN 'CERRADO'
                                                    WHEN 'AN' THEN 'ANULADO'
                                                END AS estado
                                            FROM edpkpscp,     
                                                saecccre,
                                                edpkpsap
                                            WHERE ( edpkpscp.kpscp_cod_kpscp = edpkpsap.kpscp_cod_kpscp ) and  
                                                ( edpkpscp.empr_cod_empr = edpkpsap.empr_cod_empr ) and  
                                                ( edpkpscp.sucu_cod_sucu = edpkpsap.sucu_cod_sucu )  and 
                                                ( edpkpscp.cccre_cod_cccre = saecccre.cccre_cod_cccre ) and  
                                                ( edpkpscp.empr_cod_empr = saecccre.empr_cod_empr ) and  
                                                ( edpkpscp.sucu_cod_sucu = saecccre.sucu_cod_sucu ) and 
                                                ( edpkpscp.kpscp_cod_kpscp = $p_cabecera ) and 
                                                ( edpkpscp.empr_cod_empr = $p_empresa) and
                                                ( edpkpscp.sucu_cod_sucu = $p_sucursal) and
                                                ( year(edpkpscp.kpscp_fes_crea) = $p_anio) and 
                                                ( trim(edpkpsap.kpsap_cod_panel) = '$p_empleado') and
                                                ( edpkpscp.kpscp_est_kpscp <> 'AN' ) and
                                                ( edpkpsap.kpsap_est_kpsap <> 'AN' )   ");
        $query->execute();

        //// Asigna los Items de la consulta a un array
        ///$result =  $query->fetchAll(PDO::FETCH_ASSOC);
        while($row = $query->fetch(PDO::FETCH_NUM)){
            $result[] = array(
                   'cod_panel'   =>  $row[0],
                   'cod_cali' => $row[1], 
                   'lote_cali' => mb_convert_encoding($row[2], 'UTF-8', 'ISO-8859-15'),
                   'docu_cali' => $row[3], 
                   'serie_cali' => $row[4],
                   'cod_analista' => $row[5],
                   'analista' => mb_convert_encoding($row[6], 'UTF-8', 'ISO-8859-15'),
                   'estado' => mb_convert_encoding($row[7], 'UTF-8', 'ISO-8859-15'),
                );
        }
        
        ////Si la consulta no devuelve datos devuelve mensaje
        if (empty($result))
        {
            $code = 204;
            $message = 'No hay datos';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);

        ////Caso contrario devuelve el array con los valores
        }else{
            $code = 200;
            $message = 'SI';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);
        }
        
    } catch (PDOException $e) {
        
        $code = 204;
        $message =$e->getMessage();
        return   json_encode([
            'code' => $code,
            'message' => $message,
            'result' => $result,
    ]);
    }
}
//// Fin funcion Lista_Cabecera_Paneles_Sabores_Por_IdCabecera

//// Funcion que devuelve lista de remuestreo de analisis fisico por anio y estado 
function Lista_Cabecera_Remuestreo_Fisico_Por_Estado($p_db, $p_empresa, $p_sucursal, $p_anio, $p_estado, $p_empleado){
    try {
        $query    = $p_db->prepare("  SELECT distinct (edpkecrf.kecrf_cod_kecrf) cod_panel ,   
                                                            (edpkecrf.cccre_cod_cccre) cod_cali,   
                                                        trim(saecccre.clote_cod_clote) lote_cali, 
                                                        trim(saecccre.cccre_docu_cccre) docu_cali, 
                                                        trim(saecccre.cccre_seri_cccre) serie_cali, 
                                                        trim(edpkearf.kearf_cod_panel )   cod_analista, 
                                                        ( SELECT trim (saeusua.usua_nom_corto ) 
                                                        FROM saeusua  
                                                        WHERE ( saeusua.usua_cod_empl = '$p_empleado' ) AND  
                                                                ( saeusua.usua_cod_sucu = $p_sucursal )  ) analista,
                                                        CASE edpkecrf.kecrf_est_kecrf 
                                                            WHEN 'PE' THEN 'PENDIENTE'
                                                            WHEN 'PR' THEN 'PROCESADO'
                                                            WHEN 'CE' THEN 'CERRADO'
                                                            WHEN 'AN' THEN 'ANULADO'
                                                        END AS estado,
                                                        (edpkearf.kearf_tot_muest) muestras,
                                                        (edpkearf.kearf_cod_kearf) cod_asignacion
                                                    FROM edpkecrf,     
                                                        saecccre,
                                                        edpkearf
                                                    WHERE ( edpkecrf.kecrf_cod_kecrf = edpkearf.kecrf_cod_kecrf ) and  
                                                        ( edpkecrf.empr_cod_empr = edpkearf.empr_cod_empr ) and  
                                                        ( edpkecrf.sucu_cod_sucu = edpkearf.sucu_cod_sucu )  and 
                                                        ( edpkecrf.cccre_cod_cccre = saecccre.cccre_cod_cccre ) and  
                                                        ( edpkecrf.empr_cod_empr = saecccre.empr_cod_empr ) and  
                                                        ( edpkecrf.sucu_cod_sucu = saecccre.sucu_cod_sucu ) and 
                                                        ( edpkecrf.empr_cod_empr = $p_empresa) and
                                                        ( edpkecrf.sucu_cod_sucu = $p_sucursal) and
                                                        ( edpkecrf.kecrf_est_kecrf = '$p_estado' ) and 
                                                        ( year(edpkecrf.kecrf_fes_crea) = $p_anio) and 
                                                        ( trim(edpkearf.kearf_cod_panel) = '$p_empleado') and
                                                        ( edpkecrf.kecrf_est_kecrf <> 'AN' ) and
                                                        ( edpkearf.kearf_est_kearf <> 'AN' )    ");
        $query->execute();

        //// Asigna los Items de la consulta a un array
        //$result =  $query->fetchAll(PDO::FETCH_ASSOC);
        while($row = $query->fetch(PDO::FETCH_NUM)){
            $result[] = array(
                   'cod_panel'   =>  $row[0],
                   'cod_cali' => $row[1], 
                   'lote_cali' => mb_convert_encoding($row[2], 'UTF-8', 'ISO-8859-15'),
                   'docu_cali' => $row[3], 
                   'serie_cali' => $row[4],
                   'cod_analista' => $row[5],
                   'analista' => mb_convert_encoding($row[6], 'UTF-8', 'ISO-8859-15'),
                   'estado' => mb_convert_encoding($row[7], 'UTF-8', 'ISO-8859-15'),
                   'muestras' => $row[8],
                   'cod_asignacion' => $row[9],
                );
        }
        
        ////Si la consulta no devuelve datos devuelve mensaje
        if (empty($result))
        {
            $code = 204;
            $message =  'No hay datos';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);

        ////Caso contrario devuelve el array con los valores
        }else{
            $code = 200;
            $message = 'SI';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);
        }
        
    } catch (PDOException $e) {
        
        $code = 204;
        $message = $e->getMessage();
        return   json_encode([
            'code' => $code,
            'message' => $message,
            'result' => $result,
    ]);
    }
}
/// Fin Funcion de remuestreo de analisis fisico

//// Funcion que devuelve lista de remuestreo de analisis fisico por anio e id_cabecera 
function Lista_Cabecera_Remuestreo_Fisico_Por_IdCabecera ($p_db, $p_empresa, $p_sucursal, $p_anio, $p_cabecera, $p_empleado){

    try {
        $query    = $p_db->prepare("  SELECT distinct (edpkecrf.kecrf_cod_kecrf) cod_panel ,   
                                                            (edpkecrf.cccre_cod_cccre) cod_cali,   
                                                        trim(saecccre.clote_cod_clote) lote_cali, 
                                                        trim(saecccre.cccre_docu_cccre) docu_cali, 
                                                        trim(saecccre.cccre_seri_cccre) serie_cali, 
                                                        trim(edpkearf.kearf_cod_panel )   cod_analista, 
                                                        ( SELECT trim (saeusua.usua_nom_corto ) 
                                                        FROM saeusua  
                                                        WHERE ( saeusua.usua_cod_empl = '$p_empleado' ) AND  
                                                                ( saeusua.usua_cod_sucu = $p_sucursal )  ) analista,
                                                        CASE edpkecrf.kecrf_est_kecrf 
                                                            WHEN 'PE' THEN 'PENDIENTE'
                                                            WHEN 'PR' THEN 'PROCESADO'
                                                            WHEN 'CE' THEN 'CERRADO'
                                                            WHEN 'AN' THEN 'ANULADO'
                                                        END AS estado,
                                                        (edpkearf.kearf_tot_muest) muestras,
                                                        (edpkearf.kearf_cod_kearf) cod_asignacion
                                                    FROM edpkecrf,     
                                                        saecccre,
                                                        edpkearf
                                                    WHERE ( edpkecrf.kecrf_cod_kecrf = edpkearf.kecrf_cod_kecrf ) and  
                                                        ( edpkecrf.empr_cod_empr = edpkearf.empr_cod_empr ) and  
                                                        ( edpkecrf.sucu_cod_sucu = edpkearf.sucu_cod_sucu )  and 
                                                        ( edpkecrf.cccre_cod_cccre = saecccre.cccre_cod_cccre ) and  
                                                        ( edpkecrf.empr_cod_empr = saecccre.empr_cod_empr ) and  
                                                        ( edpkecrf.sucu_cod_sucu = saecccre.sucu_cod_sucu ) and 
                                                        ( edpkecrf.empr_cod_empr = $p_empresa) and
                                                        ( edpkecrf.sucu_cod_sucu = $p_sucursal) and
                                                        ( edpkecrf.kecrf_cod_kecrf = '$p_cabecera' ) and 
                                                        ( year(edpkecrf.kecrf_fes_crea) = $p_anio) and 
                                                        ( trim(edpkearf.kearf_cod_panel) = '$p_empleado') and
                                                        ( edpkecrf.kecrf_est_kecrf <> 'AN' ) and
                                                        ( edpkearf.kearf_est_kearf <> 'AN' )    ");
        $query->execute();

        //// Asigna los Items de la consulta a un array
        ////$result =  $query->fetchAll(PDO::FETCH_ASSOC);
        while($row = $query->fetch(PDO::FETCH_NUM)){
            $result[] = array(
                   'cod_panel'   =>  $row[0],
                   'cod_cali' => $row[1], 
                   'lote_cali' => mb_convert_encoding($row[2], 'UTF-8', 'ISO-8859-15'),
                   'docu_cali' => $row[3], 
                   'serie_cali' => $row[4],
                   'cod_analista' => $row[5],
                   'analista' => mb_convert_encoding($row[6], 'UTF-8', 'ISO-8859-15'),
                   'estado' => mb_convert_encoding($row[7], 'UTF-8', 'ISO-8859-15'),
                   'muestras' => $row[8],
                   'cod_asignacion' => $row[9],
                );
        }
        
        ////Si la consulta no devuelve datos devuelve mensaje
        if (empty($result))
        {
            $code = 204;
            $message =  'No hay datos';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);

        ////Caso contrario devuelve el array con los valores
        }else{
            $code = 200;
            $message = 'SI';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);
        }
        
    } catch (PDOException $e) {
        
        $code = 204;
        $message =$e->getMessage();
        return   json_encode([
            'code' => $code,
            'message' => $message,
            'result' => $result,
    ]);
    }
}
/// Fin Funcion de remuestreo de analisis fisico

//// Funcion que devuelve lista de remuestreo de analisis fisico por anio e id_cabecera 
function Lista_Detalles_Remuestreo_Fisico_Por_IdCabecera ($p_db, $p_cabecera, $p_empresa, $p_sucursal){

    try {
        $query    = $p_db->prepare("    SELECT edpkedrf.kedrf_cod_kedrf cod_detalle,   
                                        edpkedrf.kecrf_cod_kecrf cod_cabecera,   
                                        edpkedrf.kearf_cod_kearf cod_asignacion,   
                                        edpkedrf.cdefe_cod_cdefe cod_defe, 
                                        saecdefe.cdefe_desc_cdefe defe,  
                                        edpkedrf.kedrf_can_kedrf cantidad,   
                                        edpkedrf.kedrf_mue_kedrf muestras,   
                                        edpkedrf.kedrf_por_kedrf porcentaje   
                                          
                                FROM edpkedrf,   
                                        saecdefe  
                                WHERE ( edpkedrf.empr_cod_empr = saecdefe.empr_cod_empr ) and  
                                        ( edpkedrf.sucu_cod_sucu = saecdefe.sucu_cod_sucu ) and  
                                        ( edpkedrf.cdefe_cod_cdefe = saecdefe.cdefe_cod_cdefe ) and  
                                        ( ( edpkedrf.kecrf_cod_kecrf = $p_cabecera ) AND  
                                        ( edpkedrf.empr_cod_empr = $p_empresa ) AND  
                                        ( edpkedrf.sucu_cod_sucu = $p_sucursal ) AND  
                                        ( edpkedrf.kedrf_est_kedrf = 'PR' ) )     ");
        $query->execute();

        //// Asigna los Items de la consulta a un array
        ////$result =  $query->fetchAll(PDO::FETCH_ASSOC);
        while($row = $query->fetch(PDO::FETCH_NUM)){
            $result[] = array(
                   'cod_detalle'   =>  $row[0],
                   'cod_cabecera' => $row[1], 
                   'cod_asiganacion' =>  $row[2],  
                   'cod_defe' => $row[3], 
                   'defe' => mb_convert_encoding($row[4], 'UTF-8', 'ISO-8859-15'),
                   'cantidad' => $row[5],
                   'muestras' => $row[6],
                   'porcentaje' => $row[7],
                );
        }
        
        ////Si la consulta no devuelve datos devuelve mensaje
        if (empty($result))
        {
            $code = 204;
            $message = 'No hay datos';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);

        ////Caso contrario devuelve el array con los valores
        }else{
            $code = 200;
            $message = 'SI';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);
        }
        
    } catch (PDOException $e) {
        
        $code = 204;
        $message = $e->getMessage();
        return   json_encode([
            'code' => $code,
            'message' => $message,
            'result' => $result,
    ]);
    }
}
/// Fin Funcion detalle remuestreo de analisis fisico

//// Funcion que devuelve lista de remuestreo de cabezas cargadas por anio y estado 
function Lista_Cabecera_Remuestreo_Cabezas_Por_Estado($p_db, $p_empresa, $p_sucursal, $p_anio, $p_estado, $p_empleado){

    try {
        $query    = $p_db->prepare("  SELECT distinct (edpkecrc.kecrc_cod_kecrc) cod_panel ,   
                                                            (edpkecrc.cccre_cod_cccre) cod_cali,   
                                                        trim(saecccre.clote_cod_clote) lote_cali, 
                                                        trim(saecccre.cccre_docu_cccre) docu_cali, 
                                                        trim(saecccre.cccre_seri_cccre) serie_cali, 
                                                        trim(edpkearc.kearc_cod_panel )   cod_analista, 
                                                        ( SELECT trim (saeusua.usua_nom_corto ) 
                                                        FROM saeusua  
                                                        WHERE ( saeusua.usua_cod_empl = '$p_empleado' ) AND  
                                                                ( saeusua.usua_cod_sucu = $p_sucursal )  ) analista,
                                                        CASE edpkecrc.kecrc_est_kecrc 
                                                            WHEN 'PE' THEN 'PENDIENTE'
                                                            WHEN 'PR' THEN 'PROCESADO'
                                                            WHEN 'CE' THEN 'CERRADO'
                                                            WHEN 'AN' THEN 'ANULADO'
                                                        END AS estado,
                                                        (edpkearc.kearc_cod_kearc) cod_asignacion
                                                    FROM edpkecrc,     
                                                        saecccre,
                                                        edpkearc
                                                    WHERE ( edpkecrc.kecrc_cod_kecrc = edpkearc.kecrc_cod_kecrc ) and  
                                                        ( edpkecrc.empr_cod_empr = edpkearc.empr_cod_empr ) and  
                                                        ( edpkecrc.sucu_cod_sucu = edpkearc.sucu_cod_sucu )  and 
                                                        ( edpkecrc.cccre_cod_cccre = saecccre.cccre_cod_cccre ) and  
                                                        ( edpkecrc.empr_cod_empr = saecccre.empr_cod_empr ) and  
                                                        ( edpkecrc.sucu_cod_sucu = saecccre.sucu_cod_sucu ) and 
                                                        ( edpkecrc.empr_cod_empr = $p_empresa) and
                                                        ( edpkecrc.sucu_cod_sucu = $p_sucursal) and
                                                        ( edpkecrc.kecrc_est_kecrc = '$p_estado' ) and 
                                                        ( year(edpkecrc.kecrc_fes_crea) = $p_anio) and 
                                                        ( trim(edpkearc.kearc_cod_panel) = '$p_empleado') and
                                                        ( edpkecrc.kecrc_est_kecrc <> 'AN' ) and
                                                        ( edpkearc.kearc_est_kearc <> 'AN' ) ;    ");
        $query->execute();

        //// Asigna los Items de la consulta a un array
        //$result =  $query->fetchAll(PDO::FETCH_ASSOC);
        while($row = $query->fetch(PDO::FETCH_NUM)){
            $result[] = array(
                   'cod_panel'   =>  $row[0],
                   'cod_cali' => $row[1], 
                   'lote_cali' => mb_convert_encoding($row[2], 'UTF-8', 'ISO-8859-15'),
                   'docu_cali' => $row[3], 
                   'serie_cali' => $row[4],
                   'cod_analista' => $row[5],
                   'analista' => mb_convert_encoding($row[6], 'UTF-8', 'ISO-8859-15'),
                   'estado' => mb_convert_encoding($row[7], 'UTF-8', 'ISO-8859-15'),
                   'cod_asignacion' => $row[8],
                );
        }
        
        ////Si la consulta no devuelve datos devuelve mensaje
        if (empty($result))
        {
            $code = 204;
            $message = 'No hay datos';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);

        ////Caso contrario devuelve el array con los valores
        }else{
            $code = 200;
            $message = 'SI';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);
        }
        
    } catch (PDOException $e) {
        
        $code = 204;
        $message =$e->getMessage();
        return   json_encode([
            'code' => $code,
            'message' => $message,
            'result' => $result,
    ]);
    }
}
/// Fin Funcion de remuestreo  de cabezas cargadas 

//// Funcion que devuelve lista de remuestreo de cabezas cargadas por anio e id_cabecera 
function Lista_Cabecera_Remuestreo_Cabezas_Por_IdCabecera($p_db, $p_empresa, $p_sucursal, $p_anio, $p_cabecera, $p_empleado){

    try {
        $query    = $p_db->prepare("  SELECT distinct (edpkecrc.kecrc_cod_kecrc) cod_panel ,   
                                                            (edpkecrc.cccre_cod_cccre) cod_cali,   
                                                        trim(saecccre.clote_cod_clote) lote_cali, 
                                                        trim(saecccre.cccre_docu_cccre) docu_cali, 
                                                        trim(saecccre.cccre_seri_cccre) serie_cali, 
                                                        trim(edpkearc.kearc_cod_panel )   cod_analista, 
                                                        ( SELECT trim (saeusua.usua_nom_corto ) 
                                                        FROM saeusua  
                                                        WHERE ( saeusua.usua_cod_empl = '$p_empleado' ) AND  
                                                                ( saeusua.usua_cod_sucu = $p_sucursal )  ) analista,
                                                        CASE edpkecrc.kecrc_est_kecrc 
                                                            WHEN 'PE' THEN 'PENDIENTE'
                                                            WHEN 'PR' THEN 'PROCESADO'
                                                            WHEN 'CE' THEN 'CERRADO'
                                                            WHEN 'AN' THEN 'ANULADO'
                                                        END AS estado,
                                                        (edpkearc.kearc_cod_kearc) cod_asignacion
                                                    FROM edpkecrc,     
                                                        saecccre,
                                                        edpkearc
                                                    WHERE ( edpkecrc.kecrc_cod_kecrc = edpkearc.kecrc_cod_kecrc ) and  
                                                        ( edpkecrc.empr_cod_empr = edpkearc.empr_cod_empr ) and  
                                                        ( edpkecrc.sucu_cod_sucu = edpkearc.sucu_cod_sucu )  and 
                                                        ( edpkecrc.cccre_cod_cccre = saecccre.cccre_cod_cccre ) and  
                                                        ( edpkecrc.empr_cod_empr = saecccre.empr_cod_empr ) and  
                                                        ( edpkecrc.sucu_cod_sucu = saecccre.sucu_cod_sucu ) and 
                                                        ( edpkecrc.empr_cod_empr = $p_empresa) and
                                                        ( edpkecrc.sucu_cod_sucu = $p_sucursal) and
                                                        ( edpkecrc.kecrc_cod_kecrc = $p_cabecera ) and 
                                                        ( year(edpkecrc.kecrc_fes_crea) = $p_anio) and 
                                                        ( trim(edpkearc.kearc_cod_panel) = '$p_empleado') and
                                                        ( edpkecrc.kecrc_est_kecrc <> 'AN' ) and
                                                        ( edpkearc.kearc_est_kearc <> 'AN' ) ;    ");
        $query->execute();

        //// Asigna los Items de la consulta a un array
       // $result =  $query->fetchAll(PDO::FETCH_ASSOC);
       while($row = $query->fetch(PDO::FETCH_NUM)){
        $result[] = array(
               'cod_panel'   =>  $row[0],
               'cod_cali' => $row[1], 
               'lote_cali' => mb_convert_encoding($row[2], 'UTF-8', 'ISO-8859-15'),
               'docu_cali' => $row[3], 
               'serie_cali' => $row[4],
               'cod_analista' => $row[5],
               'analista' => mb_convert_encoding($row[6], 'UTF-8', 'ISO-8859-15'),
               'estado' => mb_convert_encoding($row[7], 'UTF-8', 'ISO-8859-15'),
               'cod_asignacion' => $row[8],
            );
        } 
        ////Si la consulta no devuelve datos devuelve mensaje
        if (empty($result))
        {
            $code = 204;
            $message = 'No hay datos';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);

        ////Caso contrario devuelve el array con los valores
        }else{
            $code = 200;
            $message = 'SI';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);
        }
        
    } catch (PDOException $e) {
        
        $code = 204;
        $message = $e->getMessage();
        return   json_encode([
            'code' => $code,
            'message' => $message,
            'result' => $result,
    ]);
    }
}
/// Fin Funcion de remuestreo  de cabezas cargadas 

//// Funcion que devuelve lista de remuestreo de analisis fisico por anio e id_cabecera 
function Lista_Detalles_Cabezas_Por_IdCabecera ($p_db, $p_cabecera, $p_empresa, $p_sucursal){

    try {
        $query    = $p_db->prepare("     SELECT distinct edpkedcc.kedcc_cod_kedcc,   
                                                        edpkedcc.kecrc_cod_kecrc,   
                                                        edpkedcc.cgana_cod_cgana,   
                                                        (  SELECT saecgana.cgana_desc_cgana  
                                                            FROM saecgana  
                                                        WHERE ( saecgana.cgana_cod_cgana =  edpkedcc.cgana_cod_cgana ) AND  
                                                                ( saecgana.empr_cod_empr =  edpkedcc.empr_cod_empr ) AND  
                                                                ( saecgana.sucu_cod_sucu = edpkedcc.sucu_cod_sucu )  )  grupo,   
                                                        edpkedcc.cana_cod_cana,   
                                                        (SELECT saecana.cana_desc_cana  
                                                            FROM saecana  
                                                        WHERE ( saecana.cana_cod_cana = edpkedcc.cana_cod_cana ) AND  
                                                                ( saecana.empr_cod_empr = edpkedcc.empr_cod_empr  ) AND  
                                                                ( saecana.sucu_cod_sucu = edpkedcc.sucu_cod_sucu )  ) analisis ,   
                                                        edpkedcc.kedcc_can_kedcc,   
                                                        edpkedcc.kedcc_mue_kedcc,   
                                                        edpkedcc.kedcc_por_kedcc  
                                                FROM edpkedcc
                                                WHERE
                                                    ( edpkedcc.kecrc_cod_kecrc = $p_cabecera) and
                                                    (edpkedcc.empr_cod_empr = $p_empresa) and
                                                    (edpkedcc.sucu_cod_sucu = $p_sucursal)  and  
                                                    (edpkedcc.kedcc_est_kedcc <> 'AN') ");
        $query->execute();

        //// Asigna los Items de la consulta a un array
        ////$result =  $query->fetchAll(PDO::FETCH_ASSOC);
        while($row = $query->fetch(PDO::FETCH_NUM)){
            $result[] = array(
                   'cod_detalle'   =>  $row[0],
                   'cod_cabecera' => $row[1], 
                   'cod_grupo' =>  $row[2],  
                   'grupo' => mb_convert_encoding($row[3], 'UTF-8', 'ISO-8859-15'), 
                   'cod_analisis' => $row[4],
                   'analisis' => mb_convert_encoding($row[5], 'UTF-8', 'ISO-8859-15'),
                   'cantidad' => $row[6],
                   'muestras' => $row[7],
                   'porcentaje' => $row[8],
                );
        }
        
        ////Si la consulta no devuelve datos devuelve mensaje
        if (empty($result))
        {
            $code = 204;
            $message = 'No hay datos';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);

        ////Caso contrario devuelve el array con los valores
        }else{
            $code = 200;
            $message = 'SI';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);
        }
        
    } catch (PDOException $e) {
        
        $code = 204;
        $message = $e->getMessage();
        return   json_encode([
            'code' => $code,
            'message' => $message,
            'result' => $result,
    ]);
    }
}
/// Fin Funcion detalle remuestreo de analisis fisico

///// Lista de empleados por cedula
function Lista_Empleados_Por_Cedula($p_db, $p_empresa, $p_sucursal, $p_empleado){

    try {
        $query    = $p_db->prepare("  SELECT trim(saeempl.empl_cod_empl) cedula,
                                            trim(saeempl.empl_ape_nomb ) apellidos_nombres, 
                                            trim(saeempl.empl_nom_empl ) || ' ' ||  trim(saeempl.empl_ape_empl ) nombres_apellidos,
                                            trim(saeempl.empl_nom_empl ) nombres, 
                                            trim(saeempl.empl_ape_empl ) apellidos
                                            FROM saeempl  
                                            WHERE ( saeempl.empl_cod_empl = '$p_empleado' ) AND  
                                            ( saeempl.empl_cod_empr = $p_empresa )   ");
        $query->execute();

        //// Asigna los Items de la consulta a un array
        //$result =  $query->fetchAll(PDO::FETCH_ASSOC);
        while($row = $query->fetch(PDO::FETCH_NUM)){

            $result[] = array(
                   'cedula'   =>  $row[0],
                   'apellidos_nombres' => mb_convert_encoding($row[1], 'UTF-8', 'ISO-8859-15'),
                   'nombres_apellidos' => mb_convert_encoding($row[2], 'UTF-8', 'ISO-8859-15'),
                   'nombres' => mb_convert_encoding($row[3], 'UTF-8', 'ISO-8859-15'),
                   'apellidos' => mb_convert_encoding($row[4], 'UTF-8', 'ISO-8859-15'),
        
                );
            }


        
        ////Si la consulta no devuelve datos devuelve mensaje
        if (empty($result))
        {
            $code = 204;
            $message = 'No hay datos';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);

        ////Caso contrario devuelve el array con los valores
        }else{
            $code = 200;
            $message = 'SI';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);
        }
        
    } catch (PDOException $e) {
        
        $code = 204;
        $message = $e->getMessage();
        return   json_encode([
            'code' => $code,
            'message' => $message,
            'result' => $result,
    ]);
    }
}
/////Fin lista empleados por cedula 

///// Lista de usuarios por cedula
function Lista_Usuarios_Por_Cedula($p_db, $p_empresa, $p_sucursal, $p_empleado){

    try {
        $query    = $p_db->prepare("   SELECT saeusua.usua_cod_usua,   
                                             trim(saeusua.usua_nom_usua),
                                            trim(saeusua.usua_nom_corto) ,
                                            trim(saeusua.usua_pas_usua)
                                        FROM saeusua  
                                        WHERE ( saeusua.usua_cod_empl = '$p_empleado' ) AND  
                                                ( saeusua.usua_cod_sucu = $p_sucursal )   ");
        $query->execute();

        //// Asigna los Items de la consulta a un array
        //$result =  $query->fetchAll(PDO::FETCH_ASSOC);
        while($row = $query->fetch(PDO::FETCH_NUM)){
            $var =  desc_pass($row[3]);
            $result[] = array(
                   'codigo'   =>  $row[0],
                   'nombre' => mb_convert_encoding($row[1], 'UTF-8', 'ISO-8859-15'),
                   'nombre_corto' => mb_convert_encoding($row[2], 'UTF-8', 'ISO-8859-15'),
                   'enc' => mb_convert_encoding($row[3], 'UTF-8', 'ISO-8859-15'),
                   'desc' => $var,
                );
        }


        
        ////Si la consulta no devuelve datos devuelve mensaje
        if (empty($result))
        {
            $code = 204;
            $message =  'No hay datos';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);

        ////Caso contrario devuelve el array con los valores
        }else{
            $code = 200;
            $message = 'SI';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);
        }
        
    } catch (PDOException $e) {
        
        $code = 204;
        $message =$e->getMessage();
        return   json_encode([
            'code' => $code,
            'message' => $message,
            'result' => $result,
    ]);
    }
}
/////Fin lista usuarios por cedula 


///// Lista de defectos activos para bajar
function Lista_Defectos_Activos_Bajar($p_db, $p_empresa, $p_sucursal){

    try {
        $query    = $p_db->prepare("  SELECT saecdefe.cdefe_cod_cdefe,   
                                            saecdefe.cdefe_desc_cdefe,   
                                            saecdefe.cdefe_min_cdefe,   
                                            saecdefe.cdefe_acep_cdefe,   
                                            saecdefe.cdefe_max_cdefe,   
                                            saecdefe.cdefe_ord_cdefe  
                                            FROM saecdefe  
                                            WHERE ( saecdefe.empr_cod_empr = $p_empresa ) AND  
                                            ( saecdefe.sucu_cod_sucu = $p_sucursal ) AND  
                                            ( saecdefe.cdefe_esta_cdefe = 'A' ) AND  
                                            ( saecdefe.cdefe_est_bajar = 'A' )     ");
        $query->execute();

        //// Asigna los Items de la consulta a un array
        //$result =  $query->fetchAll(PDO::FETCH_ASSOC);
        while($row = $query->fetch(PDO::FETCH_NUM)){
            $var =  desc_pass($row[3]);
            $result[] = array(
                   'codigo'   =>  $row[0],
                   'nombre' => $row[1],
                   'min' => number_format($row[2], 2),
                   'acep' => number_format($row[3], 2),
                   'max' => number_format($row[4], 2),
                   'orden' => $row[5],
                );
        }


        
        ////Si la consulta no devuelve datos devuelve mensaje
        if (empty($result))
        {
            $code = 204;
            $message =  'No hay datos';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);

        ////Caso contrario devuelve el array con los valores
        }else{
            $code = 200;
            $message = 'SI';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);
        }
        
    } catch (PDOException $e) {
        
        $code = 204;
        $message =$e->getMessage();
        return   json_encode([
            'code' => $code,
            'message' => $message,
            'result' => $result,
    ]);
    }
}
/////Fin lista defectos activos para bajar 

///// Lista de defectos activos para bajar
function Lista_Defectos_Activos_Bajar_Por_Id($p_db, $p_empresa, $p_sucursal, $p_codigo){

    try {
        $query    = $p_db->prepare("  SELECT saecdefe.cdefe_cod_cdefe,   
                                            saecdefe.cdefe_desc_cdefe,   
                                            saecdefe.cdefe_min_cdefe,   
                                            saecdefe.cdefe_acep_cdefe,   
                                            saecdefe.cdefe_max_cdefe,   
                                            saecdefe.cdefe_ord_cdefe  
                                            FROM saecdefe  
                                            WHERE (saecdefe.cdefe_cod_cdefe = $p_codigo) AND
                                            ( saecdefe.empr_cod_empr = $p_empresa ) AND  
                                            ( saecdefe.sucu_cod_sucu = $p_sucursal ) AND  
                                            ( saecdefe.cdefe_esta_cdefe = 'A' ) AND  
                                            ( saecdefe.cdefe_est_bajar = 'A' )     ");
        $query->execute();

        //// Asigna los Items de la consulta a un array
        //$result =  $query->fetchAll(PDO::FETCH_ASSOC);
        while($row = $query->fetch(PDO::FETCH_NUM)){
            $var =  desc_pass($row[3]);
            $result[] = array(
                   'codigo'   =>  $row[0],
                   'nombre' => $row[1],
                   'min' => number_format($row[2], 2),
                   'acep' => number_format($row[3], 2),
                   'max' => number_format($row[4], 2),
                   'orden' => $row[5],
                );
        }


        
        ////Si la consulta no devuelve datos devuelve mensaje
        if (empty($result))
        {
            $code = 204;
            $message =  'No hay datos';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);

        ////Caso contrario devuelve el array con los valores
        }else{
            $code = 200;
            $message = 'SI';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);
        }
        
    } catch (PDOException $e) {
        
        $code = 204;
        $message =$e->getMessage();
        return   json_encode([
            'code' => $code,
            'message' => $message,
            'result' => $result,
    ]);
    }
}
/////Fin lista defectos activos para bajar por id

///// Lista de defectos activos para bajar
function Lista_Defectos_Activos_Bajar_No_Deta_Fisica($p_db, $p_empresa, $p_sucursal, $p_cabecera){

    try {
        $query    = $p_db->prepare("  SELECT saecdefe.cdefe_cod_cdefe,   
                                            saecdefe.cdefe_desc_cdefe,   
                                            saecdefe.cdefe_min_cdefe,   
                                            saecdefe.cdefe_acep_cdefe,   
                                            saecdefe.cdefe_max_cdefe,   
                                            saecdefe.cdefe_ord_cdefe  
                                            FROM saecdefe  
                                            WHERE saecdefe.cdefe_cod_cdefe NOT IN (  SELECT edpkedrf.cdefe_cod_cdefe  
                                                            FROM edpkedrf  
                                                            WHERE ( edpkedrf.kecrf_cod_kecrf = $p_cabecera ) AND  
                                                                ( edpkedrf.empr_cod_empr = $p_empresa ) AND  
                                                                ( edpkedrf.sucu_cod_sucu = $p_sucursal ) AND  
                                                                ( edpkedrf.kedrf_est_kedrf <> 'AN' )) AND
                                            ( saecdefe.empr_cod_empr = $p_empresa ) AND  
                                            ( saecdefe.sucu_cod_sucu = $p_sucursal ) AND  
                                            ( saecdefe.cdefe_esta_cdefe = 'A' ) AND  
                                            ( saecdefe.cdefe_est_bajar = 'A' )     ");
        $query->execute();

        //// Asigna los Items de la consulta a un array
        //$result =  $query->fetchAll(PDO::FETCH_ASSOC);
        while($row = $query->fetch(PDO::FETCH_NUM)){
            $var =  desc_pass($row[3]);
            $result[] = array(
                   'codigo'   =>  $row[0],
                   'nombre' => $row[1],
                   'min' => number_format($row[2], 2),
                   'acep' => number_format($row[3], 2),
                   'max' => number_format($row[4], 2),
                   'orden' => $row[5],
                );
        }


        
        ////Si la consulta no devuelve datos devuelve mensaje
        if (empty($result))
        {
            $code = 204;
            $message =  'No hay datos';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);

        ////Caso contrario devuelve el array con los valores
        }else{
            $code = 200;
            $message = 'SI';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);
        }
        
    } catch (PDOException $e) {
        
        $code = 204;
        $message =$e->getMessage();
        return   json_encode([
            'code' => $code,
            'message' => $message,
            'result' => $result,
    ]);
    }
}
/////Fin lista defectos activos para bajar 

///// Lista de ANALISIS CABEZAS activos para bajar
function Lista_Analisis_Activos_Bajar_No_Deta_Cabezas($p_db, $p_empresa, $p_sucursal, $p_cabecera){

    try {
        $query    = $p_db->prepare("  SELECT saecana.cana_cod_cana,   
                                                saecana.cgana_cod_cgana,   
                                                saecana.cana_desc_cana 

                                        FROM saecana  
                                        WHERE (saecana.cana_cod_cana not in (  SELECT  edpkedcc.cana_cod_cana
                                        FROM edpkedcc
                                        WHERE
                                            ( edpkedcc.kecrc_cod_kecrc = $p_cabecera) and
                                            (edpkedcc.empr_cod_empr = $p_empresa) and
                                            (edpkedcc.sucu_cod_sucu = $p_sucursal) and
                                            (edpkedcc.kedcc_est_kedcc <> 'AN') )) AND
                                            ( saecana.cgana_cod_cgana = 4 ) AND  
                                                ( saecana.empr_cod_empr = $p_empresa ) AND  
                                                ( saecana.sucu_cod_sucu = $p_sucursal ) AND  
                                                ( saecana.cana_esta_cana = 'A' ) AND  
                                                ( saecana.cana_est_baja = 'A' )   
                                        ORDER BY saecana.cana_ord_cana ASC      ");
        $query->execute();

        //// Asigna los Items de la consulta a un array
        //$result =  $query->fetchAll(PDO::FETCH_ASSOC);
        while($row = $query->fetch(PDO::FETCH_NUM)){
            $result[] = array(
                   'codigo'   =>  $row[0],
                   'grupo' => $row[1],
                   'nombre' => mb_convert_encoding($row[2], 'UTF-8', 'ISO-8859-15'),
                );
        }


        
        ////Si la consulta no devuelve datos devuelve mensaje
        if (empty($result))
        {
            $code = 204;
            $message =  'No hay datos';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);

        ////Caso contrario devuelve el array con los valores
        }else{
            $code = 200;
            $message = 'SI';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => $result,
            ]);
        }
        
    } catch (PDOException $e) {
        
        $code = 204;
        $message =$e->getMessage();
        return   json_encode([
            'code' => $code,
            'message' => $message,
            'result' => $result,
    ]);
    }
}
/////Fin Lista de ANALISIS CABEZAS activos para bajar


  
?>