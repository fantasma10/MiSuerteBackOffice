<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	$nIdMetodoPago = !empty($_POST['nIdMetodoPago'])? $_POST['nIdMetodoPago'] : 0;

	$start			= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"] : 0;
	$limit			= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 20;
	$sortCol		= (isset($_POST['iSortCol_0']) AND $_POST['iSortCol_0'] > -1)? $_POST['iSortCol_0'] : 0;
	$sortDir		= (!empty($_POST['sSortDir_0']))? $_POST['sSortDir_0'] : 0;
	$str			= (!empty($_POST['sSearch']))? $_POST['sSearch'] : '';

	$oCfgTabla = new StdClass;
	$oCfgTabla->start	= $start;
	$oCfgTabla->limit	= $limit;
	$oCfgTabla->sortCol	= $sortCol;
	$oCfgTabla->sortDir	= $sortDir;
	$oCfgTabla->str		= $str;

	$oMetodoPago = new MetodoPago();
	$oMetodoPago->setORdb($MRDB);
	$oMetodoPago->setOWdb($MWDB);
	$oMetodoPago->setNIdMetodoPago($nIdMetodoPago);
	$oMetodoPago->setNIdEstatus($nIdEstatus);

	$resultado = $oMetodoPago->consulta($oCfgTabla);

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		echo json_encode($resultado);
		exit();
	}

	$resultado = utf8ize($resultado);

	$oDiasPago = new DiasPago();
	$oDiasPago->setORdb($MRDB);
	$oDiasPago->setORdb($MWDB);
	$oDiasPago->setNIdMetodoPago($nIdMetodoPago);

	$resultado_diaspago = $oDiasPago->consultarDiasPago();

	if($resultado_diaspago['bExito'] == false || $resultado_diaspago['nCodigo'] != 0){
		echo json_encode($resultado_diaspago);
		exit();
	}

	$array_diaspago = $resultado_diaspago['data'];

	$resultado['data'][0]['array_diaspago'] = $array_diaspago;

	echo json_encode($resultado);
?>