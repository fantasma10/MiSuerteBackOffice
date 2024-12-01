
<?php
      
    $htmlSolicitantes = '';
    $dataSolicitantes = array();

    $sQuery = "CALL `data_acceso`.`sp_select_usuarios_comercial`";
    $reslt = $RBD->query( $sQuery );
    
    while($solicitante = mysqli_fetch_array($reslt)){
        $htmlSolicitantes .= '<option value="'.$solicitante['usuario_id'].'">'.utf8_encode($solicitante['comerciales']).'</option>';
        $dataSolicitantes[] = array('key' => $solicitante['usuario_id'], 'value' => utf8_encode($solicitante['comerciales']));
    }
                  
?>

