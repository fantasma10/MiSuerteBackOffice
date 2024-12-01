<?php
	include("../../config.inc.php");
	$cadenaID = $_POST['cadenaID'];
	$oCadena = new Cadena($RBD, $WBD);
	$Res = $oCadena->load($cadenaID);
	echo $Res['codigoRespuesta'];
?>
