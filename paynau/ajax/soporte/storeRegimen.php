<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
	$oRegimen = new C_Regimen();
	$oRegimen->setORdb($oRdb);
	$oRegimen->setOWdb($oWdb);

	$resultado = $oRegimen->storeRegimen();
	$resultado = utf8ize($resultado);

	echo json_encode($resultado);

?>