<?php

	include("../../../config.inc.php");
	include("../../../session.ajax.inc.php");


	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$dFechaInicio	= (!empty($_POST['dFechaInicio']))? $_POST['dFechaInicio']	: date('Y-m-01');
	$dFechaFinal	= (!empty($_POST['dFechaFinal']))? $_POST['dFechaFinal']	: date('Y-m-t');

	$oReporte = new ReporteConciliacion();
	$oRdb->setBDebug(1);
	$oReporte->setORdb($oRdb);
	$oReporte->setOWdb($oWdb);

	$oReporte->setDFechaInicio($dFechaInicio);
	$oReporte->setDFechaFinal($dFechaFinal);

	$arrayRespuesta = array();
	/*
		Obtener suma de banco
	*/
	$resultado = $oReporte->obtenerConciliacionBanco(1);

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		echo json_encode($resultado);
		exit();
	}

	$data = $resultado['data'][0];

	$nCuentaBanco	= $data['nCuenta'];
	$nImporteBanco	= $data['nImporte'];

	$arrayRespuesta['banco'] = array(
		'nCuenta'	=> number_format($data['nCuenta']),
		'nImporte'	=> number_format($data['nImporte'], '2')
	);


	/*
		Obtener suma de ops_movimiento
	*/
	$resultado = $oReporte->obtenerConciliacionBancoForelo(1);

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		echo json_encode($resultado);
		exit();
	}

	$data = $resultado['data'][0];

	$nCuentaMovs	= $data['nCuenta'];
	$nImporteMovs	= $data['nImporte'];

	$arrayRespuesta['forelo'] = array(
		'nCuenta'	=> number_format($nCuentaMovs),
		'nImporte'	=> number_format($nImporteMovs, '2')
	);

	/*
		Obtener detalle por mes de aplicacion en el forelo
	*/
	$resultado = $oReporte->obtenerConciliacionBancoForelo(0);

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		echo json_encode($resultado);
		exit();
	}

	$data = $resultado['data'];
	$datos = array();
	foreach($data as $row){
		$datos[] = array(
			'mes'		=> $row['mes'],
			'nCuenta'	=> number_format($row['nCuenta']),
			'nImporte'	=> number_format($row['nImporte'], 2)
		);
	}

	$arrayRespuesta['forelo_detalle'] = $datos;

	/*
		Obtener suma de banco de los depositos que están sin aplicar
	*/
	$resultado = $oReporte->obtenerConciliacionBanco(0);

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		echo json_encode($resultado);
		exit();
	}

	$data = $resultado['data'][0];

	$nCuentaBanco	= $data['nCuenta'];
	$nImporteBanco	= $data['nImporte'];

	$arrayRespuesta['diferencia'] = array(
		'nCuenta'	=> number_format($nCuentaBanco),
		'nImporte'	=> number_format($nImporteBanco, '2')
	);

	echo json_encode(array(
		'bExito'	=> true,
		'nCodigo'	=> 0,
		'data'		=> $arrayRespuesta
	));
?>