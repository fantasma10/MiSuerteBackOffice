<?php

	include("../../../config.inc.php");
	include("../../../customFunctions.php");
	include("../../../session.ajax.inc.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nNumCuenta			= !empty($_POST['nNumCuenta'])		? $_POST['nNumCuenta']		: '';
	$dFechaInicio		= !empty($_POST['dFechaInicio'])	? $_POST['dFechaInicio']	: date('Y-m-d');
	$dFechaFinal		= !empty($_POST['dFechaFinal'])		? $_POST['dFechaFinal']		: date('Y-m-d');
	$nIdBanco			= !empty($_POST['nIdBanco'])		? $_POST['nIdBanco']		: 2;
	$start				= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"] : 0;
	$limit				= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 20;



	$oCargoAdm = new CargoAdministrativo();
	$oCargoAdm->setORdb($oRdb);
	$oCargoAdm->setOWdb($oWdb);

	$oCargoAdm->setDFechaInicio($dFechaInicio);
	$oCargoAdm->setDFechaFinal($dFechaFinal);
	$oCargoAdm->setNNumCuenta($nNumCuenta);

	$resultado = $oCargoAdm->obtenerCargosAbonoMenor($start, $limit);

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0 || $resultado['num_rows'] == 0){
		$aaData = array();
		$iTotal = 0;
	}
	else{
		$aaData = $resultado['data'];

		foreach($aaData as $key => $row){
			$row['nCargoFormato']			= number_format($row['nCargo'], '2');
			$row['nSaldoInicialFormato']	= number_format($row['saldoInicial'], '2');
			$row['nSaldoFinalFormato']		= number_format($row['saldoFinal'], '2');
			$row['nSaldoCuentaFormato']		= number_format($row['nSaldoCuenta'], '2');
			$row['sNombreCuenta']			= utf8ize($row['sNombreCuenta']);
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