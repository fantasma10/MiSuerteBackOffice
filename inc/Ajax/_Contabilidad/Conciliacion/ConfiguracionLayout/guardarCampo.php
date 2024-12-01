<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$nIdCadena			= !empty($_POST['nIdCadena'])		? $_POST['nIdCadena']			: 0;
	$nIdCampo			= !empty($_POST['nIdCampo'])		? $_POST['nIdCampo']			: '';
	$nPosicionInicial	= !empty($_POST['nPosicionInicial'])? $_POST['nPosicionInicial']	: '';
	$nPosicionFinal		= !empty($_POST['nPosicionFinal'])	? $_POST['nPosicionFinal']		: '';
	$sValorComparar		= !empty($_POST['sValorComparar'])	? $_POST['sValorComparar']		: '';

	$oCampo = new InfCampoConciliacion();
	$oCampo->setOWdb($oWdb);
	$oCampo->setNIdCadena($nIdCadena);
	$oCampo->setNIdCampo($nIdCampo);
	$oCampo->setNPosicionInicial($nPosicionInicial);
	$oCampo->setNPosicionFinal($nPosicionFinal);
	$oCampo->setSValorComparar($sValorComparar);

	$resultado = $oCampo->sp_update_campo();

	echo json_encode($resultado);

?>