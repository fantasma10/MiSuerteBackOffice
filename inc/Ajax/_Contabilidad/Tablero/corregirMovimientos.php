<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	$nIdUsuario		= $_SESSION['idU'];
	$nIdMovBanco1	= (!empty($_POST['nIdMovBanco1']))? $_POST['nIdMovBanco1'] : 0;
	$nIdMovBanco2	= (!empty($_POST['nIdMovBanco2']))? $_POST['nIdMovBanco2'] : 0;

	$oBancoMov = new BancoMov();
	$oBancoMov->setORdb($oRdb);
	$oBancoMov->setOWdb($oWdb);
	$oBancoMov->setOLog($LOG);

	$oBancoMov->setNIdUsuario($nIdUsuario);
	$oBancoMov->setIdMovBanco($nIdMovBanco1);
	$oBancoMov->setIdMovBanco2($nIdMovBanco2);

	$resultado = $oBancoMov->corregir();

	echo json_encode($resultado);
?>