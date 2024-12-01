<?php


	include("../../inc/config.inc.php");
	//include("../../inc/lib/mail.class.php");
	require("../../inc/lib/phpmailer/class.phpmailer.php");
    include("../../inc/session.ajax.inc.php");


	error_reporting(E_ALL);
	ini_set('display_errors', 1);

$incr = $_POST['inc'];
$correo = $_POST['mail'];
$nombre = $_POST['nombre'];
$codigoval = $_POST['codigoval'];
$facebook = 'https://www.facebook.com/red.efectiva';
$twitter = 'https://twitter.com/redefectiva';
$urlconfirmacion  = "http://www.redefectiva.com/afiliacion/correo/activacion.php?id=".$codigoval;
$ruta = "https://".$_SERVER['HTTP_HOST']."/afiliacion";
include("prospecto_verificacioncorreo.php");
	$oMailHandler = new Mail();
	
	$oMailHandler->setNAutorizador("");
	$oMailHandler->setSIp("");
	//$oMailHandler->setOLog($oLog);
	//$oMailHandler->setORdb($oRdb);
	$oMailHandler->setSSistema("DEF");
	$oMailHandler->setSFrom("envios@redefectiva.com");
	$oMailHandler->setSName("Red Efectiva");
	$oMailHandler->setOMail();
	$oMailHandler->setMail();
	
	$oMailHandler->oMail->SMTPDebug = 0;
	//$oMailHandler->oMail->Port		= $N_SMTP_PORT;
	$oMailHandler->oMail->Debugoutput = 'var_dump';
	$oMailHandler->oMail->AddAddress($correo);
	$oMailHandler->oMail->addReplyTo('envios@redefectiva.com', 'Sistemas');
	$oMailHandler->oMail->CharSet = 'UTF-8';
	$oMailHandler->oMail->Subject = "Confirmación de Correo";
	$oMailHandler->oMail->isHTML(true);

	$oMailHandler->oMail->Body = $cuerpo;

	if($oMailHandler->oMail->Send()){
		echo json_encode(array(
			"nCodigo"			=> 0,
			"bExito"			=> true,
			"sMensaje"			=> "Email enviado exitosamente."
			//"sClaveDinamica"	=> $sClaveDinamica
		));
		//echo '<pre>'; var_dump($oMailHandler->oMail); echo '</pre>';
	}
	else{
		echo json_encode(array(
			"nCodigo"			=> 500,
			"bExito"			=> false,
			"sMensaje"			=> "No fue posible enviar el Email.",
			"sMensajeDetallado"	=> $oMailHandler->oMail->ErrorInfo
		));
		//echo '<pre>'; var_dump($oMailHandler->oMail); echo '</pre>';
	}


	$oMailHandler->oMail->__destruct();
?>