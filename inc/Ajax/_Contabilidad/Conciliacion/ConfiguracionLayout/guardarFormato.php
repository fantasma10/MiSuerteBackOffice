<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$nIdNivelConciliacion	= !empty($_POST['nIdNivelConciliacion'])							? $_POST['nIdNivelConciliacion']: 0;
	$nIdTipoConciliacion	= !empty($_POST['nIdTipoConciliacion'])								? $_POST['nIdTipoConciliacion']	: 0;
	$nIdCadena				= !empty($_POST['nIdCadena'])										? $_POST['nIdCadena']			: 0;
	$sCaracter				= !empty($_POST['sCaracter'])										? $_POST['sCaracter']			: '';
	$bConDecimales			= isset($_POST['bConDecimales']) && !empty($_POST['bConDecimales'])	? 1								: 0;


	$oTipoConciliacion = new TipoConciliacion();
	$oTipoConciliacion->setOWdb($oWdb);
	$oTipoConciliacion->setNIdNivelConciliacion($nIdNivelConciliacion);
	$oTipoConciliacion->setNIdTIpoConciliacion($nIdTipoConciliacion);
	$oTipoConciliacion->setNIdCadena($nIdCadena);
	$oTipoConciliacion->setBConDecimales($bConDecimales);
	$oTipoConciliacion->setSCaracter($sCaracter);

	$resultado = $oTipoConciliacion->updateTipoConciliacion();

	echo json_encode($resultado);

?>