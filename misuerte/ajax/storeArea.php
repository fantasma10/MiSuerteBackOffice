<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	$oArea = new Area();
	$oArea->setORdb($MRDB);
	$oArea->setOWdb($MWDB);
	$oArea->setNIdArea(0);
	$resultado = $oArea->consultar();

	$resultado = utf8ize($resultado);

	echo json_encode($resultado);

?>