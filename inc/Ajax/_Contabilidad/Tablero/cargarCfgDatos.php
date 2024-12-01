<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdUsuario = $_SESSION['idU'];
	$nIdCfg		= !empty($_POST['nIdCfg'])? trim($_POST['nIdCfg']) : 0;

	$nIdBanco			= !empty($_POST['nIdBanco'])? trim($_POST['nIdBanco']) : 0;
	$nNumCuentaBancaria	= !empty($_POST['nNumCuentaBancaria'])? trim($_POST['nNumCuentaBancaria']) : '';
	$nNumCuentaContable	= !empty($_POST['nNumCuentaContable'])? trim($_POST['nNumCuentaContable']) : '';
	$nIdEstatus			= isset($_POST['nIdEstatus']) && $_POST['nIdEstatus'] >= 0? trim($_POST['nIdEstatus']) : -1;

	$start		= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"] : 0;
	$limit		= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 20;

	$sortCol	= (isset($_POST['iSortCol_0']) AND $_POST['iSortCol_0'] > -1)? $_POST['iSortCol_0'] : 0;
	$sortDir	= (!empty($_POST['sSortDir_0']))? $_POST['sSortDir_0'] : 0;
	$str		= (!empty($_POST['sSearch']))? $_POST['sSearch'] : '';

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

	$oCuenta->setNIdCfg($nIdCfg);

	$oCuenta->setNIdBanco($nIdBanco);
	$oCuenta->setNNumCuentaBancaria($nNumCuentaBancaria);
	$oCuenta->setNNumCuentaContable($nNumCuentaContable);
	$oCuenta->setNIdEstatus($nIdEstatus);

	$arrRes = $oCuenta->getListaCfg2($oCfgTabla);

	echo json_encode($arrRes);


?>