<?php
//CONEXION A EDPACIF
include "Api-Edp-CC-General.php";
include "Api-Edp-CC-Funciones-Generales.php";
include "Api-Edp-CC-Globales.php";


//phpinfo();
////Mostar clientes
if($postjson['peticion'] == 'clientes')
{
    $data = array(); //edpcklib.cklib_cod_guia,
    $query    = $db->prepare("   SELECT  clpv_cod_clpv, clpv_nom_clpv   
                                    
                                FROM saeclpv cl  
                                WHERE ( cl.clpv_cod_empr = $gl_empresa ) AND  
                                                ( cl.clpv_cod_sucu = $gl_sucursal ) AND 
                                                ( cl.clpv_cod_clpv = 22 )   ");
    $query->execute();
    //// Recorre todos los items de la consulta y se los asigna a un array
    while($row = $query->fetch(PDO::FETCH_NUM)){
        $data[] = array(
            'codigo' => $row[0],
            'nombre' => $row[1],     
            );
    }

    if($data) $result = json_encode(array('success'=>true,'result'=>$data));
    else $result = json_encode(array('success'=>false, 'msg'=>'No ha recibido Guias Logística'));
    
    echo $result;
   
}

?>