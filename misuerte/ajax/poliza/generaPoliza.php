<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	error_reporting(E_ALL);
	ini_set('display_error', 1);

	$nIdCorte	= !empty($_POST['nIdCorte'])? $_POST['nIdCorte'] : 0;
	$sFolio		= !empty($_POST['sFolio'])? $_POST['sFolio'] : '';
	$dFecha		= !empty($_POST['dFecha'])? $_POST['dFecha'] : '0000-00-00';
	$sConcepto	= !empty($_POST['sConcepto'])? trim($_POST['sConcepto']) : '';
	$nIdUsuario	= $_SESSION['idU'];

	$sConcepto = utf8_decode($sConcepto);

	$oPolizaHeader = new PolizaHeaderMiSuerte();
	$oPolizaHeader->setORdb($MRDB);
	$oPolizaHeader->setOWdb($MWDB);

	$oPolizaHeader->setSTipo('P');
	$oPolizaHeader->setDFecha($dFecha);
	$oPolizaHeader->setNIdTipoPoliza(1);
	$oPolizaHeader->setSFolio($sFolio);
	$oPolizaHeader->setNIdClase(1);
	$oPolizaHeader->setNIdDiario(0);
	$oPolizaHeader->setSConcepto($sConcepto);
	$oPolizaHeader->setNIdSistOrig(11);
	$oPolizaHeader->setNImpresa(0);
	$oPolizaHeader->setNAjuste(0);
	$oPolizaHeader->setNIdUsuario($nIdUsuario);

	$oPoliza = new PolizaMiSuerte();
	$oPoliza->setORdb($MRDB);
	$oPoliza->setOWdb($MWDB);
	$oPoliza->setNIdCorte($nIdCorte);
	$oPoliza->setOHeader($oPolizaHeader);
	$oPoliza->setNIdUsuario($nIdUsuario);
	$oPoliza->setBMismoDia(0);

	$resultado = $oPoliza->buscaDatosPolizaIngresos();

	if($resultado['nCodigo'] != 0 || $resultado['bExito'] == false){
		$resultado['sMensaje'] = 'No ha sido posible cargar los movimientos para la Poliza';
		echo json_encode($resultado);
		exit();
	}

	if(count($oPoliza->arrayMovimientos) > 0){
		$resultado = $oPoliza->guardar();

		if($resultado['nCodigo'] != 0 || $resultado['bExito'] == false){
			echo json_encode($resultado);
			exit();
		}

		$nIdPoliza = $resultado['data']['nIdPoliza'];
	}

	$MRDB->closeConnection();
	$MWDB->closeConnection();

	$resultado['data'] = array(
		'nIdPoliza'	=> $nIdPoliza
	);

	$resultado['sMensaje'] = "Poliza Generada Correctamente";

	echo json_encode($resultado);
?>