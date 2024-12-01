<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	$nIdNotificacion	= !empty($_POST['nIdNotificacion'])? $_POST['nIdNotificacion'] : 0;
	$nIdArea			= !empty($_POST['nIdArea'])? $_POST['nIdArea'] : 0;
	$sCorreo			= !empty($_POST['sCorreo'])? trim($_POST['sCorreo']) : 0;
	$nIdUsuario			= $_SESSION['idU'];

	$oNotificacion = new Notificacion();
	$oNotificacion->setORdb($MRDB);
	$oNotificacion->setOWdb($MWDB);

	$oNotificacion->setNIdNotificacion($nIdNotificacion);
	$oNotificacion->setNIdArea($nIdArea);
	$oNotificacion->setSCorreo($sCorreo);
	$oNotificacion->setNIdUsuario($nIdUsuario);

	if($nIdNotificacion == 0){
		$resultado = $oNotificacion->guardar();
	}
	else{
		$resultado = $oNotificacion->actualizar();
	}

	echo json_encode($resultado);

?>