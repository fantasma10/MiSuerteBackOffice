<?php
      
$htmlCuentasRE = '';
$dataCuentasRE = array();
$sQuery = "CALL `redefectiva`.`sp_select_cuentas_re`();";
$reslt = $RBD->query( $sQuery );

$dataCuentasRE[] = array('key' => -1, 'value' => 'Seleccione');
while($tipo = mysqli_fetch_array($reslt)){
    $htmlCuentasRE .= '<option value="'.$tipo['nIdCuentaRE'].'">'.utf8_encode($tipo['sCuenta']).'</option>';
    $dataCuentasRE[] = array('key' => $tipo['nIdCuentaRE'], 'value' => utf8_encode($tipo['sCuenta']));
}
                
?>