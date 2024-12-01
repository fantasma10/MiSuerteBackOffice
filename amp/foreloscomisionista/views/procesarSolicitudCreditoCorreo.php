<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
include_once($PATH_PRINCIPAL . "/inc/config.inc.php");
include_once($PATH_PRINCIPAL ."/inc/lib/phpmailer/class.phpmailer.php");
$ruta = "https://".$_SERVER['HTTP_HOST']."/amp/foreloscomisionista/views/procesarSolicitudCredito.php";
$Autorizar = $ruta."?token=".$sToken."1" ;
$Rechazar = $ruta."?token=".$sToken."0" ;
$cuerpo ='<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
					<title>Título</title>
				</head> 
				<body style="background-color: #ffffff; margin:0; padding:0; color: #777777;"> 
					<table width="600" height="501" align="center" style="background-image:url("bg.jpg");">
						<tr>
							<td valign="top"> 
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tbody>							 
										<tr>
											<td align="center" valign="top"> 
												<table width="558" border="0" cellspacing="0" cellpadding="0" style="width:558px;">
													<tbody>  
														<tr>
															 <td align="center" style="padding-top:25px; padding-bottom:30px;">
																<table width="513" cellspacing="0" cellpadding="0" border="0" style="font-family: &#39;Lucida Sans Unicode&#39;,&#39;Lucida Grande&#39;,sans-serif,Arial,Verdana; font-size: 12px;"> 
																	 	<tr>
																		<td valign="top">
																			 
																		</td>																		 
																	</tr>
																</table>
															</td> 
														</tr>
									 
														<tr> 
															<td>
																<strong>'.$statusSolicitud.'</strong><br>
																Tú solicitud de crédito para el comisionista: <strong>'.$sRazonSocial.'</strong> ha sido <strong>'.$statusSolicitud.'</strong> '.$msg.'. <br>
																
															</td>
														</tr>
														<tr>
															<td align="center" style="padding-top:10px;"> 
																&nbsp;
															</td>
														</tr>
														<tr>
															<td>
																
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</table> 
				</body>
			</html>';
$facebook = 'https://www.facebook.com/red.efectiva';
$twitter = 'https://twitter.com/redefectiva';
$ruta = "https://".$_SERVER['HTTP_HOST']."/afiliacion";
	$oMailHandler = new Mail();	
	$oMailHandler->setNAutorizador("");
	$oMailHandler->setSIp("");

	$oMailHandler->setOLog($oLog);
	$oMailHandler->setORdb($oRBDPC);

	$oMailHandler->setSSistema("DEF");
	$oMailHandler->setSFrom("envios@redefectiva.com");
	$oMailHandler->setSName("Red Efectiva");
	$oMailHandler->setOMail();
	$oMailHandler->setMail();
	$oMailHandler->oMail->SMTPDebug = 0;
	$oMailHandler->oMail->Debugoutput = 'var_dump';
	$oMailHandler->oMail->AddAddress($sCorreoSolicitante,$sCorreoSolicitante);
	$oMailHandler->oMail->AddAddress($correoAutorizador,$correoAutorizador);
	$oMailHandler->oMail->addReplyTo('envios@redefectiva.com', 'Sistemas');
	$oMailHandler->oMail->CharSet = 'UTF-8';
	$oMailHandler->oMail->Subject = 'Solicitud de Autorización de Crédito.';
	$oMailHandler->oMail->isHTML(true);
	$oMailHandler->oMail->Body = $cuerpo;
	if($oMailHandler->oMail->Send()){
		  json_encode(array(
			"nCodigo"			=> 0,
			"bExito"			=> true,
			"sMensaje"			=> "Email enviado exitosamente."
		));
	}
	else{
		  json_encode(array(
			"nCodigo"			=> 500,
			"bExito"			=> false,
			"sMensaje"			=> "No fue posible enviar el Email.",
			"sMensajeDetallado"	=> $oMailHandler->oMail->ErrorInfo
		));
	}
	$oMailHandler->oMail->__destruct();
?>