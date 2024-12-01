<?php

            
//include ('../../inc/config.inc.php');

$htmlliquidacion = '';

$sQuery = "CALL `afiliacion`.`SP_TIPOLIQUIDACION`();";
$resulliquidacion = $WBD->query( $sQuery );
 while($liquidacion  = mysqli_fetch_array($resulliquidacion)){
             $htmlliquidacion .= '<option value="'.$liquidacion['idTipoLiquidacion'].'">'.utf8_encode($liquidacion['descripcion']).'</option>';
 }
	
	
?>