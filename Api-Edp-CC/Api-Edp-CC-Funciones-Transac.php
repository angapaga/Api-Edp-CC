<?php
/// Solo Se habilita las 2 lineas de errores si la api no responde para probrar
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
$code = 500;
$message = 'NO';

///Funcion que inserta valores de detalles de evaluacion fisica
function Insertar_detalles_Remuestra_fisica($p_db, $p_empresa, $p_sucursal, $p_cabecera, $p_defecto, $p_cantidad, $p_muestras, $p_usuario){
    ////Inicio suma de total muestras ingresadas
    $suma    = $p_db->prepare("  SELECT sum(edpkedrf.kedrf_can_kedrf )
                                    FROM edpkedrf  
                                WHERE ( edpkedrf.kecrf_cod_kecrf = $p_cabecera ) AND  
                                        ( edpkedrf.empr_cod_empr = $p_empresa ) AND  
                                        ( edpkedrf.sucu_cod_sucu = $p_sucursal ) AND  
                                        ( edpkedrf.kedrf_est_kedrf <> 'AN' )      ");
        $suma->execute();

        //// Asigna los Items de la consulta a un array;
        while($row = $suma->fetch(PDO::FETCH_NUM)){
            $total = $row[0];
        }

        $total = $total + $p_cantidad;
    ////////Fin suma de muestras

    if ($p_cantidad == null){ $p_cantidad =0;}

    if ($p_cabecera == null){
        $code = 204;
            $message = 'Ingrese Cabecera';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => 'Error',
            ]);

    }else{
        if ($p_defecto == null){
            $code = 204;
                $message = 'Ingrese Defecto';
        
                return  json_encode([
                        'code' => $code,
                        'message' => $message,
                        'result' => 'Error',
                ]);
    
        }else{
            if ( $p_cantidad < 0){
                $code = 204;
                    $message = 'Ingrese Cantidad'.$p_cantidad;
            
                    return  json_encode([
                            'code' => $code,
                            'message' => $message,
                            'result' => 'Error',
                    ]);
        
            }else{
                if ($p_muestras == null or $p_muestras == 0){
                    $code = 204;
                        $message = 'Ingrese Muestras Correctas';
                
                        return  json_encode([
                                'code' => $code,
                                'message' => $message,
                                'result' => 'Error',
                        ]);
            
                }else{
                        if ($p_usuario == null){
                        $code = 204;
                            $message = 'Ingrese Usuario';
                    
                            return  json_encode([
                                    'code' => $code,
                                    'message' => $message,
                                    'result' => 'Error',
                            ]);
                
                        }else{
                            if ($total > $p_muestras){
                                $code = 204;
                                    $message = 'La suma Total no debe ser mayor a la muestra';
                            
                                    return  json_encode([
                                            'code' => $code,
                                            'message' => $message,
                                            'result' => 'Error',
                                    ]);
                        
                                }else{
                            //////Ingreso de datos
                            try {
                                $query    = $p_db->prepare("    INSERT INTO edpkedrf  
                                                                    (  empr_cod_empr, sucu_cod_sucu, kecrf_cod_kecrf,  
                                                                    kearf_cod_kearf, cdefe_cod_cdefe, kedrf_can_kedrf,   
                                                                    kedrf_mue_kedrf,  kedrf_por_kedrf,kedrf_est_kedrf, 
                                                                    kedrf_ing_appcc, kedrf_fes_crea, kedrf_usu_crea)
                                                            VALUES ( $p_empresa, $p_sucursal, $p_cabecera, 
                                                                    (SELECT edpkearf.kearf_cod_kearf  
                                                                            FROM edpkearf  
                                                                        WHERE ( edpkearf.kecrf_cod_kecrf = $p_cabecera ) AND  
                                                                                ( edpkearf.empr_cod_empr = $p_empresa ) AND  
                                                                                ( edpkearf.sucu_cod_sucu = $p_sucursal ) ),
                                                                    $p_defecto, $p_cantidad,  $p_muestras,
                                                                    (($p_cantidad/$p_muestras)*100), 'PR','1', current, $p_usuario )  
                            ");
                                $query->execute();

                                //$p_db->commit();
                                ////Si la consulta no devuelve datos devuelve mensaje
                                if (!$query)
                                {
                                    $code = 204;
                                    $message = 'Error al Ingresar datos';
                            
                                    return  json_encode([
                                            'code' => $code,
                                            'message' => $message,
                                            'result' => 'Error',
                                    ]);

                                ////Caso contrario devuelve el array con los valores
                                }else{
                                    $code = 200;
                                    $message = 'Datos Ingresados Correctamente';
                            
                                    return  json_encode([
                                            'code' => $code,
                                            'message' => $message,
                                            'result' => 'Ok',
                                    ]);
                                }
                                
                            } catch (PDOException $e) {
                                
                                $code = 204;
                                $message =$e->getMessage();
                                return   json_encode([
                                    'code' => $code,
                                    'message' => $message,
                                    'result' => 'Error',
                            ]);
                            }
                        }//if muestras
                        }///if usuario
                    }//if muestras
                 }//if Cantidad
                } //if defecto
        } //if Cabecera
}
//// Fin Funcion que inserta valores de detalles de evaluacion fisica

///Funcion que actualiza muestras de cabecera de evaluacion fisica
function Actualiza_Muestras_Remuestra_fisica($p_db, $p_empresa, $p_sucursal, $p_cabecera, $p_muestras, $p_usuario){

    if ($p_cabecera == null){
        $code = 204;
            $message = 'Ingrese Cabecera';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => 'Error',
            ]);

            
                }else{
                        if ($p_usuario == null){
                        $code = 204;
                            $message = 'Ingrese Usuario';
                    
                            return  json_encode([
                                    'code' => $code,
                                    'message' => $message,
                                    'result' => 'Error',
                            ]);
                
                        }else{
                            //////actulización de datos
                            try {
                                $query    = $p_db->prepare("    UPDATE edpkearf  
                                                                SET   kearf_tot_muest = $p_muestras,
                                                                    kearf_fes_modi = current,   
                                                                    kearf_usu_modi = $p_usuario,   
                                                                kearf_ing_appcc = '1'
                                                                WHERE (kearf_cod_kearf = $p_cabecera) AND
                                                                    (empr_cod_empr = $p_empresa )  AND  
                                                                    (sucu_cod_sucu= $p_sucursal)  
                            ");
                                $query->execute();

                                //$p_db->commit();
                                ////Si la consulta no devuelve datos devuelve mensaje
                                if (!$query)
                                {
                                    $code = 204;
                                    $message = 'Error al Ingresar datos';
                            
                                    return  json_encode([
                                            'code' => $code,
                                            'message' => $message,
                                            'result' => 'Error',
                                    ]);

                                ////Caso contrario devuelve el array con los valores
                                }else{
                                    $code = 200;
                                    $message = 'Muestras Modificadas Correctamente';
                            
                                    return  json_encode([
                                            'code' => $code,
                                            'message' => $message,
                                            'result' => 'Ok',
                                    ]);
                                }
                                
                            } catch (PDOException $e) {
                                
                                $code = 204;
                                $message =$e->getMessage();
                                return   json_encode([
                                    'code' => $code,
                                    'message' => $message,
                                    'result' => 'Error',
                            ]);
                            }
                        }///if usuario
        } //if Cabecera
}
//// Fin Funcion que actualiza muestras de cabecera de evaluacion fisica

///Funcion que procesa estado de cabecera de evaluacion fisica
function Procesa_Remuestra_fisica($p_db, $p_empresa, $p_sucursal, $p_cabecera, $p_usuario){

    if ($p_cabecera == null){
        $code = 204;
            $message = 'Ingrese Cabecera';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => 'Error',
            ]);
            
                }else{
                        if ($p_usuario == null){
                        $code = 204;
                            $message = 'Ingrese Usuario';
                    
                            return  json_encode([
                                    'code' => $code,
                                    'message' => $message,
                                    'result' => 'Error',
                            ]);
                
                        }else{
                            //////actulización de datos
                            try {
                                $query    = $p_db->prepare("     UPDATE edpkecrf  
                                                                SET kecrf_est_kecrf = 'PR',   
                                                                    kecrf_fes_modi = current,   
                                                                    kecrf_usu_modi = $p_usuario, 
                                                                    kecrf_ing_appcc = '1' 
                                                            WHERE ( edpkecrf.kecrf_cod_kecrf = $p_cabecera) AND  
                                                                    ( edpkecrf.empr_cod_empr = $p_empresa ) AND  
                                                                    ( edpkecrf.sucu_cod_sucu = $p_sucursal )  
                            ");
                                $query->execute();

                                //$p_db->commit();
                                ////Si la consulta no devuelve datos devuelve mensaje
                                if (!$query)
                                {
                                    $code = 204;
                                    $message = 'Error al modificar datos';
                            
                                    return  json_encode([
                                            'code' => $code,
                                            'message' => $message,
                                            'result' => 'Error',
                                    ]);

                                ////Caso contrario devuelve el array con los valores
                                }else{
                                    $code = 200;
                                    $message = 'Datos Procesados Correctamente';
                            
                                    return  json_encode([
                                            'code' => $code,
                                            'message' => $message,
                                            'result' => 'Ok',
                                    ]);
                                }
                                
                            } catch (PDOException $e) {
                                
                                $code = 204;
                                $message =$e->getMessage();
                                return   json_encode([
                                    'code' => $code,
                                    'message' => $message,
                                    'result' => 'Error',
                            ]);
                            }
                        }///if usuario
        } //if Cabecera
}
//// Fin Funcion que procesa estado de cabecera de evaluacion fisica

///Funcion que procesa estado de cabecera de cabezas
function Procesa_Remuestra_cabezas($p_db, $p_empresa, $p_sucursal, $p_cabecera, $p_usuario){

    if ($p_cabecera == null){
        $code = 204;
            $message = 'Ingrese Cabecera';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => 'Error',
            ]);
            
                }else{
                        if ($p_usuario == null){
                        $code = 204;
                            $message = 'Ingrese Usuario';
                    
                            return  json_encode([
                                    'code' => $code,
                                    'message' => $message,
                                    'result' => 'Error',
                            ]);
                
                        }else{
                            //////actulización de datos
                            try {
                                $query    = $p_db->prepare(" UPDATE edpkecrc  
                                                            SET kecrc_est_kecrc = 'PR',   
                                                                kecrc_fes_modi = current,   
                                                                kecrc_usu_modi = $p_usuario, 
                                                                kecrc_ing_appcc = '1' 
                                                        WHERE ( edpkecrc.kecrc_cod_kecrc = $p_cabecera) AND  
                                                                ( edpkecrc.empr_cod_empr = $p_empresa ) AND  
                                                                ( edpkecrc.sucu_cod_sucu = $p_sucursal );  
                                                        ");
                                $query->execute();

                                //$p_db->commit();
                                ////Si la consulta no devuelve datos devuelve mensaje
                                if (!$query)
                                {
                                    $code = 204;
                                    $message = 'Error al modificar datos';
                            
                                    return  json_encode([
                                            'code' => $code,
                                            'message' => $message,
                                            'result' => 'Error',
                                    ]);

                                ////Caso contrario devuelve el array con los valores
                                }else{
                                    $code = 200;
                                    $message = 'Datos Procesados Correctamente';
                            
                                    return  json_encode([
                                            'code' => $code,
                                            'message' => $message,
                                            'result' => 'Ok',
                                    ]);
                                }
                                
                            } catch (PDOException $e) {
                                
                                $code = 204;
                                $message =$e->getMessage();
                                return   json_encode([
                                    'code' => $code,
                                    'message' => $message,
                                    'result' => 'Error',
                            ]);
                            }
                        }///if usuario
        } //if Cabecera
}
//// Fin Funcion que procesa estado de cabecera de cabezas

///Funcion que inserta valores de detalles de cabezas cargadas
function Insertar_detalles_Remuestra_cabezas($p_db, $p_empresa, $p_sucursal, $p_cabecera, $p_analisis, $p_cantidad, $p_usuario){
    ////Inicio suma de total muestras ingresadas
    $suma    = $p_db->prepare("  SELECT sum(edpkedcc.kedcc_can_kedcc )
                                    FROM edpkedcc  
                                WHERE ( edpkedcc.kecrc_cod_kecrc = $p_cabecera ) AND  
                                        ( edpkedcc.empr_cod_empr = $p_empresa ) AND  
                                        ( edpkedcc.sucu_cod_sucu = $p_sucursal ) AND  
                                        ( edpkedcc.kedcc_est_kedcc <> 'AN' )      ");
        $suma->execute();

        //// Asigna los Items de la consulta a un array;
        while($row = $suma->fetch(PDO::FETCH_NUM)){
            $total = $row[0];
        }

        $total = $total + $p_cantidad;
    ////////Fin suma de muestras


    //// Muestras Cabezas 
    $smt    = $p_db->prepare("  SELECT nvl( edpkecmc.kecmc_mue_kecmc,0)  
                                FROM edpkecmc  
                            WHERE ( edpkecmc.empr_cod_empr = $p_empresa) AND  
                                    ( edpkecmc.sucu_cod_sucu = $p_sucursal) AND  
                                    ( edpkecmc.cgana_cod_cgana = 4 ) AND  
                                    ( edpkecmc.cana_cod_cana = $p_analisis ) AND  
                                    ( edpkecmc.kecmc_est_kecmc = 'A' )     ");
        $smt->execute();

        //// Asigna los Items de la consulta a un array;
        while($row = $smt->fetch(PDO::FETCH_NUM)){
            $muestras = $row[0];
        }

   // echo $p_cantidad. ' '. $muestras. ' '.$p_analisis;
    ///// fin muestras cabezas

    if ($p_cantidad == null){ $p_cantidad =0;}

    if ($p_cabecera == null){
        $code = 204;
            $message = 'Ingrese Cabecera';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => 'Error',
            ]);

    }else{
        if ($p_analisis == null){
            $code = 204;
                $message = 'Ingrese Analisis';
        
                return  json_encode([
                        'code' => $code,
                        'message' => $message,
                        'result' => 'Error',
                ]);
    
        }else{
            if ( $p_cantidad < 0){
                $code = 204;
                    $message = 'Ingrese Cantidad';
            
                    return  json_encode([
                            'code' => $code,
                            'message' => $message,
                            'result' => 'Error',
                    ]);
        
            }else{
                if ($muestras == null or $muestras == 0){
                    $code = 204;
                        $message = 'Ingrese Muestras Correctas o configure en Definiciones';
                
                        return  json_encode([
                                'code' => $code,
                                'message' => $message,
                                'result' => 'Error',
                        ]);
            
                }else{
                        if ($p_usuario == null){
                        $code = 204;
                            $message = 'Ingrese Usuario';
                    
                            return  json_encode([
                                    'code' => $code,
                                    'message' => $message,
                                    'result' => 'Error',
                            ]);
                
                        }else{
                            if ($total > $muestras){
                                $code = 204;
                                    $message = 'La suma Total no debe ser mayor a la muestra';
                            
                                    return  json_encode([
                                            'code' => $code,
                                            'message' => $message,
                                            'result' => 'Error',
                                    ]);
                        
                                }else{
                            //////Ingreso de datos
                            try {
                                if ($muestras > 0 and $p_cantidad > 0 )
                                    $porcentaje = (($p_cantidad/$muestras)*100);
                                else
                                    $porcentaje =0;

                                $query    = $p_db->prepare("   INSERT INTO edpkedcc  
                                                                ( empr_cod_empr,   sucu_cod_sucu,   kecrc_cod_kecrc,   
                                                                kearc_cod_kearc,   cgana_cod_cgana,     cana_cod_cana,   
                                                                kedcc_can_kedcc,     kedcc_mue_kedcc,      kedcc_por_kedcc,   
                                                                kedcc_est_kedcc,      kedcc_fes_crea,       kedcc_usu_crea,   
                                                                kedrc_ing_appcc )  
                                                        VALUES ( $p_empresa, $p_sucursal, $p_cabecera, 
                                                                (SELECT edpkearc.kearc_cod_kearc  
                                                                            FROM edpkearc  
                                                                        WHERE ( edpkearc.kecrc_cod_kecrc = $p_cabecera ) AND  
                                                                                ( edpkearc.empr_cod_empr = $p_empresa ) AND  
                                                                                ( edpkearc.sucu_cod_sucu = $p_sucursal ) ),
                                                                4, $p_analisis, $p_cantidad, $muestras, $porcentaje, 
                                                                'PR', current, $p_usuario,'1'
                                                                )  
                          ");
                                $query->execute();

                                //$p_db->commit();
                                ////Si la consulta no devuelve datos devuelve mensaje
                                if (!$query)
                                {
                                    $code = 204;
                                    $message = 'Error al Ingresar datos';
                            
                                    return  json_encode([
                                            'code' => $code,
                                            'message' => $message,
                                            'result' => 'Error',
                                    ]);

                                ////Caso contrario devuelve el array con los valores
                                }else{
                                    $code = 200;
                                    $message = 'Datos Ingresados Correctamente';
                            
                                    return  json_encode([
                                            'code' => $code,
                                            'message' => $message,
                                            'result' => 'Ok',
                                    ]);
                                }
                                
                            } catch (PDOException $e) {
                                
                                $code = 204;
                                $message =$e->getMessage();
                                return   json_encode([
                                    'code' => $code,
                                    'message' => $message,
                                    'result' => 'Error',
                            ]);
                            }
                        }//if muestras
                        }///if usuario
                    }//if muestras
                 }//if Cantidad
                } //if defecto
        } //if Cabecera
}
//// Fin Funcion que inserta valores de detalles de cabezas cargadas


///Funcion que inserta valores de detalles de panel de sabores
function Insertar_detalles_Remuestra_panel_sabores($p_db, $p_empresa, $p_sucursal, $p_cabecera, $p_analisis, $p_cantidad, $p_usuario){
    ////Inicio suma de total muestras ingresadas
    $suma    = $p_db->prepare("  SELECT sum(edpkedcc.kedcc_can_kedcc )
                                    FROM edpkedcc  
                                WHERE ( edpkedcc.kecrc_cod_kecrc = $p_cabecera ) AND  
                                        ( edpkedcc.empr_cod_empr = $p_empresa ) AND  
                                        ( edpkedcc.sucu_cod_sucu = $p_sucursal ) AND  
                                        ( edpkedcc.kedcc_est_kedcc <> 'AN' )      ");
        $suma->execute();

        //// Asigna los Items de la consulta a un array;
        while($row = $suma->fetch(PDO::FETCH_NUM)){
            $total = $row[0];
        }

        $total = $total + $p_cantidad;
    ////////Fin suma de muestras


    //// Muestras Cabezas 
    $smt    = $p_db->prepare("  SELECT nvl( edpkecmc.kecmc_mue_kecmc,0)  
                                FROM edpkecmc  
                            WHERE ( edpkecmc.empr_cod_empr = $p_empresa) AND  
                                    ( edpkecmc.sucu_cod_sucu = $p_sucursal) AND  
                                    ( edpkecmc.cgana_cod_cgana = 4 ) AND  
                                    ( edpkecmc.cana_cod_cana = $p_analisis ) AND  
                                    ( edpkecmc.kecmc_est_kecmc = 'A' )     ");
        $smt->execute();

        //// Asigna los Items de la consulta a un array;
        while($row = $smt->fetch(PDO::FETCH_NUM)){
            $muestras = $row[0];
        }

   // echo $p_cantidad. ' '. $muestras. ' '.$p_analisis;
    ///// fin muestras cabezas

    if ($p_cantidad == null){ $p_cantidad =0;}

    if ($p_cabecera == null){
        $code = 204;
            $message = 'Ingrese Cabecera';
    
            return  json_encode([
                    'code' => $code,
                    'message' => $message,
                    'result' => 'Error',
            ]);

    }else{
        if ($p_analisis == null){
            $code = 204;
                $message = 'Ingrese Analisis';
        
                return  json_encode([
                        'code' => $code,
                        'message' => $message,
                        'result' => 'Error',
                ]);
    
        }else{
            if ( $p_cantidad < 0){
                $code = 204;
                    $message = 'Ingrese Cantidad';
            
                    return  json_encode([
                            'code' => $code,
                            'message' => $message,
                            'result' => 'Error',
                    ]);
        
            }else{
                if ($muestras == null or $muestras == 0){
                    $code = 204;
                        $message = 'Ingrese Muestras Correctas o configure en Definiciones';
                
                        return  json_encode([
                                'code' => $code,
                                'message' => $message,
                                'result' => 'Error',
                        ]);
            
                }else{
                        if ($p_usuario == null){
                        $code = 204;
                            $message = 'Ingrese Usuario';
                    
                            return  json_encode([
                                    'code' => $code,
                                    'message' => $message,
                                    'result' => 'Error',
                            ]);
                
                        }else{
                            if ($total > $muestras){
                                $code = 204;
                                    $message = 'La suma Total no debe ser mayor a la muestra';
                            
                                    return  json_encode([
                                            'code' => $code,
                                            'message' => $message,
                                            'result' => 'Error',
                                    ]);
                        
                                }else{
                            //////Ingreso de datos
                            try {
                                if ($muestras > 0 and $p_cantidad > 0 )
                                    $porcentaje = (($p_cantidad/$muestras)*100);
                                else
                                    $porcentaje =0;

                                $query    = $p_db->prepare("   INSERT INTO edpkedcc  
                                                                ( empr_cod_empr,   sucu_cod_sucu,   kecrc_cod_kecrc,   
                                                                kearc_cod_kearc,   cgana_cod_cgana,     cana_cod_cana,   
                                                                kedcc_can_kedcc,     kedcc_mue_kedcc,      kedcc_por_kedcc,   
                                                                kedcc_est_kedcc,      kedcc_fes_crea,       kedcc_usu_crea,   
                                                                kedrc_ing_appcc )  
                                                        VALUES ( $p_empresa, $p_sucursal, $p_cabecera, 
                                                                (SELECT edpkearc.kearc_cod_kearc  
                                                                            FROM edpkearc  
                                                                        WHERE ( edpkearc.kecrc_cod_kecrc = $p_cabecera ) AND  
                                                                                ( edpkearc.empr_cod_empr = $p_empresa ) AND  
                                                                                ( edpkearc.sucu_cod_sucu = $p_sucursal ) ),
                                                                4, $p_analisis, $p_cantidad, $muestras, $porcentaje, 
                                                                'PR', current, $p_usuario,'1'
                                                                )  
                          ");
                                $query->execute();

                                //$p_db->commit();
                                ////Si la consulta no devuelve datos devuelve mensaje
                                if (!$query)
                                {
                                    $code = 204;
                                    $message = 'Error al Ingresar datos';
                            
                                    return  json_encode([
                                            'code' => $code,
                                            'message' => $message,
                                            'result' => 'Error',
                                    ]);

                                ////Caso contrario devuelve el array con los valores
                                }else{
                                    $code = 200;
                                    $message = 'Datos Ingresados Correctamente';
                            
                                    return  json_encode([
                                            'code' => $code,
                                            'message' => $message,
                                            'result' => 'Ok',
                                    ]);
                                }
                                
                            } catch (PDOException $e) {
                                
                                $code = 204;
                                $message =$e->getMessage();
                                return   json_encode([
                                    'code' => $code,
                                    'message' => $message,
                                    'result' => 'Error',
                            ]);
                            }
                        }//if muestras
                        }///if usuario
                    }//if muestras
                 }//if Cantidad
                } //if defecto
        } //if Cabecera
}
//// Fin Funcion que inserta valores de detalles de cabezas cargadas
?>