<?php

	include("../../../config.inc.php");
	include("../../../session.ajax.inc.php");
	include("../../../customFunctions.php");

	$nAbono			= !empty($_POST['nAbono'])			? $_POST['nAbono']			: 0;
	$nIdMovimiento	= !empty($_POST['nIdMovimiento'])	? $_POST['nIdMovimiento']	: 0;
	$nIdTipoCobro	= !empty($_POST['nIdTipoCobro'])	? $_POST['nIdTipoCobro']	: 0;
	$nNumCuenta		= !empty($_POST['numCuenta'])		? $_POST['numCuenta']		: 0;
	$sDescripcion	= !empty($_POST['sDescripcion'])	? $_POST['sDescripcion']	: 0;

	$sDescripcion	= "Pago de Credito (".$nIdMovimiento.")";

	if($nIdTipoCobro == 1){
		$array_params = array(
			array(
				'name'	=> 'nIdMovimiento',
				'value'	=> $nIdMovimiento,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nMonto',
				'value'	=> $nAbono,
				'type'	=> 'd'
			),
			array(
				'name'	=> 'nNumCuenta',
				'value'	=> $nNumCuenta,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sDescripcion',
				'value'	=> utf8_decode($sDescripcion),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nIdUsuario',
				'value'	=> $_SESSION['idU'],
				'type'	=> 'i'
			)
		);

		$oCredito = new CreditoForelo();
		$oCredito->setORdb($oRdb);
		$oCredito->setOWdb($oWdb);

		$arrRes = $oCredito->cobrarAForelo($array_params);

		if($arrRes['bExito'] == false){
			echo json_encode($arrRes);
			exit();
		}

		$data = $arrRes['data'][0];

		if($data['nCodigo'] != 0){
			echo json_encode(array(
				'bExito'	=> false,
				'nCodigo'	=> $data['nCodigo'],
				'sMensaje'	=> $data['sMensaje']
			));
		}

		echo json_encode($arrRes);
	}
	else{
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> 1,
			'sMensaje'	=> 'Este Credito no se Cobra con Cargo a Forelo'
		));
	}

?>