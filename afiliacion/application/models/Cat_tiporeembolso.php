<?php

            
//include ('../../inc/config.inc.php');

$htmlreembolso = '';

$sQuery = "CALL `afiliacion`.`SP_TIPOREEMBOLSO`();";
$resulreembolso = $WBD->query( $sQuery );
 while($reembolso = mysqli_fetch_array($resulreembolso)){
             $htmlreembolso .= '<option value="'.$reembolso['idTipoReembolso'].'">'.utf8_encode($reembolso['descripcion']).'</option>';
 }
	  
	
?>