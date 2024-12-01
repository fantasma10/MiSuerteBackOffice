<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdMetodoPago			= !empty($_POST['nIdMetodoPago'])? $_POST['nIdMetodoPago'] : 0;
	$nIdMetodo			= !empty($_POST['nIdMetodo'])? $_POST['nIdMetodo'] : 0;
	$nIdEstatus				= !empty($_POST['nIdEstatus'])? $_POST['nIdEstatus'] : 0;
	$sNombre				= !empty($_POST['sNombre'])? utf8_decode($_POST['sNombre']) : '';
	$nImporteCosto			= !empty($_POST['nImporteCosto'])? $_POST['nImporteCosto'] : 0;
	$nPorcentajeCosto		= !empty($_POST['nPorcentajeCosto'])? $_POST['nPorcentajeCosto'] : 0;
	$nImporteCostoAdicional	= !empty($_POST['nImporteCostoAdicional'])? $_POST['nImporteCostoAdicional'] : 0;
	$nPorcentajeIVA			= !empty($_POST['nPorcentajeIVA'])? $_POST['nPorcentajeIVA'] : 0;
	$bIndirecta				= !empty($_POST['bIndirecta'])? $_POST['bIndirecta'] : 0;
	$array_diasPago			= !empty($_POST['array_diasPago'])? $_POST['array_diasPago'] : 0;

	$sNombre = trim($sNombre);

	$nIdUsuario = $_SESSION['idU'];

	$oDiasPago	= new DiasPago();

	$oMetodoPago = new MetodoPago();
	$oMetodoPago->setORdb($MRDB);
	$oMetodoPago->setOWdb($MWDB);
	$oMetodoPago->setODiasPago($oDiasPago);

	$oMetodoPago->setNIdMetodoPago($nIdMetodoPago);
	$oMetodoPago->setNIdMetodo($nIdMetodo);
	$oMetodoPago->setNIdEstatus($nIdEstatus);
	$oMetodoPago->setSNombre($sNombre);
	$oMetodoPago->setNImporteCosto($nImporteCosto);
	$oMetodoPago->setNPorcentajeCosto($nPorcentajeCosto);
	$oMetodoPago->setNImporteCostoAdicional($nImporteCostoAdicional);
	$oMetodoPago->setNPorcentajeIVA($nPorcentajeIVA);
	$oMetodoPago->setBIndirecta($bIndirecta);
	$oMetodoPago->setArray_DiasPago($array_diasPago);
	$oMetodoPago->setNIdUsuario($nIdUsuario);

	if($nIdMetodoPago == 0){
		$resultado = $oMetodoPago->guardar();
	}
	else{
		$resultado = $oMetodoPago->actualizar();
	}

	echo json_encode($resultado);

?>