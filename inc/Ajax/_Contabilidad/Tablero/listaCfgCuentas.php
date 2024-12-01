<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdUsuario = $_SESSION['idU'];

	$nIdBanco			= !empty($_POST['nIdBanco'])? trim($_POST['nIdBanco']) : 0;
	$nIdCfg				= 0;
	$nNumCuentaBancaria	= '';
	$nNumCuentaContable	= '';
	$nIdEstatus			= 0;
	$start				= 0;
	$limit				= 1000;
	$sortCol			= 0;
	$sortDir			= 'ASC';
	$str				= '';

	$oCfgTabla = new StdClass;
	$oCfgTabla->start	= $start;
	$oCfgTabla->limit	= $limit;
	$oCfgTabla->sortCol	= $sortCol;
	$oCfgTabla->sortDir	= $sortDir;
	$oCfgTabla->str		= $str;

	$oCuenta = new CuentaBancariaContable();
	$oCuenta->setORdb($oRdb);
	$oCuenta->setOWdb($oWdb);
	$oCuenta->setLOG($LOG);

	$oCuenta->setNIdCfg($nIdCfg);

	$oCuenta->setNIdBanco($nIdBanco);
	$oCuenta->setNNumCuentaBancaria($nNumCuentaBancaria);
	$oCuenta->setNNumCuentaContable($nNumCuentaContable);
	$oCuenta->setNIdEstatus($nIdEstatus);
	$oCuenta->setNIdUnidadNegocio(2);

	$arrRes = $oCuenta->getListaCfg2($oCfgTabla);

	echo json_encode($arrRes);


?>