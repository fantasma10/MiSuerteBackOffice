<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
	include "../../../inc/PhpExcel/Classes/PhpExcel.php";

	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	if(!isset($_SESSION['rec'])){
		$_SESSION['rec'] = true;
	}

	$nIdUsuario = $_SESSION['idU'];
	$nIdPoliza = !empty($_POST['nIdPoliza'])? $_POST['nIdPoliza'] : 0;

	if($nIdPoliza == 0){
		exit();
	}

	$oPoliza = new PolizaMiSuerte();
	$oPoliza->setORdb($MRDB);
	$oPoliza->setOWdb($MWDB);

	$oPolizaHeader = new PolizaHeaderMiSuerte();
	$oPolizaHeader->setORdb($MRDB);
	$oPolizaHeader->setOWdb($MWDB);
	$oPolizaHeader->setNIdUsuario($nIdUsuario);

	$oPolizaMovimiento	= new PolizaMovimientoMiSuerte();
	$oPolizaMovimiento->setORdb($MRDB);
	$oPolizaMovimiento->setOWdb($MWDB);
	$oPolizaMovimiento->setNIdUsuario($nIdUsuario);

	$oPoliza->setNIdPoliza($nIdPoliza);
	$oPoliza->setOHeader($oPolizaHeader);
	$oPoliza->setOPolizaMovimiento($oPolizaMovimiento);

	$oPoliza->generarLayout();
?>