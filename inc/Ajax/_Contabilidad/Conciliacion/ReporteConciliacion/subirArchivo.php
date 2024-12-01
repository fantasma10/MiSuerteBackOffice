<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	error_reporting(E_ALL);
	ini_set("display_errors", 1);


	if(empty($_FILES)){
		echo json_encode(array(
			'bExito'	=> false,
			'sMensaje'	=> 'No se recibio archivo'
		));
		exit();
	}

	$nIdCorte				= !empty($_POST['nIdCorte'])			? $_POST['nIdCorte']				: 0;
	$nIdNivelConciliacion	= !empty($_POST['nIdNivelConciliacion'])? $_POST['nIdNivelConciliacion']	: 0;
	$sFile					= $_FILES['sFile'];

	#echo '<pre>'; var_dump($sFile); echo '</pre>';

	$Path	= $sFile['tmp_name'];
	$sName	= $sFile['name'];

	$Archivo = new ConciliacionArchivoResumen();
	$Archivo->setPath($Path);
	$Archivo->setFichero();
	$Archivo->setORdb($oRdb);
	$Archivo->setOWdb($oWdb);
	$Archivo->setNIdNivelConciliacion($nIdNivelConciliacion);
	$Archivo->setNIdCorte($nIdCorte);
	$Archivo->setSNombre($sName);
	$resultado = $Archivo->conciliar();

	echo json_encode($resultado);

?>