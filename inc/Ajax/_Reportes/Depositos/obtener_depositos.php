<?php

	include("../../../config.inc.php");
	include("../../../session.ajax.inc.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nNumCuenta			= !empty($_POST['nNumCuenta'])		? $_POST['nNumCuenta']		: '';
	$dFechaInicio		= !empty($_POST['dFechaInicio'])	? $_POST['dFechaInicio']	: date('Y-m-d');
	$dFechaFinal		= !empty($_POST['dFechaFinal'])		? $_POST['dFechaFinal']		: date('Y-m-d');
	$nIdBanco			= !empty($_POST['nIdBanco'])		? $_POST['nIdBanco']		: 2;
	$start				= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"] : 0;
	$limit				= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 20;



	$oDeposito = new Deposito();
	$oRdb->setBDebug(1);
	$oDeposito->setORdb($oRdb);
	$oDeposito->setOWdb($oWdb);

	$oDeposito->setIdBanco($nIdBanco);
	$oDeposito->setIdDeposito(0);
	$oDeposito->setDFechaInicio($dFechaInicio);
	$oDeposito->setDFechaFinal($dFechaFinal);
	$oDeposito->setIdEstatus(1);
	$oDeposito->setNumCuenta($nNumCuenta);

	$resultado = $oDeposito->consultarError('bancomer', $start, $limit);

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0 || $resultado['num_rows'] == 0){
		$aaData = array();
		$iTotal = 0;
	}
	else{
		$aaData = $resultado['data'];

		foreach($aaData as $key => $row){
			$row['importeFormato']	= number_format($row['importe'], '2');
			$aaData[$key]			= $row;
		}

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