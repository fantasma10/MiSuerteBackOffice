<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';

	$nIdEstatus	= !empty($_POST['nIdEstatus'])? $_POST['nIdEstatus'] : 0;

	$oEstatus = new EstatusPronosticos();
	$oEstatus->setORdb($MRDB);
	$oEstatus->setOWdb($MWDB);
	$oEstatus->setNIdEstatus(-1);
	$resultado = $oEstatus->listaCombo();

	echo json_encode($resultado);

?>