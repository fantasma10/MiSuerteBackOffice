<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
	require($_SERVER['DOCUMENT_ROOT']."/inc/lib/phpmailer/class.phpmailer.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdCliente = (!empty($_POST['nIdCliente']))? trim($_POST['nIdCliente']) : 0;

	$array_params = array(
		array(
			'name'	=> 'nIdCadena',
			'type'	=> 'i',
			'value'	=> -1
		),
		array(
			'name'	=> 'nIdSubCadena',
			'type'	=> 'i',
			'value'	=> $nIdCliente
		),
		array(
			'name'	=> 'nIdCorresponsal',
			'type'	=> 'i',
			'value'	=> -1
		)
	);

	$oRdb->setSDatabase('redefectiva');
	$oRdb->setSStoredProcedure('sp_select_corresponsal');
	$oRdb->setParams($array_params);
	$arrRes = $oRdb->execute();

	if($arrRes['nCodigo'] != 0 || $arrRes['bExito'] == false){
		$arrRes['sMensaje']	= 'No se pudo cargar la informacion';
		echo json_encode($arrRes);
		exit();
	}

	$data = $oRdb->fetchAll();

	$data = utf8ize($data);

	echo json_encode(array(
		'nCodigo'	=> 0,
		'bExito'	=> true,
		'sMensaje'	=> 'Datos Ok',
		'data'		=> $data
	));

?>