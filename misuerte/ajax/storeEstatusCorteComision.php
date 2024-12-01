<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	$nIdEstatus = -1;

	$oEstatus = new EstatusCorteComision();
	$oEstatus->setORdb($MRDB);
	$oEstatus->setOWdb($MWDB);

	$oEstatus->setNIdEstatus($nIdEstatus);

	$resultado = $oEstatus->listaCombo();

	$resultado = utf8ize($resultado);

	echo json_encode($resultado);
?>