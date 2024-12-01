<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdNotificacion	= (!empty($_POST["nIdNotificacion"]))? $_POST["nIdNotificacion"] : 0;
	$start				= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"] : 0;
	$limit				= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 20;
	$sortCol			= (isset($_POST['iSortCol_0']) AND $_POST['iSortCol_0'] > -1)? $_POST['iSortCol_0'] : 0;
	$sortDir			= (!empty($_POST['sSortDir_0']))? $_POST['sSortDir_0'] : 0;
	$str				= (!empty($_POST['sSearch']))? $_POST['sSearch'] : '';
	$sEcho				= (!empty($_POST["sEcho"]))? $_POST["sEcho"] : 1;

	$oCfgTabla = new StdClass;
	$oCfgTabla->start	= $start;
	$oCfgTabla->limit	= $limit;
	$oCfgTabla->sortCol	= $sortCol;
	$oCfgTabla->sortDir	= $sortDir;
	$oCfgTabla->str		= $str;

	$oNotificacion = new Notificacion();
	$oNotificacion->setORdb($MRDB);
	$oNotificacion->setOWdb($MWDB);

	$oNotificacion->setNIdNotificacion($nIdNotificacion);

	$resultado = $oNotificacion->consultar($oCfgTabla);

	//echo '<pre>'; var_dump($resultado); echo '</pre>';

	$iTotal = $resultado['num_rows'];
	$aaData = $resultado['data'];

	$aaData = utf8ize($aaData);

	$res = array(
		"sEcho"					=> intval($sEcho),
		"iTotalRecords"			=> $iTotal,
		"iTotalDisplayRecords"	=> $iTotal,
		"aaData"				=> $aaData,
		"errmsg"				=> ''
	);

	echo json_encode($res);


?>