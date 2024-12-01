<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$nIdCorte				= !empty($_POST['nIdCorte'])			? $_POST['nIdCorte']				: 0;
	$nIdNivelConciliacion	= !empty($_POST['nIdNivelConciliacion'])? $_POST['nIdNivelConciliacion']	: 0;

	$oCorte = new CorteDiario();
	$oCorte->setORdb($oRdb);
	$oCorte->setOWdb($oWdb);
	$oCorte->setNIdNivelConciliacion($nIdNivelConciliacion);
	$oCorte->setNIdCorte($nIdCorte);
	$resultado = $oCorte->sp_liberar_corte();

	echo json_encode($resultado);

?>