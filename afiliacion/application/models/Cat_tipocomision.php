<?php

            
//include ('../../inc/config.inc.php');

$htmlcomision = '';

$sQuery = "CALL `afiliacion`.`SP_TIPOCOMISION`();";
$resultcomision = $WBD->query( $sQuery );
while($comision  = mysqli_fetch_array($resultcomision)){
             $htmlcomision .= '<option value="'.$comision['idTipoComision'].'">'.utf8_encode($comision['descripcion']).'</option>';
 }
	      

	
?>