<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	include "../../../PhpExcel/Classes/PhpExcel.php";

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdCfg				= !empty($_POST['nIdCfg']) && $_POST['nIdCfg'] > 0? $_POST['nIdCfg'] : 0;
	$nPerfil			= !empty($_POST['nPerfil']) && $_POST['nPerfil'] > 0? $_POST['nPerfil'] : 0;
	$dFechaInicio		= !empty($_POST['dFechaInicio'])? $_POST['dFechaInicio'] : '0000-00-00';
	$dFechaFinal		= !empty($_POST['dFechaFinal'])? $_POST['dFechaFinal'] : '0000-00-00';
	$nArrayListaEstatus	= !empty($_POST['nArrayListaEstatus'])? $_POST['nArrayListaEstatus'] : array();
	$nNumAutorizacion	= !empty($_POST['nNumAutorizacion'])? $_POST['nNumAutorizacion'] : '';
	$dFechaFiltro		= !empty($_POST['dFechaFiltro'])? $_POST['dFechaFiltro'] : '';

	$sListaEstatus = implode(",", $nArrayListaEstatus);

	$snIdPerfil	= $_SESSION['idPerfil'];

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


	$oBancoMov = new BancoMov();
	$oBancoMov->setORdb($oRdb);
	$oBancoMov->setOWdb($oWdb);
	$oBancoMov->setOLog($LOG);
	$oBancoMov->setCuenta($nNumCuentaBancaria);
	$oBancoMov->setIdBanco($nIdBanco);
	$oBancoMov->setIdEstatus($sListaEstatus);
	$oBancoMov->setAutorizacion($nNumAutorizacion);
	$oBancoMov->setDFechaInicio($dFechaInicio);
	$oBancoMov->setDFechaFinal($dFechaFinal);
	$oBancoMov->setDFechaFiltro($dFechaFiltro);
	$oBancoMov->setNPerfil($nPerfil);

	$arrRes = $oBancoMov->consultar();

	if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
		echo json_encode($arrRes);
		exit();
	}

	$data = $arrRes['data'];

	foreach($data AS $key => $row){
		$data[$key]['nAbonoFormato'] = "$ ".number_format($row['nAbono'], 2, '.', ',');

		$data[$key]['nCargoFormato'] = "$ 0";
		if($data[$key]['nCargo'] != '' && $data[$key]['nCargo'] != '0.0000'){
			$data[$key]['nCargoFormato'] = "$ ".number_format($row['importe'], 2, '.', ',');
		}


		$data[$key]['bAutorizar'] = ($snIdPerfil == $nIdPerfilAutorizaBanco)? true : false;
		//$data[$key]['bAutorizar'] = ($snIdPerfil == 1)? true : false; //para que funcione en local

	}

	$arrRes['data'] = utf8ize($data);

	$nTotal = count($arrRes['data']);
	$arrRes['nTotal'] = $nTotal;
	echo json_encode($arrRes);
?>