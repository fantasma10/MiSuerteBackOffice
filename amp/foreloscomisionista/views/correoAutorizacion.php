<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
include_once($PATH_PRINCIPAL . "/inc/config.inc.php");
include_once($PATH_PRINCIPAL ."/inc/lib/phpmailer/class.phpmailer.php");
$ruta = URL_AMP."index.php/Credito/solicitud/";
$oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_select_gestion_creditoLimitadoAutorizantes');   
                $param = array();
                $oRAMP->setParams($param);      
                $result2 = $oRAMP->execute();
                $usuariosAutorizantes =  ($oRAMP->fetchAll());
                $oRAMP->closeStmt();
                foreach ( ($usuariosAutorizantes) as $key) {
                    $nIdTipoCreditoNoticacion = $key['nIdTipoCreditoNoticacion'];
                    $correoAutorizador = $key['sCorreo'];

$Autorizar = $ruta."".$nIdTipoCreditoNoticacion."X".$sToken."1" ;
$Rechazar = $ruta."".$nIdTipoCreditoNoticacion."X".$sToken."2" ;
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
																Solicitud de Autorización de Crédito para<br>
																Nombre/Razón Social del comisionista: <strong>'.$sRazonSocial.'</strong><br>
																Nombre Comercial: <strong>'.$sNombreCadena.'</strong><br>
																Saldo FORELO: <strong>'."$".number_format($saldoCuenta , 2, '.', ',').'</strong><br>
																Monto por Autorizar: <strong>'."$".number_format($nAbono , 2, '.', ',').'</strong><br>
																Saldo despúes de Aplicado el Crédito: <strong>'."$".number_format(($saldoCuenta+$nAbono) , 2, '.', ',').'</strong><br>
																La solicitud te la envió<br>
																<strong>'.$sNombreusuarioRE.'</strong><br>
																<strong style="color:red;">Si autoriza, recibirá un mensaje de correo donde le solicita el código de autorización que recibirá en su teléfono. </strong><br>
																<a href="'.$Rechazar.'"  style="padding:8px 20px; background-color: #3762FA; color:#fff; font-weight:bolder; font-size:16px; display:inline-block; text-decoration:none"  >Rechazar</a>
																<a href="'.$Autorizar.'"  style="padding:8px 20px; background-color: #3762FA; color:#fff; font-weight:bolder; font-size:16px; display:inline-block; text-decoration:none"  >Autorizar</a>
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

 
//	$oMailHandler = new Mail();	
/*
	$oMailHandler->setNAutorizador("");
	$oMailHandler->setSIp("");
	$oMailHandler->setSSistema("DEF");
	$oMailHandler->setSFrom("envios@redefectiva.com");
	$oMailHandler->setSName("Red Efectiva");
	$oMailHandler->setOMail();
	$oMailHandler->setMail();
*/
	/*$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					)
				);
	$oMailHandler->Host='smtp.office365.com';
	$oMailHandler->setNAutorizador("");
	$oMailHandler->setSIp("");

	$oMailHandler->setOLog($oLog);
	$oMailHandler->setORdb($oRBDPC);

	$oMailHandler->setSSistema("DEF");
	$oMailHandler->SMTPAuth=true;
	$oMailHandler->Username="admin@paynau.com";
	$oMailHandler->Password="Septiembre2020";
	$oMailHandler->SMTPSecure='STARTTLS';
	$oMailHandler->setSFrom("admin@paynau.com","Pagos Aquí");
	$oMailHandler->Port=587;
	$oMailHandler->setSName("Red Efectiva");
	$oMailHandler->setOMail();
	$oMailHandler->setMail();
	$oMailHandler->oMail->SMTPDebug = 0;
	$oMailHandler->oMail->Debugoutput = 'var_dump';
	$oMailHandler->oMail->addBCC('aramirez@redefectiva.com','aramirez@redefectiva.com');
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
		  var_dump($oMailHandler->oMail->ErrorInfo);
	}*/
	try {
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		$mail->Host='smtp.office365.com';
		$mail->SMTPAuth=true;
		$mail->Username="admin@paynau.com";
		$mail->Password="Septiembre2020";
		$mail->SMTPSecure='STARTTLS';
		$mail->Port=587;
		$mail->setFrom("admin@paynau.com","Pagos Aquí");
		$mail->addAddress('aramirez@redefectiva.com'); 
		$mail->isHTML(true);
		$mail->Subject = 'Solicitud de Autorización de Crédito.';
		$mail->Body    = $cuerpo;
		//$mail->AltBody = $AltBody;
		//$mail->send();
		if($mail->Send()){
			json_encode(array(
			  "nCodigo"			=> 0,
			  "bExito"			=> true,
			  "sMensaje"			=> "Email enviado exitosamente."
		  ));
	  	}
	}catch (Exception $e) {
		json_encode(array(
			"nCodigo"			=> 500,
			"bExito"			=> false,
			"sMensaje"			=> "No fue posible enviar el Email.",
			"sMensajeDetallado"	=> $mail->ErrorInfo
		));
	}

	var_dump($mail->ErrorInfo);
	$mail->__destruct();

}
?>