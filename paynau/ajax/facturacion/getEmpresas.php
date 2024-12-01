<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");


$nIdUnidadNegocio = !empty($_POST['nIdUnidadNegocio']) ? $_POST['nIdUnidadNegocio']: 0 ;

	$oProveedor = new Dat_Unidad_Negocio();

	$oProveedor->setORdb($oRdb);
	$oProveedor->setOWdb($oWdb);

	if ($nIdUnidadNegocio != 0) {
		$oProveedor->setNIdUnidadNegocio($nIdUnidadNegocio);
		$arrResult = $oProveedor->select_empresas_facturacion();
	}else{
		$oProveedor->setNIdUnidadNegocio($nIdUnidadNegocio);				
		$arrResult = $oProveedor->select_unidad_negocio();
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