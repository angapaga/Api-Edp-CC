<?php
// include "Api-Edp-CC-Header.php";
// include "Api-Edp-CC-General.php";
// include "Api-Edp-CC-Globales.php";
include "Api-Edp-CC-Globales.php";
include "Api-Edp-CC-General.php";

//  ini_set('display_errors', 1);
//  error_reporting(E_ALL);

$password = $postjson['pass'];

////PRUEBA COMENTAR
$passwordp = $postjson['pass'];

$code = 500;
$message = 'NO';

function iniciar($db, $cod_usua, $passwordp, $conexion){ //quitar p
  
   $a_origen = $password;
   $vls_str2	 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890/';
   $vls_str1 = 'z!ng*q1xs)2d(3vfr4bwt5$hy6+j|7ki8lo9@p0Z}#XS?\=R>GT;H<MJ:K]L,%P';
   $vls_result = "";
   for ($j=0; $j< strlen($a_origen); $j++){
      
      $vls_char = substr($a_origen,$j,1);
      //encriptar
      $vls_result .= substr($vls_str1, strpos($vls_str2, $vls_char), 1);
      
    }

    $password = trim($vls_result);
    
    if ($conexion == 1){
      try {

          if ($passwordp == '' or $passwordp == null or $cod_usua =='' or $cod_usua == null) //quitar p
        	{
                $code = 204;
                $message = 'Ingrese Usuario y contraseña';
        
                return  json_encode([
                        'code' => $code,
                        'message' => $message,
                        'result' => $result,
                ]);
          }else{
            $query    = $db->prepare("SELECT usua_cod_usua, 
                                            trim(usua_nom_usua), 
                                            trim(usua_cod_empl), 
                                            trim(usua_pas_usua) 
                                            FROM saeusua 
                                            WHERE usua_cod_usua=$cod_usua AND 
                                                  usua_pas_usua='$passwordp'  AND  
                                                  usua_act_asegcc = '1'") ;  ///quitar p
            $query->execute();

            while($row = $query->fetch(PDO::FETCH_NUM)){

              $result[] = array(
                      'cod_usua'   =>  $row[0],
                      'username' => mb_convert_encoding($row[1], 'UTF-8', 'ISO-8859-15'),
                      'usua_cod_empl' => $row[2],
                      'password'    => mb_convert_encoding($row[3], 'UTF-8', 'ISO-8859-15'),
                  
                    );
            }

            ////Si la consulta no devuelve datos devuelve mensaje
            if (empty($result))
            {
                $code = 204;
                $message = 'Usuario no Autorizado o datos incorrectos';
        
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
          }
        } catch (PDOException $e) {
     
            $code = 204;
            $message = $e->getMessage();
            return   json_encode([
                'code' => $code,
                'message' => $message,
                'result' => $result, ]);
        }

    
  } else{
     
    $code = 204;
    $message = 'No Hay Conexion al Servidor de Datos';
    return  json_encode([
        'code' => $code,
        'message' => $message,
        'result' => $result, ]);
  }

}

////Resuelve la petición del login
if($postjson['peticion'] == "iniciar") {
  $passwordp = $postjson['pass'];
  $cod_usua = $postjson['cod_usua'];
  echo iniciar($db, $cod_usua, $passwordp, $conexion); 
}
?>
    
    
    
    
    