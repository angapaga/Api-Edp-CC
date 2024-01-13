<?php
/// Solo Se habilita las 2 lineas de errores si la api no responde para probrar
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
$code = 500;
$message = 'NO';

///Funcion que devuelve lista de paneles de sabores por anio y estado
function Insertar_detalles_Remuestra_fisica($p_db, $p_empresa, $p_sucursal, $p_cabecera, $p_defecto, $p_cantidad, $p_muestras, $p_usuario){

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
            if ($p_cantidad == null){
                $code = 204;
                    $message = 'Ingrese Cantidad';
            
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
                        }///if usuario
                    }//if muestras
                 }//if Cantidad
                } //if defecto
        } //if Cabecera
}
//// Fin funcion Lista_Cabecera_Paneles_Sabores_Por_Estado

  
?>