<?php 

ini_set("soap.wsdl_cache_enabled", "0");
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/lib/phpmailer/class.phpmailer.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];
$p_cliente 	    = $_POST["nIdCliente"];
$p_nombre 		= $_POST["razonSocial"];

include($_SERVER['DOCUMENT_ROOT']."/MesaControl/cliente/plantillaCorreoAutorizacion.php");

$facebook = 'https://www.facebook.com/red.efectiva';
$twitter = 'https://twitter.com/redefectiva';
$subject = "Autorizar cambios en cliente {$p_nombre}";
$correos = $usuarios_afiliacion_clientes['correos_revision'];

$oMailHandler = new Mail();
$oMailHandler->setNAutorizador("");
$oMailHandler->setSIp("");
$oMailHandler->setOLog($oLog);
$oMailHandler->setORdb($oRdb);
$oMailHandler->setSSistema("DEF");
$oMailHandler->setSFrom("envios@redefectiva.com");
$oMailHandler->setSName("Red Efectiva");
$oMailHandler->setOMail();
$oMailHandler->setMail();

$oMailHandler->oMail->SMTPDebug = 0;
// $oMailHandler->oMail->Port = $N_SMTP_PORT;
$oMailHandler->oMail->Debugoutput = 'var_dump';
$oMailHandler->oMail->AddAddress($correos);
// $oMailHandler->oMail->addReplyTo('envios@redefectiva.com', 'Sistemas');
$oMailHandler->oMail->CharSet = 'UTF-8';
$oMailHandler->oMail->Subject = $subject;
$oMailHandler->oMail->isHTML(true);
//$oMailHandler->oMail->AddEmbeddedImage('../inc/img/edv_logo_email.png', 'logo_envios');
$oMailHandler->oMail->Body = $cuerpo;

if($oMailHandler->oMail->Send()){
    $sQuery = "CALL redefectiva.sp_update_cliente_estado_secciones($p_cliente, 1)";
    $res = $WBD->query($sQuery);
    $datos = array(
        "nCodigo"			=> 0,
        "bExito"			=> true,
        "sMensaje"			=> "Email enviado exitosamente.",
        "secciones"			=> ""
    );
}
else{
    $datos = array(
        "nCodigo"			=> 500,
        "bExito"			=> false,
        "sMensaje"			=> "No fue posible enviar el Email.",
        "sMensajeDetallado"	=> $oMailHandler->oMail->ErrorInfo
    );
}
$oMailHandler->oMail->__destruct();

print json_encode($datos);

?>