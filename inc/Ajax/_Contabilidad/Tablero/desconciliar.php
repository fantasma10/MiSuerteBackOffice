<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	$nIdUsuario		= $_SESSION['idU'];
	$nIdMovBanco	= (!empty($_POST['nIdMovBanco']))? $_POST['nIdMovBanco'] : 0;

	$oConciliacion = new Conciliacion();
	$oConciliacion->setORdb($oRdb);
	$oConciliacion->setOWdb($oWdb);
	$oConciliacion->setOLog($LOG);

	$oConciliacion->setNIdMovBanco($nIdMovBanco);
	$oConciliacion->setNIdUsuario($nIdUsuario);
	$resultado = $oConciliacion->desconciliar();

	echo json_encode($resultado);
?>