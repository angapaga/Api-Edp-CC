<?php
/// Función aguaje y turno
function fg_aguaje_ant ($db, $fecha, $hora) {
    $ll_anio = 0;
    $ls_aguaje = '';
    $lt_hora = '';

    //$ll_anio = date("Y");
    $ll_anio = intval(date('Y', strtotime($fecha)));

    $query    = $db->prepare("  SELECT saequin.quin_cod_quin, 
                                       saequin.quin_fec_inic, 
                                       saequin.quin_fec_hast
                                FROM saequin  
                                WHERE ( saequin.quin_cod_ppag = '8' ) AND  
                                    ( saequin.quin_anio_quin = $ll_anio ) AND  
                                    ( saequin.quin_fec_inic <= date('$fecha') ) AND  
                                    ( saequin.quin_fec_hast >= date('$fecha') ) 
                            ");
    $query->execute();
    
    while($row = $query->fetch(PDO::FETCH_NUM)){

        $gs_aguaje =  $row[0];
        $f_inicio =  $row[1];
        $f_fin =  $row[2];
    }

    //hora  date( "H:i");
    $lt_hora = date( "H:i");//date( "H:i", strtotime('19:31') );

    if ($lt_hora >= date( "H:i", strtotime('07:30') ) && $lt_hora <= date( "H:i", strtotime('19:30') )  ) {  // turno dia
        
        $gl_turno = 1;
  
     } else{  // turno noche

        if ($lt_hora > date( "H:i", strtotime('19:30') ) && $lt_hora <= date( "H:i", strtotime('23:59') ) ){
            $gl_turno = 2;
        }

        if ($lt_hora >= date( "H:i", strtotime('00:01') ) && $lt_hora < date( "H:i", strtotime('07:30') ) )
        {
            $gl_turno = 2;

        }

    }
    return array($gs_aguaje, $gl_turno);
 }


///////Aguaje nuevo periodo productivo seleccionar
function fg_select_periodos_anio($db, $empresa, $sucursal, $fecha, $hora){
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
function fg_select_dos_periodos($db, $empresa, $sucursal, $fecha, $hora){
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