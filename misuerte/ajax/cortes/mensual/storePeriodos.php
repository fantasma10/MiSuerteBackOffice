<?php
	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$oPeriodoCorte = new PeriodoCorte();
	$oPeriodoCorte->setORdb($MRDB);
	$oPeriodoCorte->setOWdb($MWDB);

	$resultado = $oPeriodoCorte->proveedorCorteComision();

	echo json_encode($resultado);
?>