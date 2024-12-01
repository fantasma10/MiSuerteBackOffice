<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdUsuario 	= $_SESSION['idU'];
	$nIdDeposito	= !empty($_POST['nIdDeposito'])? trim($_POST['nIdDeposito']) : 0;

	$oDeposito = new Deposito();
	$oDeposito->setORdb($oRdb);
	$oDeposito->setOWdb($oWdb);

	$oDeposito->setIdDeposito($nIdDeposito);

	$arrRes = $oDeposito->eliminar();

	echo json_encode($arrRes);

	$oRdb->closeConnection();
	$oWdb->closeConnection();

?>