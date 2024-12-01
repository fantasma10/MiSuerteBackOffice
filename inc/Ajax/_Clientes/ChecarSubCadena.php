<?php
	include("../../config.inc.php");
	$SubCadenaID = $_POST['subcadenaID'];
	$oSubCadena = new SubCadena($RBD, $WBD);
	$Res = $oSubCadena->load($SubCadenaID);
	echo $Res['codigoRespuesta'];
?>
