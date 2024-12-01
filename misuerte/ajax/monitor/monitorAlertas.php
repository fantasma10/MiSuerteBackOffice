<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
	require($_SERVER['DOCUMENT_ROOT']."/inc/lib/phpmailer/class.phpmailer.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdCliente	= !empty($_POST['nIdCliente'])? $_POST['nIdCliente'] : 0;

	$start		= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"] : 0;
	$limit		= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 20;
	$sortCol	= (isset($_POST['iSortCol_0']) && $_POST['iSortCol_0'] > -1)? $_POST['iSortCol_0'] : 0;
	$sortDir	= (!empty($_POST['sSortDir_0']))? $_POST['sSortDir_0'] : 0;
	$str		= (!empty($_POST['sSearch']))? $_POST['sSearch'] : '';
	$sEcho		= (!empty($_POST["sEcho"]))? $_POST["sEcho"] : 1;

	$oCfgTabla = new StdClass;
	$oCfgTabla->start	= $start;
	$oCfgTabla->limit	= $limit;
	$oCfgTabla->sortCol	= $sortCol;
	$oCfgTabla->sortDir	= $sortDir;
	$oCfgTabla->str		= $str;

	$oNotificacion = new Notificacion();
	$oNotificacion->setORdb($MRDB);
	$oNotificacion->setOWdb($MWDB);

	$resultado = $oNotificacion->consultar($oCfgTabla);

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		echo json_encode($resultado);
		exit();
	}

	$array_correos = array();

	$data = $resultado['data'];

	foreach($data as $dat){
		$array_correos[] = $dat['sCorreo'];
	}

	/*
		cargar configuracion (tiempo para alertas)
	*/
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

	$oMonitor->setNIdCliente($nIdCliente);

	/*
		Obtener datos del día actual
	*/
	$resultado = $oMonitor->obtenerUltimaOperacion();

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		echo json_encode($resultado);
		exit();
	}

	$nMinutos				= $resultado['data'][0]['nMinutosDiferencia'];
	$dFechaUltimaOperacion	= $resultado['data'][0]['dFechaRegistro'];

	if($nMinutos >= $nTiempoAlerta){

		$sLblMin = ' Minutos';
		
		if($nMinutos > 60){
			$nHoras		= $nMinutos/60;
			$nHoras		= number_format($nHoras,0,",",".");
			$nMinutos	= $nMinutos%60;

			$sLblMin = $nHoras.' Horas y '.$nMinutos.' minutos';
		}
		else{
			$sLblMin = $nMinutos.' Minutos';
		}

		if(count($array_correos) > 0){
			include_once('../../templates/inactividadMonitor.php');
			$sTemplate = $html;

			$oMail = new Mail();
			$oMail->setNAutorizador("");
			$oMail->setSIp("");
			$oMail->setSSistema("RED");
			$oMail->setSFrom("sistemas@redefectiva.com");
			$oMail->setSName("Red Efectiva");
			$oMail->setOMail();
			$oMail->setMail();

			$oMonitor->setOEmail($oMail);
			$resultado = $oMonitor->enviarAlerta($array_correos, $sTemplate);

			if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
				echo json_encode($resultado);
				exit();
			}
		}
	}

	if($nMinutos >= $nTiempoInactividad){
		echo json_encode(array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Consulta Ok',
			'data'		=> array(
				'hora'	=> date('H')
			)
		));
		exit();
	}

	echo json_encode(array(
		'bExito'	=> true,
		'nCodigo'	=> 0,
		'sMensaje'	=> 'Consulta Ok',
		'data'		=> array()
	));
?>