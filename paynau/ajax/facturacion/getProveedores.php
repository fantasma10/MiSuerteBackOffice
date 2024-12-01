<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/paynau/lib/modelo/*");
include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$nIdProveedor = !empty($_POST['nIdProveedor']) ? $_POST['nIdProveedor']: 0 ;

		
	$oProveedor = new Dat_Proveedor();

	$oProveedor->setORdb($oRdb);
	$oProveedor->setOWdb($oWdb);
	if ($nIdProveedor != 0) {
		$oProveedor->setNIdProveedor($nIdProveedor);
		$arrResult = $oProveedor->select_empresas();		
	}
	else{
		$arrResult = $oProveedor->select_proveedores();
	}
	

	if(!$arrResult['bExito']){
		echo json_encode($arrResult);
		exit();
	}
	else{
		$data		= $arrResult['data'];
		$data		= utf8ize($data);
	}

	echo json_encode(array(
		'bExito'	=> true,
		'nCodigo'	=> 0,
		'data' 		=> $data,
		'sMensaje'	=> 'ok'
	));
?>