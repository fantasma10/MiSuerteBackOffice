<?php
      
$htmlTipoLiquidaciones = '';
$dataTipoLiquidaciones = array();
$sQuery = "CALL `redefectiva`.`SP_TIPOLIQUIDACION_LISTA`();";
$reslt = $RBD->query( $sQuery );

$dataTipoLiquidaciones[] = array('key' => -1, 'value' => 'Seleccione');
while($tipo = mysqli_fetch_array($reslt)){
    $htmlTipoLiquidaciones .= '<option value="'.$tipo['nIdTipoLiquidacion'].'">'.utf8_encode($tipo['sNombre']).'</option>';
    $dataTipoLiquidaciones[] = array('key' => $tipo['nIdTipoLiquidacion'], 'value' => utf8_encode($tipo['sNombre']));
}
                
?>