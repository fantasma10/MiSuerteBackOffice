<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$idOpcion		= 121;
	$tipoDePagina	= "Mixto";
	$esEscritura	= false;

	$nIdBanco			= !empty($_REQUEST['nIdBanco'])? trim($_REQUEST['nIdBanco']) : 0;
	$nNumCuentaBancaria	= !empty($_REQUEST['nNumCuentaBancaria'])? trim($_REQUEST['nNumCuentaBancaria']) : '';
	$nNumCuentaContable	= !empty($_REQUEST['nNumCuentaContable'])? trim($_REQUEST['nNumCuentaContable']) : '';
	$nIdEstatus			= isset($_REQUEST['nIdEstatus']) && $_REQUEST['nIdEstatus'] >= 0? trim($_REQUEST['nIdEstatus']) : -1;

	if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
	}

	$start		= (!empty($_REQUEST["iDisplayStart"]))? $_REQUEST["iDisplayStart"] : 0;
	$limit		= (!empty($_REQUEST["iDisplayLength"]))? $_REQUEST["iDisplayLength"] : 20;

	$sortCol	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$sortDir	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$str		= (!empty($_REQUEST['sSearch']))? $_REQUEST['sSearch'] : '';

	$oCfgTabla = new StdClass;
	$oCfgTabla->start	= $start;
	$oCfgTabla->limit	= $limit;
	$oCfgTabla->sortCol	= $sortCol;
	$oCfgTabla->sortDir	= $sortDir;
	$oCfgTabla->str		= $str;

	$oCuenta = new CuentaBancariaContable();
	$oCuenta->setRBD($RBD);
	$oCuenta->setWBD($WBD);
	$oCuenta->setLOG($LOG);

	$oCuenta->setNIdBanco($nIdBanco);
	$oCuenta->setNNumCuentaBancaria($nNumCuentaBancaria);
	$oCuenta->setNNumCuentaContable($nNumCuentaContable);
	$oCuenta->setNIdEstatus($nIdEstatus);

	$arrData = $oCuenta->getListaCfg($oCfgTabla);

	$aaData = $arrData['data'];

	if(!$esEscritura){
		foreach($aaData as $key => $element){
			$element[3] = '-';
			$aaData[$key] = $element;
		}
	}

	$sqlcount	= $RBD->query("SELECT FOUND_ROWS() AS total");
	$res		= mysqli_fetch_assoc($sqlcount);
	$iTotal		= $res["total"];

	if($iTotal == 0){
		$aaData = array();
	}

	$output = array(
		"sEcho"					=> intval($_GET['sEcho']),
		"iTotalRecords"			=> $iTotal,
		"iTotalDisplayRecords"	=> $iTotal,
		"aaData"				=> $aaData,
		"errmsg"				=> ''
	);

	echo json_encode($output);
?>