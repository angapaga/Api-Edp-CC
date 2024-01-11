<?php
include "Api-Edp-CC-Header.php";
include "Api-Edp-CC-General.php";
include "Api-Edp-CC-Globales.php";

$cod_usua= $postjson['cod_usua'];

if($postjson['req'] == "login") {
   $password = $postjson['password'];

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
    
    $datauser = array(); 
    if ($conexion == 1){
    $query    = $db->prepare("SELECT usua_cod_usua, 
                                    trim(usua_nom_usua), 
                                    usua_cod_empl, 
                                    trim(usua_pas_usua) 
                                    FROM saeusua 
                                    WHERE usua_cod_usua=$postjson[cod_usua] AND 
                                          usua_pas_usua='$password'  ") ;  // AND      usua_aut_palet = '1'
    $query->execute();

    while($data = $query->fetch(PDO::FETCH_NUM)){

	$datauser[] = array(
           'cod_usua'   =>  $data[0],
           'username' => utf8_encode($data[1]),
           'usua_cod_empl' => $data[2],
           'password'    => utf8_encode($data[3]),
       
        );
    }

    if ($gs_aguaje == null or $gs_aguaje ==''){
        $result = json_encode(array('success' => false, 'msg'=>'Seleccione el Periodo'));
    
     }else{   

  if($datauser){
        if($query) $result = json_encode(array('success' =>true, 'result'=>$datauser));
        else $result = json_encode(array('success' => false, 'msg'=>'error, Intente de nuevo'));

}else{
  $result = json_encode(array('success' => false, 'msg'=>'Usuario no Registrado o no Activo'));
}
     }

} else{
  $result = json_encode(array('success' => false, 'msg'=>'No hay Conexion a Edpacif'));
}

echo $result;
}


?>
    
    
    
    
    