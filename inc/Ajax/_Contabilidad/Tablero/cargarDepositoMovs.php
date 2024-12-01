<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	include "../../../PhpExcel/Classes/PhpExcel.php";

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdCfg				= !empty($_POST['nIdCfg']) && $_POST['nIdCfg'] > 0? $_POST['nIdCfg'] : 0;
	$nIdDeposito		= !empty($_POST['nIdDeposito']) && $_POST['nIdDeposito'] > 0? $_POST['nIdDeposito'] : 0;
	$dFechaInicio		= !empty($_POST['dFechaInicio'])? $_POST['dFechaInicio'] : '0000-00-00';
	$dFechaFinal		= !empty($_POST['dFechaFinal'])? $_POST['dFechaFinal'] : '0000-00-00';
	$nArrayListaEstatus	= !empty($_POST['nArrayListaEstatusD'])? $_POST['nArrayListaEstatusD'] : array();
	$nNumAutorizacion	= !empty($_POST['nNumAutorizacion'])? $_POST['nNumAutorizacion'] : '';

	$sListaEstatus = implode(",", $nArrayListaEstatus);

	$oCfgTabla = new StdClass;
	$oCfgTabla->start	= 0;
	$oCfgTabla->limit	= 1;
	$oCfgTabla->sortCol	= 0;
	$oCfgTabla->sortDir	= 'ASC';
	$oCfgTabla->str		= '';

	$nNumCuentaBancaria = '';
	$nIdBanco			= 0;

	if($nIdCfg > 0){
		$oCuenta = new CuentaBancariaContable();
		$oCuenta->setoRdb($oRdb);
		$oCuenta->setoWdb($oWdb);
		$oCuenta->setLOG($LOG);

		$oCuenta->setNIdCfg($nIdCfg);

		$oCuenta->setNIdBanco(0);
		$oCuenta->setNNumCuentaBancaria('');
		$oCuenta->setNNumCuentaContable('');
		$oCuenta->setNIdEstatus(-1);

		$arrRes = $oCuenta->getListaCfg2($oCfgTabla);

		$nNumCuentaBancaria = $arrRes['data'][0]['nNumCuentaBancaria'];
		$nIdBanco			= $arrRes['data'][0]['nIdBanco'];
	}

	$oDeposito = new Deposito();
	$oDeposito->setORdb($oRdb);
	$oDeposito->oRdb->setBDebug(1);
	$oDeposito->setOWdb($oWdb);
	$oDeposito->setOLog($LOG);
	$oDeposito->setNumCuenta('');
	$oDeposito->setIdDeposito($nIdDeposito);
	$oDeposito->setIdBanco($nIdBanco);
	$oDeposito->setIdEstatus($sListaEstatus);
	$oDeposito->setDFechaInicio($dFechaInicio);
	$oDeposito->setDFechaFinal($dFechaFinal);

	$arrRes = $oDeposito->consultar();

	if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
		echo json_encode($arrRes);
		exit();
	}

	$data = $arrRes['data'];
	foreach($data AS $key => $row){
		$data[$key]['importeFormato'] = "$ ".number_format($row['importe'], 2, '.', ',');
	}

	$arrRes['data'] = utf8ize($data);

	$nTotal = count($arrRes['data']);

	echo json_encode($arrRes);
?>