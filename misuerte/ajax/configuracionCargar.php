<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	$nIdConfiguracion		= 1;#!empty($_POST['nIdConfiguracion'])? $_POST['nIdConfiguracion'] : 1;
	$nIdUsuario				= $_SESSION['idU'];

	$oConfiguracion = new ConfiguracionRedEfectiva();
	$oConfiguracion->setORdb($MRDB);
	$oConfiguracion->setOWdb($MWDB);

	$oConfiguracion->setNIdConfiguracion($nIdConfiguracion);
	$resultado = $oConfiguracion->cargar();

	echo json_encode($resultado);

?>