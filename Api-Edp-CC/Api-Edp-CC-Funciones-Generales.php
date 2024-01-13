<?php

///////Aguaje nuevo periodo productivo seleccionar
function fg_select_periodos_anio($db, $empresa, $sucursal, $fecha, $hora){
    $ll_anio = 0;
    $ls_aguaje = '';
    $lt_hora = '';

    //$ll_anio = date("Y");
    $ll_anio = intval(date('Y', strtotime($fecha)));
    $result = array();
    try{
    $query    = $db->prepare("  SELECT saecagua.cagua_char_cagua 
                                    FROM saecagua  
                                    WHERE ( saecagua.empr_cod_empr = $empresa ) AND  
                                        ( saecagua.sucu_cod_sucu = $sucursal ) AND  
                                        ( saecagua.cagua_anio_cagua = $ll_anio )  order by  saecagua.cagua_char_cagua desc");
    $query->execute();
    
    while($row = $query->fetch(PDO::FETCH_NUM)){

	$result[] = array(
           'periodo'   =>  $row[0],
           'anio' => $ll_anio,
        );
    }

    if (empty($result))
    {
        $code = 204;
        $message =  'No hay Periodos';

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
    
    // if($data) $result = json_encode(array('success'=>true,'result'=>$data));
    // else $result = json_encode(array('success'=>false, 'msg'=>'No hay periodos Activos'));
    
    // return $result;
}

///////Aguaje nuevo periodo productivo seleccionar
function fg_select_dos_periodos($db, $empresa, $sucursal, $fecha, $hora){
    $ll_anio = 0;
    $ls_aguaje = '';
    $lt_hora = '';

    //$ll_anio = date("Y");
    $ll_anio = intval(date('Y', strtotime($fecha)));
    $result = array();
    try{
    $query    = $db->prepare("  SELECT saecagua.cagua_char_cagua 
                                FROM saecagua  
                                WHERE ( saecagua.empr_cod_empr = $empresa) AND  
                                      ( saecagua.sucu_cod_sucu = $sucursal ) AND  
                                      (saecagua.cagua_fefe_cagua >=  today -5 )
                                order by  saecagua.cagua_char_cagua desc");
    $query->execute();
    
    while($row = $query->fetch(PDO::FETCH_NUM)){

	$result[] = array(
           'periodo'   =>  $row[0],
           'anio' => $ll_anio,
        );
    }
    
    // if($data) $result = json_encode(array('success'=>true,'result'=>$data));
    // else $result = json_encode(array('success'=>false, 'msg'=>'No hay periodos Activos'));
    
    // return $result;
      ////Si la consulta no devuelve datos devuelve mensaje
      if (empty($result))
      {
          $code = 204;
          $message =  'No hay Periodos';
  
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


function fg_fecha_fija($db, $empresa){
    
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

 ////Funcion de fecha Fija
$gs_estado_fecha = fg_fecha_fija($db, $gl_empresa)[0];
if ($gs_estado_fecha == null){
    $gd_today = date('m/d/Y');
}else{
        $gd_today = date_create( fecha_fija($db, $gl_empresa)[1]);
        $gd_today = date_format($gd_today, 'm/d/Y');
        
}
////Fin Fecha Fija


 function desc_pass($password){
    //$password = $postjson['password'];

   $a_origen = $password;
   $vls_str2	 = 'z!ng*q1xs)2d(3vfr4bwt5$hy6+j|7ki8lo9@p0Z}#XS?\=R>GT;H<MJ:K]L,%P';//'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890/';
   $vls_str1 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890/';//'z!ng*q1xs)2d(3vfr4bwt5$hy6+j|7ki8lo9@p0Z}#XS?\=R>GT;H<MJ:K]L,%P';
   $vls_result = "";
   for ($j=0; $j< strlen($a_origen); $j++){
      
      $vls_char = substr($a_origen,$j,1);
      //encriptar
      $vls_result .= substr($vls_str1, strpos($vls_str2, $vls_char), 1);
      
    }
    $password = trim($vls_result);
    return  $password ;
 }


?>