<?php

/*error_reporting(E_ALL);
ini_set("display_errors", 1);*/

include("../../inc/config.inc.php");
	//include("../../inc/lib/mail.class.php");
	require("../../inc/lib/phpmailer/class.phpmailer.php");


$correo = $_POST['correo'];
$mensaje = $_POST['mensaje'];
$fecha = $_POST['fecha'];
$usuario = $_POST['usuario'];
$tipo = $_POST['tipo'];
$sucursal = $_POST['sucursal'];



$facebook = 'https://www.facebook.com/red.efectiva';
$twitter = 'https://twitter.com/redefectiva';

$ruta = "https://".$_SERVER['HTTP_HOST']."/afiliacion";
include("../correos/corresponsalnotificaciones.php");
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
	$oMailHandler->oMail->Subject = $tipo;
	$oMailHandler->oMail->isHTML(true);
	//$oMailHandler->oMail->AddEmbeddedImage('../inc/img/edv_logo_email.png', 'logo_envios');
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