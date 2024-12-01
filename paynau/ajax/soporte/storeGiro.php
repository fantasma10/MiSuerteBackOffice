<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	$oGiro = new C_Giro();
	$oGiro->setORdb($oRdb);
	$oGiro->setOWdb($oWdb);

	$resultado = $oGiro->storeGiro();
	$resultado = utf8ize($resultado);
	
	echo json_encode($resultado);

?>