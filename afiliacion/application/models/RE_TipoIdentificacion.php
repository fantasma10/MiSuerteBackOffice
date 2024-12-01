<?php

        
//include ('../../inc/config.inc.php');

$htmlTipoID = '';

	$sQuery = "CALL `redefectiva`.`SP_TIPOIDENTIFICACION_LISTA`();";
$resultTipoID = $RBD->query( $sQuery );
 while($tipoID  = mysqli_fetch_array($resultTipoID)){
   $htmlTipoID .= '<option value="'.$tipoID['idTipoIdentificacion'].'">'.utf8_encode($tipoID['descTipoIdentificacion']).'</option>';
 }	

	   


?>