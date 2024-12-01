<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdUsuario = $_SESSION['idU'];

	$sFolio			= !empty($_POST["sFolio"])? $_POST['sFolio'] : '';
	$dFecha			= !empty($_POST["dFecha"])? $_POST['dFecha'] : '';
	$sConcepto		= !empty($_POST["sConcepto"])? $_POST['sConcepto'] : '';
	$sFolio2		= !empty($_POST["sFolio2"])? $_POST['sFolio2'] : '';
	$dFecha2		= !empty($_POST["dFecha2"])? $_POST['dFecha2'] : '';
	$sConcepto2		= !empty($_POST["sConcepto2"])? $_POST['sConcepto2'] : '';
	$array_movbanco	= !empty($_POST["nIdMovBanco"])? $_POST['nIdMovBanco'] : '';

	$sListaMovs = implode(',', $array_movbanco);
	
	$nIdPoliza1 = 0;
	$nIdPoliza2 = 0;


	/*
		Validar si existe un proceso en curso
	*/
	$oPoliza = new Poliza();
	$oPoliza->setORdb($oRdb);
	$oPoliza->setOWdb($oWdb);

	$resultado = $oPoliza->verificaBandera();

	if($resultado['nCodigo'] != 0 || $resultado['bExito'] == false){
		$resultado['sMensaje'] = 'No ha sido posible continuar con el proceso';
		echo json_encode($resultado);
		exit();
	}

	$data = $resultado['data'][0];

	$result_code	= $data['result_code'];
	$result_msg		= $data['result_msg'];

	if($result_code != 0){
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> $result_code,
			'sMensaje'	=> $result_msg
		));
		exit();
	}

	/*
		Crear poliza de ingresos conciliados el mismo dia
	*/
	$oPolizaHeader = new PolizaHeader();
	$oPolizaHeader->setORdb($oRdb);
	$oPolizaHeader->setOWdb($oWdb);

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


	$oPoliza->setSListaMovimientos($sListaMovs);
	$oPoliza->setOHeader($oPolizaHeader);
	$oPoliza->setNIdUsuario($nIdUsuario);
	$oPoliza->setBMismoDia(1);

	$resultado = $oPoliza->buscaDatosPolizaIngresos();

	if($resultado['nCodigo'] != 0 || $resultado['bExito'] == false){
		liberarBandera();
		$resultado['sMensaje'] = 'No ha sido posible cargar los movimientos para la Poliza';
		echo json_encode($resultado);
		exit();
	}

	if(count($oPoliza->arrayMovimientos) > 0){
		$resultado = $oPoliza->guardar();

		if($resultado['nCodigo'] != 0 || $resultado['bExito'] == false){
			liberarBandera();
			echo json_encode($resultado);
			exit();
		}


		$nIdPoliza1 = $resultado['data']['nIdPoliza'];
	}
	else{
		liberarBandera();
		echo json_encode(array(
			'nCodigo'	=> 1,
			'bExito'	=> false,
			'sMensaje'	=> 'No se encontraron movimientos que hayan sido conciliados el mismo dia'
		));
		exit();
	}


	$resultado['data'] = array(
		'nIdPoliza1'	=> $nIdPoliza1
	);

	if($nIdPoliza1 == 0){
		$resultado['sMensaje'] = "No fue posible generar la Poliza";
	}
	if($nIdPoliza1 > 0){
		$resultado['sMensaje'] = "Poliza de Ingresos Generada Correctamente";
	}

	liberarBandera();

	echo json_encode($resultado);


	function liberarBandera(){
		global $oRdb;
		global $oWdb;

		$oPoliza = new Poliza();
		$oPoliza->setORdb($oRdb);
		$oPoliza->setOWdb($oWdb);
		$result = $oPoliza->liberaBandera();

		if($result['nCodigo'] != 0 || $result['bExito'] == false){
			$result['sMensaje'] = 'No ha sido posible continuar con el proceso';
			echo json_encode($result);
			exit();
		}
	}
?>