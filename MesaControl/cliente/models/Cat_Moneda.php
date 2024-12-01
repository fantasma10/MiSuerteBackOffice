<?php
      
$htmlMonedas = '';
$dataMonedas = array();
$sQuery = "CALL `redefectiva`.`SP_LOAD_MONEDA`();";
$reslt = $RBD->query( $sQuery );

while($tipo = mysqli_fetch_array($reslt)){
    $htmlMonedas .= '<option value="'.$tipo['idMoneda'].'" '.($tipo['codigoMoneda'] === 'MXN' ? 'selected' : '').'>'.utf8_encode($tipo['codigoMoneda'].' '.$tipo['descripcionMoneda']).'</option>';
    $dataMonedas[] = array('key' => $tipo['idMoneda'], 'value' => utf8_encode($tipo['codigoMoneda'].' '.$tipo['descripcionMoneda']));
}
                
?>
