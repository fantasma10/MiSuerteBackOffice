<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdUsuario = $_SESSION['idU'];
	$nIdCfg		= !empty($_POST['nIdCfg'])? trim($_POST['nIdCfg']) : 0;

	$oCuenta = new CuentaBancariaContable();
	$oCuenta->setRBD($RBD);
	$oCuenta->setWBD($WBD);
	$oCuenta->setLOG($LOG);

	$oCuenta->setNIdCfg($nIdCfg);

	$arrRes = $oCuenta->activarCfg();

	echo json_encode($arrRes);


?>