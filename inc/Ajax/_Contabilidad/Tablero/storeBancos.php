<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$oBanco = new Banco();
	$oBanco->setRBD($RBD);

	$arrBancos = $oBanco->getListaBancos();

	echo json_encode($arrBancos);
?>