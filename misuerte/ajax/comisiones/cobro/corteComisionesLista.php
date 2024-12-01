<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$dFechaFinal		= !empty($_POST['dFechaFinal'])? $_POST['dFechaFinal'] : '0000-00-00';
	$dFechaInicio		= !empty($_POST['dFechaInicio'])? $_POST['dFechaInicio'] : '0000-00-00';
	$nIdEstatus			= isset($_POST['nIdEstatus']) && $_POST['nIdEstatus'] >= 0? $_POST['nIdEstatus'] : -1;
	$nIdProveedor		= !empty($_POST['nIdProveedor'])? $_POST['nIdProveedor'] : 0;

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

	$oCorteComision = new CorteComision();
	$oCorteComision->setORdb($MRDB);
	$oCorteComision->setOWdb($MWDB);

	$oCorteComision->setDFechaInicio($dFechaInicio);
	$oCorteComision->setDFechaFinal($dFechaFinal);
	$oCorteComision->setNIdEstatus($nIdEstatus);
	$oCorteComision->setNIdProveedor($nIdProveedor);

	$resultado = $oCorteComision->listaCortes($oCfgTabla);

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		$res = array(
			"sEcho"					=> intval($_POST['sEcho']),
			"iTotalRecords"			=> 0,
			"iTotalDisplayRecords"	=> 0,
			"aaData"				=> array(),
			"errmsg"				=> ''
		);

		echo json_encode($res);
		exit();
	}

	$iTotal		= $resultado['found_rows'];
	$aaData		= $resultado['data'];

	$aaData = utf8ize($aaData);

	$res = array(
		"sEcho"					=> intval($_POST['sEcho']),
		"iTotalRecords"			=> $iTotal,
		"iTotalDisplayRecords"	=> $iTotal,
		"aaData"				=> $aaData,
		"errmsg"				=> ''
	);

	echo json_encode($res);

	$MRDB->closeConnection();
	$MWDB->closeConnection();
?>