<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$idOpcion		= 121;
	$tipoDePagina	= "Mixto";
	$esEscritura	= false;

	if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
	}

	$oCuenta = new CuentaBancariaContable();
	$oCuenta->setRBD($RBD);
	$oCuenta->setWBD($WBD);
	$oCuenta->setLOG($LOG);
	$oCuenta->setNIdEstatus(0);

	$arrData = $oCuenta->obtenerListaCfgEstadoCuenta();

	echo json_encode($arrData);
?>