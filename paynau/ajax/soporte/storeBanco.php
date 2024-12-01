<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$oBanco = new C_Banco();
	$oBanco->setORdb($oRdb);

	$resultado = $oBanco->storeBanco();
	$resultado = utf8ize($resultado);

	echo json_encode($resultado);

?>