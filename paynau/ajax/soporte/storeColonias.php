<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
	
	$sCodigoPostal = !empty($_POST['sCodigoPostal'])? $_POST['sCodigoPostal'] : '';

	$oColonia = new C_Colonia();
	$oColonia->setORdb($oRdb);
	$oColonia->setOWdb($oWdb);
	$oColonia->setSCodigoPostal($sCodigoPostal);

	$resultado = $oColonia->storeColonia();
	$resultado = utf8ize($resultado);

	echo json_encode($resultado);

?>