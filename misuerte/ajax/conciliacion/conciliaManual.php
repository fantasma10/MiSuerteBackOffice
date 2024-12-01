<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$array_movs = !empty($_POST['array_movs'])? $_POST['array_movs'] : array();
	$array_facs = !empty($_POST['array_facs'])? $_POST['array_facs'] : array();

	$sListaMovs = implode(',', $array_movs);
	$sListaFacs = implode(',', $array_facs);

	$oCorteComision = new CorteComision();
	$oCorteComision->setORdb($MRDB);
	$oCorteComision->setOWdb($MWDB);

	$resultado = $oCorteComision->conciliacionManual($sListaMovs, $sListaFacs);

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		echo json_encode($resultado);
		exit();
	}

	$data = $resultado['data'][0];

	$resultado['bExito']	= ($data['nCodigo'] == 0)? true : false;
	$resultado['nCodigo']	= $data['nCodigo'];
	$resultado['sMensaje']	= $data['sMensaje'];

	echo json_encode($resultado);
?>