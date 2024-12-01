<?php

	include("../../../config.inc.php");
	include("../../../session.ajax.inc.php");
	include("../../../customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdUsuario		= $_SESSION['idU'];
	$nIdMovimiento	= !empty($_POST['nIdMovimiento'])	? $_POST['nIdMovimiento']	: 0;
	$arrMovBanco	= !empty($_POST['arrMovBanco'])		? $_POST['arrMovBanco']		: 0;
	$nIdTipoCobro	= !empty($_POST['nIdTipoCobro'])	? $_POST['nIdTipoCobro']	: 0;
	$nNumCuenta		= !empty($_POST['nNumCuenta'])		? $_POST['nNumCuenta']		: 0;

	if($nIdTipoCobro == 2){

		$sListaBancoMovs = implode(',', $arrMovBanco);
		$array_params = array(
			array(
				'name'	=> 'nIdMovimiento',
				'value'	=> $nIdMovimiento,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nNumCuenta',
				'value'	=> $nNumCuenta,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sListaBancoMovs',
				'value'	=> $sListaBancoMovs,
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

		$arrRes = $oCredito->cobrarABanco($array_params);

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
			exit();
		}

		echo json_encode($arrRes);
	}
	else{
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> 1,
			'sMensaje'	=> 'Este Credito no se Cobra con Deposito de Banco'
		));
	}

?>