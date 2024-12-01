<?php
      
$htmlBancos = '';
$dataBancos = array();
$sQuery = "CALL `redefectiva`.`SP_LOAD_BANCOS`();";
$reslt = $RBD->query( $sQuery );

while($tipo = mysqli_fetch_array($reslt)){
    $htmlBancos .= '<option value="'.$tipo['idBanco'].'">'.utf8_encode($tipo['nombreBanco']).'</option>';
    $dataBancos[] = array('key' => $tipo['idBanco'], 'value' => utf8_encode($tipo['nombreBanco']));
}
                
?>

