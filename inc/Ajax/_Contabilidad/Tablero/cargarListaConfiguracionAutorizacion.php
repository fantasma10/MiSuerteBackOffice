<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdUsuario	= !empty($_POST['nIdUsuario'])? $_POST['nIdUsuario'] : 0;
	$nIdBanco	= !empty($_POST['nIdBanco'])? $_POST['nIdBanco'] : 0;
	$nMonto		= !empty($_POST['nMonto'])? $_POST['nMonto'] : 0;
	$nDias		= !empty($_POST['nDias'])? $_POST['nDias'] : 0;
	$nIdEstatus	= !empty($_POST['nIdEstatus'])? $_POST['nIdEstatus'] : 0;

	$start		= (!empty($_REQUEST["iDisplayStart"]))? $_REQUEST["iDisplayStart"] : 0;
	$limit		= (!empty($_REQUEST["iDisplayLength"]))? $_REQUEST["iDisplayLength"] : 20;

	$sortCol	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$sortDir	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$str		= (!empty($_REQUEST['sSearch']))? $_REQUEST['sSearch'] : '';

	$oConfiguracionAut = new ConfiguracionAutorizacion();
	$oConfiguracionAut->setORdb($oRdb);
	$oConfiguracionAut->setOWdb($oWdb);

	$oConfiguracionAut->setNIdUsuario($nIdUsuario);
	$oConfiguracionAut->setNIdBanco($nIdBanco);
	$oConfiguracionAut->setNMonto($nMonto);
	$oConfiguracionAut->setNDias($nDias);
	$oConfiguracionAut->setNIdEstatus($nIdEstatus);

	$oConfiguracionAut->setSBuscar($str);
	$oConfiguracionAut->setNStart($start);
	$oConfiguracionAut->setNLimit($limit);
	$oConfiguracionAut->setNSortCol($sortCol);
	$oConfiguracionAut->setSSortDir($sortDir);

	$arrData = $oConfiguracionAut->consultar();

	if($arrData['bExito'] == true){
		$response = array(
			"sEcho"					=> intval($_GET['sEcho']),
			"iTotalRecords"			=> $arrData['nTotal'],
			"iTotalDisplayRecords"	=> $arrData['nTotal'],
			"aaData"				=> $arrData['data'],
			"errmsg"				=> ''
		);
	}
	else{
		$response = $arrData;
	}


	echo json_encode($response);
?>