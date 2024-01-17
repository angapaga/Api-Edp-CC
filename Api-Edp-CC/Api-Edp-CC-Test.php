<?php
//CONEXION A EDPACIF
include "Api-Edp-CC-General.php";
include "Api-Edp-CC-Globales.php";

ini_set('display_errors', 1);
 error_reporting(E_ALL);

//phpinfo();

echo Lista_Defectos_Panel_Sabor($db, $gl_empresa, $gl_sucursal);

///// Lista de defectos panel de sabor
function Lista_Defectos_Panel_Sabor($p_db, $p_empresa, $p_sucursal){
    $result=[];
    try {
        $query    = $p_db->prepare("   SELECT edpkpsde.kpsde_cod_kpsde,
                                                edpkpsde.cgana_cod_cgana ,
                                                trim(edpkpsde.kpsde_des_kpsde)
                                        FROM edpkpsde  
                                        WHERE ( edpkpsde.empr_cod_empr = $p_empresa ) AND  
                                                ( edpkpsde.sucu_cod_sucu = $p_sucursal ) AND  
                                                ( edpkpsde.kpsde_est_kpsde <> 'I' ) 
                                   ");
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
/////Fin Lista de niveles panel de sabor

?>