<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	$nIdUsuario = $_SESSION['idU'];

	$oWdb->setBDebug(1);

	$nIdBanco			= (!empty($_POST['nIdBanco']))? $_POST['nIdBanco'] : '';
	$nIdMovBanco		= (!empty($_POST['nIdMovBanco']))? $_POST['nIdMovBanco'] : '';
	$nAbono				= (!empty($_POST['nImporte']))? $_POST['nImporte'] : '';
	$nCargo				= 0;
	$nAutorizacion		= (!empty($_POST['nAutorizacion']))? $_POST['nAutorizacion'] : '';
	$dFecha				= (!empty($_POST['dFecha']))? $_POST['dFecha'] : '';
	$nNumCuentaContable	= (!empty($_POST['nNumCuentaContable']))? $_POST['nNumCuentaContable'] : '';
	$sDescripcion		= (!empty($_POST['sDescripcion']))? $_POST['sDescripcion'] : '';
	$sDescripcion		= utf8_decode($sDescripcion);
	$nIdTipoMov			= 7;

	/*
		Obtener el numero de cuenta de Forelo
	*/

	$oCuentaContable = new CuentaContableRE();
	$oCuentaContable->setORdb($oRdb);
	$oCuentaContable->setOWdb($oWdb);

	$oCuentaContable->setCtaContable($nNumCuentaContable);

	$arrRes = $oCuentaContable->obtenerCuentaForelo();

	if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
		echo json_encode($arrRes);
		exit();
	}

	if($arrRes['count'] <= 0){
		echo json_encode(array(
			'nCodigo'	=> 1,
			'bExito'	=> false,
			'sMensaje'	=> 'No se encuentra registrada la cuenta contable'
		));
		exit();
	}

	$nNumCuenta = $arrRes['data'][0]['numCuenta'];

	if(empty($nNumCuenta)){
		echo json_encode(array(
			'nCodigo'	=> 1,
			'bExito'	=> false,
			'sMensaje'	=> 'La cuenta contable no tiene una cuenta de forelo asociada'
		));
		exit();
	}

	/*
		Insertar el movimiento de cuenta de forelo
	*/
	$oMovimientoForelo = new MovimientoCuentaForelo();
	$oMovimientoForelo->setORdb($oRdb);
	$oMovimientoForelo->setOWdb($oWdb);

	$oMovimientoForelo->setNumCuenta($nNumCuenta);
	$oMovimientoForelo->setCargoMov($nCargo);
	$oMovimientoForelo->setAbonoMov($nAbono);
	$oMovimientoForelo->setDescMovimiento($sDescripcion);
	$oMovimientoForelo->setTipoMov($nIdTipoMov);
	$oMovimientoForelo->setIdEmpleado($nIdUsuario);
	$oMovimientoForelo->setNIdMovBanco($nIdMovBanco);

	$arrRes = $oMovimientoForelo->insertar();

	if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
		$arrRes['sMensaje'] = "No ha sido posible aplicar el movimiento";
		echo json_encode($arrRes);
		exit();
	}

	$data = $arrRes['data'];

	if($data[0]['CodigoRespuesta'] != 0){
		echo json_encode(array(
			'nCodigo'	=> $data[0]['CodigoRespuesta'],
			'sMensaje'	=> $data[0]['DescRespuesta'],
			'bExito'	=> false
		));
		exit();
	}

	echo json_encode($arrRes);

?>