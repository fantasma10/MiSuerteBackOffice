<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdPoliza	= 0;
	$nIdUsuario = $_SESSION['idU'];

	$nIdCfg			= !empty($_POST["nIdCfg"])? $_POST['nIdCfg'] : '';
	$sFolio			= !empty($_POST["sFolio"])? $_POST['sFolio'] : '';
	$dFecha			= !empty($_POST["dFecha"])? $_POST['dFecha'] : '';
	$sConcepto		= !empty($_POST["sConcepto"])? $_POST['sConcepto'] : '';
	$array_movbanco	= !empty($_POST["nIdMovBanco"])? $_POST['nIdMovBanco'] : '';
	$sListaMovs		= implode(',', $array_movbanco);

	/*
		cargar el numero de la cuenta seleccionada
	*/
	$nIdBanco			= 0;
	$nNumCuentaBancaria	= '';
	$nNumCuentaContable	= '';
	$nIdEstatus			= -1;

	$start		= 0;
	$limit		= 1;
	$sortCol	= 0;
	$sortDir	= 0;
	$str		= '';

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

	$arrRes = $oCuenta->getListaCfg2($oCfgTabla);

	if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
		echo json_encode($arrRes);
		exit();
	}

	$nNumCuentaContableBanco = $arrRes['data'][0]['nNumCuentaContable'];

	/*
		Guardar datos de poliza y Generar Layout
	*/

	$oPolizaHeader = new PolizaHeader();
	$oPolizaHeader->setORdb($oRdb);
	$oPolizaHeader->setOWdb($oWdb);

	$oPolizaHeader->setSTipo('P');
	$oPolizaHeader->setDFecha($dFecha);
	$oPolizaHeader->setNIdTipoPoliza(1);
	$oPolizaHeader->setSFolio($sFolio);
	$oPolizaHeader->setNIdClase(1);
	$oPolizaHeader->setNIdDiario(0);
	$oPolizaHeader->setSConcepto($sConcepto);
	$oPolizaHeader->setNIdSistOrig(11);
	$oPolizaHeader->setNImpresa(0);
	$oPolizaHeader->setNAjuste(0);
	$oPolizaHeader->setNIdUsuario($nIdUsuario);

	$oPoliza = new Poliza();
	$oPoliza->setORdb($oRdb);
	$oPoliza->setOWdb($oWdb);
	$oPoliza->setSListaMovimientos($sListaMovs);
	$oPoliza->setOHeader($oPolizaHeader);
	$oPoliza->setNIdUsuario($nIdUsuario);
	$oPoliza->setOHeader($oPolizaHeader);
	$oPoliza->setNNumCuentaContableBanco($nNumCuentaContableBanco);

	$resultado = $oPoliza->buscaDatosPolizaDepositosNoIdentificados();

	if($resultado['nCodigo'] != 0 || $resultado['bExito'] == false){
		$resultado['sMensaje'] = 'No ha sido posible cargar los movimientos para la Poliza';
		echo json_encode($resultado);
		exit();
	}

	if(count($oPoliza->arrayMovimientos) > 0){
		$resultado = $oPoliza->guardar();

		if($resultado['nCodigo'] != 0 || $resultado['bExito'] == false){
			echo json_encode($resultado);
			exit();
		}

		$nIdPoliza = $resultado['data']['nIdPoliza'];

		$resultado['data'] = array(
			'nIdPoliza'	=> $nIdPoliza
		);

		$resultado['sMensaje'] = "Poliza Generada Correctamente";

		echo json_encode($resultado);
	}
	else{
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> 99,
			'sMensaje'	=> 'No se encontraron movimientos para la poliza'
		));
		exit();
	}

	$oRdb->closeConnection();
	$oWdb->closeConnection();
?>