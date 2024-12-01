<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	$nIdConfiguracion			= !empty($_POST['nIdConfiguracion'])? $_POST['nIdConfiguracion'] : 0;
	$sClabeRetiro				= !empty($_POST['sClabeRetiro'])? $_POST['sClabeRetiro'] : '';
	$sClabeDeposito				= !empty($_POST['sClabeDeposito'])? $_POST['sClabeDeposito'] : '';
	$nNumCuentaContableDeposito	= !empty($_POST['nNumCuentaContableDeposito'])? $_POST['nNumCuentaContableDeposito'] : '';
	$nTiempoActualizacion		= !empty($_POST['nTiempoActualizacion'])? $_POST['nTiempoActualizacion'] : 0;
	$nTiempoInactividad			= !empty($_POST['nTiempoInactividad'])? $_POST['nTiempoInactividad'] : 0;
	$nTiempoAlerta				= !empty($_POST['nTiempoAlerta'])? $_POST['nTiempoAlerta'] : 0;

	$nIdUsuario				= $_SESSION['idU'];

	$oConfiguracion = new ConfiguracionRedEfectiva();
	$oConfiguracion->setORdb($MRDB);
	$oConfiguracion->setOWdb($MWDB);

	$oConfiguracion->setNIdConfiguracion($nIdConfiguracion);
	$oConfiguracion->setSCLABERetiro($sClabeRetiro);
	$oConfiguracion->setSCLABEDeposito($sClabeDeposito);
	$oConfiguracion->setNTiempoActualizacion($nTiempoActualizacion);
	$oConfiguracion->setNTiempoInactividad($nTiempoInactividad);
	$oConfiguracion->setNTiempoAlerta($nTiempoAlerta);
	$oConfiguracion->setNIdUsuario($nIdUsuario);
	$oConfiguracion->setNNumCuentaContableDeposito($nNumCuentaContableDeposito);

	if($nIdConfiguracion == 0){
		$resultado = $oConfiguracion->guardar();
	}
	else{
		$resultado = $oConfiguracion->actualizar();
	}

	echo json_encode($resultado);

?>