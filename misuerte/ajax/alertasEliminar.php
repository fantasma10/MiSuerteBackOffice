<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	$nIdNotificacion	= !empty($_POST['nIdNotificacion'])? $_POST['nIdNotificacion'] : 0;

	$oNotificacion = new Notificacion();
	$oNotificacion->setORdb($MRDB);
	$oNotificacion->setOWdb($MWDB);

	$oNotificacion->setNIdNotificacion($nIdNotificacion);

	$resultado = $oNotificacion->eliminar();


	echo json_encode($resultado);


?>