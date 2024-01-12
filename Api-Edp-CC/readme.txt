<?php
//CONEXION A EDPACIF
//include "Api-Edp-CC-General.php";
//include "Api-Edp-CC-Funciones-Generales.php";
//include "Api-Edp-CC-Globales.php";
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
$code = 500;
$message = 'NO';

///Funcion que devuelve lista de paneles de sabores pendientes
function Lista_Cabecera_Paneles_Sabores_Por_Estado($p_db, $p_empresa, $p_sucursal, $p_anio, $p_estado, $p_empleado){
    try {
         $Nombre_Sp = 'sp_p_aseg_cc_lista_cabecera_paneles_sabores_estado';

        // Preparar la llamada al procedimiento almacenado con la cantidad de valores de parámetros a recibir
        $consulta = $p_db->prepare("EXECUTE PROCEDURE $Nombre_Sp(?, ?, ?, ?, ?)");
        // Asignar valores a los parámetros
        $consulta->bindParam(1, $p_empresa, PDO::PARAM_INT);
        $consulta->bindParam(2, $p_sucursal, PDO::PARAM_INT);
        $consulta->bindParam(3, $p_anio, PDO::PARAM_STR);
        $consulta->bindParam(4,  $p_estado, PDO::PARAM_STR);
        $consulta->bindParam(5,  $p_empleado, PDO::PARAM_STR);
       
        // Ejecutar el procedimiento almacenado
        $consulta->execute();
        $code = 200;
        $message = 'SI';

        // Obtener los resultados (puedes adaptar esto según lo que devuelva tu procedimiento almacenado)
        $result =  $consulta->fetchAll(PDO::FETCH_ASSOC);

        return  json_encode([
                'code' => $code,
                'message' => $message,
                'result' => $result,
        ]);
        
    } catch (Exception $e) {
        echo $e;
        $code = 204;
        $message = 'NO';
        $result=[];
        return   json_encode([
            'code' => $code,
            'message' => $message,
            'result' => $result,
    ]);
    }
}

// //phpinfo();


?>
