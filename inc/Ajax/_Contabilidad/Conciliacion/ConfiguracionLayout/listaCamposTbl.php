<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$idOpcion = 195;

	$esEscritura = false;
	if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
	}

	$nIdCadena = !empty($_POST['nIdCadena'])? $_POST['nIdCadena'] : -1;

	$oCfgLayout = new ClienteCfgLayout();
	$oCfgLayout->setORdb($oRdb);
	$oCfgLayout->setNIdCadena($nIdCadena);

	$resultado = $oCfgLayout->cargarClienteCfgLayout();

	$array_campos_layout = array();

	if(!$resultado['bExito'] || $resultado['nCodigo'] != 0 || $resultado['found_rows'] == 0){
		echo json_encode($resultado);
		exit();
	}
	else{
		$array_campos_layout = utf8ize($resultado['data']);
	}

	echo json_encode(array(
		'bExito'		=> true,
		'sMensaje'		=> 'Ok',
		'esEscritura'	=> $esEscritura,
		'data'			=> $array_campos_layout
	));
?>