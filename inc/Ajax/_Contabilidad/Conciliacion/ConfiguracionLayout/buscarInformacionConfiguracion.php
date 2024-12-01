<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");


	$nIdCadena = !empty($_POST['nIdCadena'])? $_POST['nIdCadena'] : -1;

	$start			= (!empty($_POST["iDisplayStart"]))								? $_POST["iDisplayStart"]	: 0;
	$limit			= (!empty($_POST["iDisplayLength"]))							? $_POST["iDisplayLength"]	: 10;
	$sortCol		= (isset($_POST['iSortCol_0']) AND $_POST['iSortCol_0'] > -1)	? $_POST['iSortCol_0']		: 0;
	$sortDir		= (!empty($_POST['sSortDir_0']))								? $_POST['sSortDir_0']		: 'ASC';
	$str			= (!empty($_POST['sSearch']))									? $_POST['sSearch']			: '';

	$oRdb->setBDebug(1);

	$oReporte = new TipoConciliacion();
	$oReporte->setNIdCadena($nIdCadena);
	$oReporte->setORdb($oRdb);
	$resultado = $oReporte->select_tipo_conciliacion($sortCol, $sortDir, $start, $limit);

	if(!$resultado['bExito'] || $resultado['nCodigo'] != 0 || $resultado['found_rows'] == 0){
		$aaData = array();
		$iTotal = 0;
	}
	else{
		$aaData = utf8ize($resultado['data']);
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