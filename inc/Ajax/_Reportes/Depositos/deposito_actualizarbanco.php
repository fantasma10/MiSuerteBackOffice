<?php

	include("../../../config.inc.php");
	include("../../../session.ajax.inc.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdDeposito	= !empty($_POST['nIdDeposito'])		? $_POST['nIdDeposito']		: 0;
	$nIdBanco		= !empty($_POST['nIdBanco'])		? $_POST['nIdBanco']		: 0;

	$oDeposito = new Deposito();
	$oWdb->setBDebug(1);
	$oDeposito->setORdb($oRdb);
	$oDeposito->setOWdb($oWdb);

	$oDeposito->setIdDeposito($nIdDeposito);
	$oDeposito->setIdBanco($nIdBanco);

	$arrRes = $oDeposito->corregirBanco();

	echo json_encode($arrRes);
?>