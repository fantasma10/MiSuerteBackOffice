<?php
	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	function getUltimoDiaMes($elAnio,$elMes) {
		return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
	}

	$nIdProveedor	= !empty($_POST['nIdProveedor'])? trim($_POST['nIdProveedor']) : 0;
	$nIdCliente		= !empty($_POST['nIdCliente'])? trim($_POST['nIdCliente']) : 0;
	$nIdPeriodo		= !empty($_POST['nIdPeriodo'])? trim($_POST['nIdPeriodo']) : 0;

	$arr_periodo = explode('-', $nIdPeriodo);
	$month	= $arr_periodo[0];
	$year	= $arr_periodo[1];

	$lastDay = getUltimoDiaMes($year, $month);

	$dFechaInicio	= $year.'-'.$month.'-01';
	$dFechaFinal	= $year.'-'.$month.'-'.$lastDay;

	/*
		Corte de comisiones a Red Efectiva
	*/
	$oCorteComision = new CorteComision();
	$oCorteComision->setORdb($MRDB);
	$oCorteComision->setOWdb($MWDB);

	$oCorteComision->setDFechaInicio($dFechaInicio);
	$oCorteComision->setDFechaFinal($dFechaFinal);
	$oCorteComision->setNIdProveedor($nIdProveedor);

	$resultado = $oCorteComision->obtenerCorteMensual();

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		echo json_encode($resultado);
		exit();
	}

	$data = $resultado['data'];

	$suma = array(
		'suma_nImporteVentaIndirecta'	=> 0,
		'suma_nImporteTotal'			=> 0,
		'suma_nImporteComision'			=> 0,
		'suma_sNombreComercial'			=> ''
	);

	foreach($data as $key => $row){
		$suma['suma_nImporteVentaIndirecta'] += $row['nImporteVentaIndirecta'];
		$suma['suma_nImporteTotal']			+= $row['nImporteTotal'];
		$suma['suma_nImporteComision']		+= $row['nImporteComision'];

		$data[$key]['nImporteVentaIndirecta']	= '$ '.number_format($row['nImporteVentaIndirecta'], '2', '.', ',');
		$data[$key]['nImporteComision']			= '$ '.number_format($row['nImporteComision'], '2', '.', ',');
		$data[$key]['nImporteTotal']			= '$ '.number_format($row['nImporteTotal'], '2', '.', ',');
	}


	/*
		Corte de comisiones que se le pagan a clientes
	*/
	$oCorteCliente = new CorteComisionCliente();
	$oCorteCliente->setORdb($MRDB);
	$oCorteCliente->setOWdb($MWDB);

	$oCorteCliente->setDFechaInicio($dFechaInicio);
	$oCorteCliente->setDFechaFin($dFechaFinal);
	$oCorteCliente->setNIdCliente($nIdCliente);

	$resultadoCliente = $oCorteCliente->obtenerCorteMensual();

	if($resultadoCliente['bExito'] == false || $resultadoCliente['nCodigo'] != 0){
		echo json_encode($resultadoCliente);
		exit();
	}

	$dataCliente = $resultadoCliente['data'];

	$sumaCliente = array(
		'suma_nImporteVentaIndirecta'	=> 0,
		'suma_nMonto'					=> 0,
		'suma_nComision'				=> 0,
		'suma_sNombreComercial'			=> ''
	);

	foreach($dataCliente as $key => $row){
		$sumaCliente['suma_nImporteVentaIndirecta'] += $row['nImporteVentaIndirecta'];
		$sumaCliente['suma_nMonto']			+= $row['nMonto'];
		$sumaCliente['suma_nComision']		+= $row['nComision'];

		$dataCliente[$key]['nImporteVentaIndirecta']	= '$ '.number_format($row['nImporteVentaIndirecta'], '2', '.', ',');
		$dataCliente[$key]['nComision']					= '$ '.number_format($row['nComision'], '2', '.', ',');
		$dataCliente[$key]['nMonto']					= '$ '.number_format($row['nMonto'], '2', '.', ',');
	}


	$nUtilidad = $suma['suma_nImporteComision'] - $sumaCliente['suma_nComision'];
	$nUtilidad = '$ '.number_format($nUtilidad, '2', '.', ',');

	$suma['suma_nImporteVentaIndirecta']	= "$ ".number_format($suma['suma_nImporteVentaIndirecta'], '2', '.', ',');
	$suma['suma_nImporteTotal']				= "$ ".number_format($suma['suma_nImporteTotal'], '2', '.', ',');
	$suma['suma_nImporteComision']			= "$ ".number_format($suma['suma_nImporteComision'], '2', '.', ',');


	$sumaCliente['suma_nImporteVentaIndirecta'] = '$ '.number_format($sumaCliente['suma_nImporteVentaIndirecta'], '2', '.', ',');
	$sumaCliente['suma_nMonto']					= '$ '.number_format($sumaCliente['suma_nMonto'], '2', '.', ',');
	$sumaCliente['suma_nComision']				= '$ '.number_format($sumaCliente['suma_nComision'], '2', '.', ',');

	$resultado['data'] = array(
		'proveedor'	=> array(
			'data'		=> $data,
			'footer'	=> $suma
		),
		'cliente'		=> array(
			'data'		=> $dataCliente,
			'footer'	=> $sumaCliente
		)
		,
		'utilidades'	=> array(
			'nComisionesGanadas'	=> $suma['suma_nImporteComision'],
			'nComisionesAClientes'	=> $sumaCliente['suma_nComision'],
			'nUtilidad'				=> $nUtilidad
		)
	);

	echo json_encode($resultado);
?>