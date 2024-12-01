<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdCliente = !empty($_POST['nIdCliente'])? $_POST['nIdCliente'] : 0;

	$oMonitor = new MonitorMiSuerte();
	$oMonitor->setORdb($MRDB);
	$oMonitor->setOWdb($MWDB);

	$oMonitor->setNIdCliente($nIdCliente);

	/*
		Obtener datos del día actual
	*/
	$resultado = $oMonitor->obtenerMonitor();

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		return $resultado;
	}

	$array_horas = array(
		'00'	=> 0,
		'01'	=> 0,
		'02'	=> 0,
		'03'	=> 0,
		'04'	=> 0,
		'05'	=> 0,
		'06'	=> 0,
		'07'	=> 0,
		'08'	=> 0,
		'09'	=> 0,
		'10'	=> 0,
		'11'	=> 0,
		'12'	=> 0,
		'13'	=> 0,
		'14'	=> 0,
		'15'	=> 0,
		'16'	=> 0,
		'17'	=> 0,
		'18'	=> 0,
		'19'	=> 0,
		'20'	=> 0,
		'21'	=> 0,
		'22'	=> 0,
		'23'	=> 0
	);

	$data = $resultado['data'];

	foreach($data as $row){
		$nCuenta	= $row['nCuenta'];
		$nHora		= $row['nHora'];

		$array_horas[$nHora] = $nCuenta;
	}

	$horas	= array_keys($array_horas);
	$ventas	= array_values($array_horas);

	/*
		Obtener informacion de la ultima semana
	*/

	$fecha = date('Y-m-d');
	$nuevafecha		= strtotime ( '-6 day' , strtotime ( $fecha ) ) ;
	$fechaPasada	= date ( 'Y-m-d' , $nuevafecha );
	$sDiaSemana		= date ( 'l' , $nuevafecha );

	$array_dias = array();
	$suma_dias	= 1;

	$array_valores = array();

	for($i=0; $i<7; $i++){
		$fecha_sumada	= strtotime('+'.$suma_dias.' day', strtotime($fecha));
		$nDiaSemana		= date ( 'w' , $fecha_sumada);


		$array_valores[$nDiaSemana] = 0;

		$suma_dias++;
	}

	$resultado = $oMonitor->obtenerMonitorUltimaSemana();

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		echo json_encode($resultado);
		exit();
	}

	$dataSemana = $resultado['data'];

	foreach($dataSemana as $data){
		$nDia		= $data['nDia'];
		$nCuenta	= $data['nCuenta'];

		$array_valores[$nDia] = $nCuenta;
	}

	$array_semana = array();
	foreach($array_valores as $key => $value){
		$array_semana[] = array('dia' => $key, 'cuenta' => $value);
	}

	$oConfiguracion = new ConfiguracionRedEfectiva();
	$oConfiguracion->setORdb($MRDB);
	$oConfiguracion->setOWdb($MWDB);
	$oConfiguracion->setNIdConfiguracion(1);

	$resultado = $oConfiguracion->cargar();

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		echo json_encode($resultado);
		exit();
	}

	$nTiempoActualizacion	= $resultado['data']['nTiempoActualizacion'];
	$nTiempoInactividad		= $resultado['data']['nTiempoInactividad'];
	$nTiempoAlerta			= $resultado['data']['nTiempoAlerta'];

	$oMonitor = new MonitorMiSuerte();
	$oMonitor->setORdb($MRDB);
	$oMonitor->setOWdb($MWDB);

	$resultado = $oMonitor->obtenerUltimaOperacion();

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		echo json_encode($resultado);
		exit();
	}

	$nMinutos				= $resultado['data'][0]['nMinutosDiferencia'];
	$dFechaUltimaOperacion	= $resultado['data'][0]['dFechaRegistro'];

	$hora = 0;
	if($nMinutos >= $nTiempoInactividad){
		$hora = date('H');
	}

	echo json_encode(array(
		'bExito'	=> true,
		'nCodigo'	=> 0,
		'sMensaje'	=> 'Consulta Ok',
		'data'		=> array(
			'horas'			=> $horas,
			'ventas'		=> $ventas,
			'array_horas'	=> $array_horas,
			'semana'		=> $array_semana,
			'hora'			=> $hora
		)
	));
?>