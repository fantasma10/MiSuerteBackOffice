<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
	require($_SERVER['DOCUMENT_ROOT']."/inc/lib/phpmailer/class.phpmailer.php");


	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdMovBanco	= (!empty($_POST['nIdMovBanco']))? $_POST['nIdMovBanco'] : 0;
	$nIdDeposito 	= (!empty($_POST['nIdDeposito']))? $_POST['nIdDeposito'] : 0;

	$bAutorizado	= (!empty($_POST['bAutorizado']))? $_POST['bAutorizado'] : 0;
	$sClave			= (!empty($_POST['sClave']))? $_POST['sClave'] : 0;

	$nIdUsuario		= $_SESSION['idU'];

	$oHash = new Hash();
	$oHash->setString($sClave);
	$oHash->setSAlgorithmName('sha256');

	$sClave = $oHash->makeHash();

	$oConciliacion = new Conciliacion();
	$oConciliacion->setORdb($oRdb);
	$oConciliacion->setOWdb($oWdb);
	$oConciliacion->setOLog($LOG);

	$oConciliacion->setNIdMovBanco($nIdMovBanco);
	$oConciliacion->setNIdDeposito($nIdDeposito);
	$oConciliacion->setNIdUsuario($nIdUsuario);

	$arrRes = $oConciliacion->necesitaAutorizacion();

	if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
		echo json_encode($arrRes);
		exit();
	}

	$bPermitirConciliar = false;
	$encontrado = $arrRes['data'][0]['encontrado'];

	if($bAutorizado == 0){
		if($encontrado >= 1){

			$tbl = "asdfasdfasdf";

			$sCorreo			= $arrRes['data'][0]['sCorreo'];
			//$sCorreo			= 'emma.colorado@hotmail.com';
			$sNombreCompleto	= $arrRes['data'][0]['sNombreCompleto'];
			$nMonto				= $arrRes['data'][0]['nMonto'];
			$dFecBanco			= $arrRes['data'][0]['dFecBanco'];
			include_once '../../../lib/mail/templates/autorizar_conciliacion.php';
			$sTemplate = $html;

			$oConciliacion->setSCorreo($sCorreo);
			$oConciliacion->setSTemplate($sTemplate);
			$res_envio = $oConciliacion->enviarCorreoAutorizador();

			echo json_encode(array(
				'bExito'	=> true,
				'nCodigo'	=> 1,
				'sMensaje'	=> 'Es necesario autorizar',
				'data'		=> $arrRes['data'][0]
			));
			exit();
		}
		else{
			if($encontrado == 0){
				$bPermitirConciliar = true;
			}
		}
	}

	if($bAutorizado == 1){
		$nIdUsuarioAutorizador = $arrRes['data'][0]['nIdUsuario'];

		$oConciliacion->setNIdUsuarioAutorizador($nIdUsuarioAutorizador);
		$oConciliacion->setSClave($sClave);

		$arrRes = $oConciliacion->autenticarAutorizador();

		$bEncontrado = $arrRes['data'][0]['bEncontrado'];

		if($bEncontrado == 1){
			$bPermitirConciliar = true;
		}
		else{
			echo json_encode(array(
				'nCodigo'	=> 2,
				'bExito'	=> false,
				'sMensaje'	=> 'La clave introducida no es válida'
			));
			exit();
		}
	}

	if($bPermitirConciliar){
		$arrRes = $oConciliacion->concilia();
	}

	echo json_encode($arrRes);
?>