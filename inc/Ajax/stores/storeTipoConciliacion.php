<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	$datos		= array();
	$sMensaje	= '';
	$nCodigo	= 0;
	$bExito		= true;
	$data		= array();

	$oTipoConciliacion = new TipoConciliacion();
	$oTipoConciliacion->setORdb($oRdb);
	$resultado = $oTipoConciliacion->select_cat_tipo_conciliacion();

	if(!$resultado['bExito']){
		$sMensaje	= $resultado['sMensaje'];
		$bExito		= $resultado['bExito'];
		$nCodigo	= $resultado['nCodigo'];
	}
	else{
		$data		= $resultado['data'];
		$data		= utf8ize($data);
	}

	echo json_encode(array(
		'bExito'	=> $bExito,
		'nCodigo'	=> $nCodigo,
		'data' 		=> $data,
		'sMensaje'	=> $sMensaje
	));

?>