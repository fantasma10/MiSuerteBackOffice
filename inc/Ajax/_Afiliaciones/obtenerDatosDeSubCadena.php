<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$idSubCadena = (isset($_POST['idSubCadena']))? $_POST['idSubCadena'] : -1;

	$SUB = new SubCadena($RBD, $WBD);

	$res = $SUB->load($idSubCadena);

	$response = array();
	if($res['CodigoRespuesta'] == 0){
		$response['success'] = true;

		$response['data'] = array(
			'referenciaBancaria'	=> $SUB->getReferenciaBancaria()
		);
	}
	else{
		$response['success'] = false;
	}
	echo json_encode($response);
?>