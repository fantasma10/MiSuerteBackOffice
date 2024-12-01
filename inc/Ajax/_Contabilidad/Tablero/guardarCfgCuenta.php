<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	$nIdUsuario = $_SESSION['idU'];

	$nIdCfg					= !empty($_POST['nIdCfg'])? trim($_POST['nIdCfg']) : 0;
	$nIdBanco				= !empty($_POST['nIdBanco'])? trim($_POST['nIdBanco']) : 0;
	$nNumCuentaBancaria		= !empty($_POST['nNumCuentaBancaria'])? $_POST['nNumCuentaBancaria'] : 0;
	$nNumCuentaContable		= !empty($_POST['nNumCuentaContable'])? $_POST['nNumCuentaContable'] : 0;
	$nIdTipoOperacion		= !empty($_POST['nIdTipoOperacion'])? $_POST['nIdTipoOperacion'] : 0;

	if($nIdBanco == '' || $nIdBanco <= 0){
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> 101,
			'sMensaje'	=> 'Seleccione Banco'
		));
	}

	if($nNumCuentaBancaria == '' || $nNumCuentaBancaria <= 0){
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> 101,
			'sMensaje'	=> 'Capture Cuenta Bancaria'
		));
	}

	if($nNumCuentaContable == '' || $nNumCuentaContable <= 0){
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> 101,
			'sMensaje'	=> 'Capture Cuenta Contable'
		));
	}

	if($nNumCuentaBancaria == '' || $nNumCuentaBancaria <= 0){
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> 101,
			'sMensaje'	=> 'Capture Cuenta Contable'
		));
	}

	$oCuenta = new CuentaBancariaContable();
	$oCuenta->setOWdb($oWdb);
	$oCuenta->setLOG($LOG);
	$oCuenta->setNIdUsuario($nIdUsuario);

	$oCuenta->setNIdCfg($nIdCfg);
	$oCuenta->setNIdBanco($nIdBanco);
	$oCuenta->setNNumCuentaBancaria($nNumCuentaBancaria);
	$oCuenta->setNNumCuentaContable($nNumCuentaContable);
	$oCuenta->setNIdTipoOperacion($nIdTipoOperacion);
	$oCuenta->setNIdUnidadNegocio(2);


	if($nIdCfg <= 0){
		$arrRes = $oCuenta->guardarCfgCuenta();
	}
	else{
		$arrRes = $oCuenta->actualizarCfgCuenta();
	}

	echo json_encode($arrRes);
?>