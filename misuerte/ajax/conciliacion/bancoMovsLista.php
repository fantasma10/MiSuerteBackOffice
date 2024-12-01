<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdEstatus		= !empty($_POST['nIdEstatus'])? $_POST['nIdEstatus'] : 1;
	$dFechaInicio	= !empty($_POST['dFechaInicio'])? $_POST['dFechaInicio'] : '0000-00-00';
	$dFechaFinal	= !empty($_POST['dFechaFinal'])? $_POST['dFechaFinal'] : '0000-00-00';

	$oBancoMov = new BancoMovMiSuerte();
	$oBancoMov->setORdb($MRDB);
	$oBancoMov->setOWdb($MWDB);

	$oBancoMov->setIdEstatus($nIdEstatus);

	$resultado = $oBancoMov->listaMovimientos($dFechaInicio, $dFechaFinal);

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		echo json_encode($resultado);
		exit();
	}

	$data	= $resultado['data'];
	$length	= count($data);
	//echo '<pre>'; var_dump($data); echo '</pre>';
	for($i=0; $i<$length;$i++){
		$data[$i]['importeFormato'] = "$ ". number_format($data[$i]['importe'], 2, '.', ',');
	}

	$resultado['data'] = $data;

	echo json_encode($resultado);
?>