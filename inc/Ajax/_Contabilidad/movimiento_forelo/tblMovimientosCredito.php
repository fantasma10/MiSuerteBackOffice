<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdTipoMovimiento	= !empty($_POST['nIdTipoMovimiento'])							? $_POST['nIdTipoMovimiento']	: 11;
	$nNumCuenta			= !empty($_POST['nNumCuenta'])									? $_POST['nNumCuenta']			: '';
	$nIdEstatus			= isset($_POST['nIdEstatus']) && $_POST['nIdEstatus'] >= 0		? $_POST['nIdEstatus']			: -1;
	$nIdTipoCobro		= !empty($_POST['nIdTipoCobro'])								? $_POST['nIdTipoCobro']		: -1;
	$dFechaInicio		= !empty($_POST['dFechaInicio'])								? $_POST['dFechaInicio']		: '0000-00-00';
	$dFechaFinal		= !empty($_POST['dFechaFinal'])									? $_POST['dFechaFinal']			: '0000-00-00';
	$start				= (!empty($_POST["iDisplayStart"]))								? $_POST["iDisplayStart"]		: 0;
	$limit				= (!empty($_POST["iDisplayLength"]))							? $_POST["iDisplayLength"]		: 20;
	$sortCol			= (isset($_POST['iSortCol_0']) AND $_POST['iSortCol_0'] > -1)	? $_POST['iSortCol_0']			: 0;
	$sortDir			= (!empty($_POST['sSortDir_0']))								? $_POST['sSortDir_0']			: 0;
	$str				= (!empty($_POST['sSearch']))									? $_POST['sSearch']				: '';

	$oCfgTabla = new StdClass;
	$oCfgTabla->start	= $start;
	$oCfgTabla->limit	= $limit;
	$oCfgTabla->sortCol	= $sortCol;
	$oCfgTabla->sortDir	= $sortDir;
	$oCfgTabla->str		= $str;

	$oRdb->setBDebug(1);

	$oCredito = new CreditoForelo();
	$oCredito->setORdb($oRdb);
	$oCredito->setOWdb($oWdb);

	$array_params = array(
		array(
			'name'	=> 'nNumCuenta',
			'type'	=> 'i',
			'value'	=> $nNumCuenta
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
			'name'	=> 'nIdEstatus',
			'type'	=> 'i',
			'value'	=> $nIdEstatus
		),
		array(
			'name'	=> 'nIdTipoCobro',
			'type'	=> 'i',
			'value'	=> $nIdTipoCobro
		),
		array(
			'name'	=> 'nIdTipoMovimiento',
			'type'	=> 'i',
			'value'	=> $nIdTipoMovimiento
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

	$resultado = $oCredito->lista($array_params);

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0 || $resultado['num_rows'] == 0){
		$aaData = array();
		$iTotal = 0;
	}
	else{
		$aaData = $resultado['data'];
		$aaData	= utf8ize($aaData);

		foreach($aaData as $key => $row){
			$aaData[$key]['nAbono']		= $row['abonoMov'];
			$aaData[$key]['abonoMov']	= "\$ ".number_format($row['abonoMov'], 2, '.', ',');
		}

		$iTotal = $resultado['num_rows'];
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