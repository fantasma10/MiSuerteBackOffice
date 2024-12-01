<?php
	include("../../config.inc.php");
	$corresponsalID = $_POST['corresponsalID'];
	$oCorresponsal = new Corresponsal($RBD, $WBD);
	$Res = $oCorresponsal->load($corresponsalID);
	echo $Res['codigoRespuesta'];
?>
