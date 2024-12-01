<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	$nIdProveedor = !empty($_POST['nIdProveedor'])? $_POST['nIdProveedor'] : 0;

	$oProveedor = new Proveedor();
	$oProveedor->setORdb($MRDB);
	$oProveedor->setOWdb($MWDB);

	$oProveedor->setNIdProveedor($nIdProveedor);

	$resultado = $oProveedor->listaCombo();

	echo json_encode($resultado);
?>