<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdEstatus		= !empty($_POST['nIdEstatus'])? $_POST['nIdEstatus'] : 1;
	$nIdProveedor	= !empty($_POST['nIdProveedor'])? $_POST['nIdProveedor'] : 0;

	$oCorteComision = new CorteComision();
	$oCorteComision->setORdb($MRDB);
	$oCorteComision->setOWdb($MWDB);

	$oCorteComision->setNIdEstatus($nIdEstatus);
	$oCorteComision->setNIdProveedor($nIdProveedor);

	$resultado = $oCorteComision->listaPendientes();

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		echo json_encode($resultado);
		exit();
	}

	$data	= $resultado['data'];
	$length	= count($data);
	//echo '<pre>'; var_dump($data); echo '</pre>';
	for($i=0; $i<$length;$i++){
		$data[$i]['nImporteComisionFormato'] = "$ ". number_format($data[$i]['nImporteComision'], 2, '.', ',');
	}

	$resultado['data'] = $data;

	echo json_encode($resultado);
?>