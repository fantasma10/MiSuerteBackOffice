<?php

	include("../../../config.inc.php");
	include("../../../session.ajax.inc.php");
	include("../../../customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$TIPOCREDITO = 11;

	$nIdUsuario			= $_SESSION['idU'];
	$nNumCuenta			= !empty($_POST['nNumCuenta'])			? $_POST['nNumCuenta']			: '';
	$tipo				= !empty($_POST['tipo'])				? $_POST['tipo']				: '';
	$nIdTipo			= !empty($_POST['nIdTipo'])				? $_POST['nIdTipo']				: '';
	$nMonto				= !empty($_POST['nMonto'])				? $_POST['nMonto']				: '';
	$nIdTipoMovimiento	= !empty($_POST['nIdTipoMovimiento'])	? $_POST['nIdTipoMovimiento']	: '';
	$sDescripcion		= !empty($_POST['sDescripcion'])		? $_POST['sDescripcion']		: '';
	$dFechaCobro		= !empty($_POST['dFechaCobro'])			? $_POST['dFechaCobro']			: '';
	$nIdTipoCobro		= !empty($_POST['nIdTipoCobro'])		? $_POST['nIdTipoCobro']		: '';

	$sDescripcion		= utf8_decode($sDescripcion);

	$oMovimiento = new MovimientoCuentaForelo();
	$oMovimiento->setORdb($oRdb);
	$oMovimiento->setOWdb($oWdb);

	$oWdb->setBDebug(1);

	$oMovimiento->setNumCuenta($nNumCuenta);
	if($tipo == 1){
		$oMovimiento->setCargoMov($nMonto);
		$oMovimiento->setAbonoMov(0);
	}
	else if($tipo == 2){
		$oMovimiento->setCargoMov(0);
		$oMovimiento->setAbonoMov($nMonto);
	}

	$oMovimiento->setDescMovimiento($sDescripcion);
	$oMovimiento->setTipoMov($nIdTipoMovimiento);
	$oMovimiento->setIdUsuario($nIdUsuario);

	$arrRes = $oMovimiento->insertarMovimiento();

	if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
		echo json_encode($arrRes);
		exit();
	}

	$data = $arrRes['data'][0];

	if($data['CodigoRespuesta'] != 0){
		echo json_encode(array(
			'bExito'	=> false,
			'sMensaje'	=> $data['DescRespuesta'],
			'nCodigo'	=> $data['CodigoRespuesta']
		));
		exit();
	}

	$nIdMovimiento = $data['Folio'];

	if($tipo == 2 && $nIdTipoMovimiento == $TIPOCREDITO){
		if(empty($nIdMovimiento) || $nIdMovimiento <= 0){
			echo json_encode(array(
				'bExito'	=> false,
				'sMensaje'	=> 'No ha sido posible aplicar el movimiento',
				'nCodigo'	=> 2
			));
		}

		$oCredito = new CreditoForelo();
		$oCredito->setORdb($oRdb);
		$oCredito->setOWdb($oWdb);

		$oCredito->setNIdMovimiento($nIdMovimiento);
		$oCredito->setNIdTipoCobro($nIdTipoCobro);
		$oCredito->setDFecCobro($dFechaCobro);
		$oCredito->setNIdUsuario($nIdUsuario);

		$arrRes = $oCredito->insertarCredito();

		if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
			echo json_encode($arrRes);
			exit();
		}
	}

	echo json_encode(array(
		'bExito'	=> true,
		'nCodigo'	=> 0,
		'sMensaje'	=> 'Movimiento Aplicado Correctamente'
	));

?>