<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdUsuario = !empty($_POST['nIdUsuario']) ? $_POST['nIdUsuario'] : 0;
	$nMonto		= !empty($_POST['nMonto'])? $_POST['nMonto'] : 0;
	$nDias		= !empty($_POST['nDias'])? $_POST['nDias'] : 0;
	$nIdBanco	= !empty($_POST['nIdBanco'])? $_POST['nIdBanco'] : null;
	$sClave		= !empty($_POST['sClave'])? $_POST['sClave'] : '';


	if($nIdUsuario <= 0){
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> 101,
			'sMensaje'	=> 'Seleccione Usuario'
		));
	}

	if($nMonto <= 0){
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> 101,
			'sMensaje'	=> 'Capture Monto'
		));
	}

	if($nDias <= 0){
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> 101,
			'sMensaje'	=> 'Capture Días'
		));
	}


	$oHash = new Hash();
	$oHash->setString($sClave);
	$oHash->setSAlgorithmName('sha256');

	$sClave = $oHash->makeHash();

	$oConfiguracionAutorizacion = new ConfiguracionAutorizacion();
	$oConfiguracionAutorizacion->setORdb($oRdb);
	$oConfiguracionAutorizacion->setOWdb($oWdb);
	$oConfiguracionAutorizacion->setOLog($LOG);
	$oConfiguracionAutorizacion->setNIdUsuario($nIdUsuario);
	$oConfiguracionAutorizacion->setNMonto($nMonto);
	$oConfiguracionAutorizacion->setNDias($nDias);
	$oConfiguracionAutorizacion->setNIdBanco($nIdBanco);
	$oConfiguracionAutorizacion->setSClave($sClave);

	$arrRes = $oConfiguracionAutorizacion->insertar();

	if($arrRes['bExito'] == false){
		if($arrRes['nCodigo'] == 1062){
			$arrRes['sMensaje'] = "Ya existe una configuración con los datos proporcionados";
		}
	}

	echo json_encode($arrRes);

?>