<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$sFolio			= !empty($_POST['sFolio'])? $_POST['sFolio'] : '';
	$dFechaInicio	= !empty($_POST['dFechaInicio'])? $_POST['dFechaInicio'] : '0000-00-00';
	$dFechaFinal	= !empty($_POST['dFechaFinal'])? $_POST['dFechaFinal'] : '0000-00-00';
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

	$oPoliza = new Poliza();
	$oPoliza->setORdb($oRdb);
	$oPoliza->setOWdb($oWdb);

	$array_params = array(
		array(
			'name'	=> 'sFolio',
			'type'	=> 's',
			'value'	=> $sFolio
		),
		array(
			'name'	=> 'dFechaInicio',
			'type'	=> 's',
			'value'	=> $dFechaInicio
		),
		array(
			'name'	=> 'dFechaFinal',
			'type'	=> 's',
			'value'	=> $dFechaFinal
		),
		array(
			'name'	=> 'str',
			'value'	=> utf8_decode($oCfgTabla->str),
			'type'	=> 's'
		),
		array(
			'name'	=> 'start',
			'value'	=> $oCfgTabla->start,
			'type'	=> 'i'
		),
		array(
			'name'	=> 'limit',
			'value'	=> $oCfgTabla->limit,
			'type'	=> 'i'
		),
		array(
			'name'	=> 'sortCol',
			'value'	=> $oCfgTabla->sortCol,
			'type'	=> 'i'
		),
		array(
			'name'	=> 'sortDir',
			'value'	=> $oCfgTabla->sortDir,
			'type'	=> 's'
		)
	);

	$resultado = $oPoliza->obtenerListaTbl($array_params);

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0 || $resultado['num_rows'] == 0){
		$aaData = array();
		$iTotal = 0;
	}
	else{
		$aaData = $resultado['data'];
		$iTotal = $resultado['found_rows'];
	}

	$output = array(
		"sEcho"					=> intval($_POST['sEcho']),
		"iTotalRecords"			=> $iTotal,
		"iTotalDisplayRecords"	=> $iTotal,
		"aaData"				=> $aaData,
		"errmsg"				=> ''
	);

	echo json_encode($output);
?>