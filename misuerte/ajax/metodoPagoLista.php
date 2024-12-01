<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	$nIdEstatus		= !empty($_POST['nIdEstatus'])? $_POST['nIdEstatus'] : -1;
	$nIdMetodoPago	= !empty($_POST['nIdMetodoPago'])? $_POST['nIdMetodoPago'] : -1;

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

	$MRDB->setBDebug(1);

	$oMetodoPago = new MetodoPago();
	$oMetodoPago->setORdb($MRDB);
	$oMetodoPago->setOWdb($MWDB);
	$oMetodoPago->setNIdMetodoPago($nIdMetodoPago);
	$oMetodoPago->setNIdEstatus($nIdEstatus);
	$resultado = $oMetodoPago->consulta($oCfgTabla);

	$iTotal = $resultado['num_rows'];
	$aaData = $resultado['data'];

	$aaData = utf8ize($aaData);

	$res = array(
		"sEcho"					=> intval($_POST['sEcho']),
		"iTotalRecords"			=> $iTotal,
		"iTotalDisplayRecords"	=> $iTotal,
		"aaData"				=> $aaData,
		"errmsg"				=> ''
	);

	echo json_encode($res);

?>