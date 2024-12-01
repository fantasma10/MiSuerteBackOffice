<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	require($_SERVER['DOCUMENT_ROOT']."/inc/lib/phpmailer/class.phpmailer.php");
	
	$idCliente = isset($_POST['idCliente'])? $_POST['idCliente'] : NULL;
	$nombreCliente = isset($_POST['nombreCliente'])? $_POST['nombreCliente'] : NULL;
	$nombreRepresentanteLegal = isset($_POST['nombreRepresentanteLegal'])? $_POST['nombreRepresentanteLegal'] : NULL;
	$tipoBusqueda = isset($_POST['tipoBusqueda'])? $_POST['tipoBusqueda'] : NULL;
	
	$limiteHoras = 48;
	
	$sqlAceptacion = "SELECT `Estatus`, DATE_FORMAT(`FechaEnvio`, '%Y-%m-%d') AS `dia`, TIMESTAMPDIFF(HOUR, NOW(), `FechaEnvio`) AS `horasTranscurridas`,
	`FechaAceptacion`
	FROM `redefectiva`.`inf_clienteconvenio`
	WHERE `idCliente` = $idCliente
	AND `idEstatus` = 0;";
	$resultAceptacion = $RBD->query($sqlAceptacion);
	if ( $RBD->error() == "" ) {
		if ( mysqli_num_rows($resultAceptacion) > 0 ) {
			$row = mysqli_fetch_assoc($resultAceptacion);
			$estatusAceptacion = $row["Estatus"];
			$dia = $row["dia"];
			$horasTranscurridas = $row["horasTranscurridas"];
			$fechaAceptacion = $row["FechaAceptacion"];
			if ( $estatusAceptacion == 1 ) {
				echo json_encode(array(
				"success" => false,
				'showMsg'	=> 1,
				"codigo" => 506,
				"msg" => utf8_encode("El Cliente o Representante Legal ya aceptó el contrato en la siguiente fecha y hora: ".$fechaAceptacion) ));
				exit();
			} else if ( $estatusAceptacion == 0 ) {
				//Checar que no hayan pasado mas de X horas
				if ( $horasTranscurridas < 0 ) {
					$horasTranscurridas = $horasTranscurridas * -1;
				}
				if ( $horasTranscurridas < $limiteHoras ) {
					echo json_encode(array(
					"success" => false,
					'showMsg'	=> 1,
					"codigo" => 507,
					"msg" => utf8_encode("No fue posible enviar el correo electrónico. Es necesario dejar que transcurran ".$limiteHoras." horas para poder enviar otro al Cliente o Representante Legal.") ));
					exit();				
				}
				
			}
		}
	} else {
		$LOG->error("No fue posible enviar el correo electrónico. Por favor contacte al Administrador del Sistema. QUERY: ".$sqlAceptacion." Error: ".$RBD->error());
		echo json_encode(array(
		"success" => false,
		'showMsg'	=> 1,
		"codigo" => 505,
		"msg" => utf8_encode("No fue posible enviar el correo electrónico. Por favor contacte al Administrador del Sistema. Error: ".$RBD->error()) ));
		exit();	
	}
	
	$sqlCorreo = "SELECT cliente.`Correo`, cliente.`RFC`,
	cliente.`idRegimen`,
	CASE cliente.`idRegimen`
		WHEN 1 THEN
			CONCAT_WS(' ', cliente.`Nombre`, cliente.`Paterno`, cliente.`Materno`)
		WHEN 2 THEN
			cliente.`RazonSocial`
		WHEN 3 THEN
			IF(cliente.`RazonSocial` = '' OR cliente.`RazonSocial` IS NULL, CONCAT_WS(' ', cliente.`Nombre`, cliente.`Paterno`, cliente.`Materno`), cliente.`RazonSocial`)
	END AS `nombreCliente`,
	CONCAT('', repLegal.`nombreRepreLegal`, ' ', repLegal.`apPRepreLegal`, ' ', repLegal.`apMRepreLegal`) AS `nombreRepresentanteLegal`
	FROM `redefectiva`.`dat_cliente` AS cliente
	LEFT JOIN `redefectiva`.`dat_representantelegal` AS repLegal
	ON ( repLegal.`idRepLegal` = cliente.`idRepLegal` AND repLegal.`idEstatusRepLegal` = 0 )
	WHERE `idCliente` = $idCliente
	AND `idEstatus` IN (0,2);";
	$resultCorreo = $RBD->query($sqlCorreo);
	if ( $RBD->error() == "" ) {
		if ( mysqli_num_rows($resultCorreo) > 0 ) {
			$row = mysqli_fetch_assoc($resultCorreo);
			$correo = $row["Correo"];
			$RFC = $row["RFC"];
			$nombreSaludo = "";
			$fecha = date("Y-m-d H:i:s");
			$idRegimen = $row["idRegimen"];
			$nombreCliente = utf8_encode($row["nombreCliente"]);
			$nombreRepresentanteLegal = utf8_encode($row["nombreRepresentanteLegal"]);
			if ( $idRegimen == 1 ) {
				$nombreContrato = $nombreCliente;
			} else if ( $idRegimen == 2 ) {
				$nombreContrato = $nombreRepresentanteLegal." como Representante Legal de ".$nombreCliente;
			} else if ( $idRegimen == 3 ) {
				if ( isset($nombreRepresentanteLegal) ) {
					$nombreContrato = $nombreRepresentanteLegal." a Representante Legal de ".$nombreCliente;
				} else {
					$nombreContrato = $nombreCliente;
				}
			}
			
			$claveDinamica = "";
			$claveDinamica = generateCode(15);

			$sqlRegActual = "SELECT COUNT(*) AS `total`
			FROM `redefectiva`.`inf_clienteconvenio`
			WHERE DATE(`fecRegistro`) = '".date("Y-m-d")."';";
			$res = $RBD->query($sqlRegActual);
			
			if ( $RBD->error() == "" ) {
				$row = mysqli_fetch_assoc($res);
				$contador = $row["total"];
				$contador = $contador + 1;
				$referenciaCreada = true;
				if ( $contador > 999 ) {
					$referenciaCreada = false;
				}
				$incremental = str_pad($contador, 3, '0', STR_PAD_LEFT);
				$anio	= date("y");
				$mes	= date("m");
				$dia	= date("d");
				$terminacion = generateCode(6);
				$claveDinamica = $claveDinamica.$anio.$mes.$dia.$incremental.$terminacion;
			} else {
				$LOG->error("No fue posible enviar el correo electrónico porque no fue posible generar una clave dinámica. Por favor contacte al Administrador del Sistema. QUERY: ".$sqlContrato." Error: ".$RBD->error());
				echo json_encode(array(
				"success" => false,
				'showMsg'	=> 1,
				"codigo" => 508,
				"msg" => utf8_encode("No fue posible enviar el correo electrónico porque no fue posible generar una clave dinámica. Por favor contacte al Administrador del Sistema. Error: ".$RBD->error()) ));
				exit();				
			}
			
			if ( !$referenciaCreada ) {
				$LOG->error("No fue posible enviar el correo electrónico porque no fue posible generar una clave dinámica (límite de 999 claves por día excedido). Por favor contacte al Administrador del Sistema. QUERY: ".$sqlContrato." Error: ".$RBD->error());
				echo json_encode(array(
				"success" => false,
				'showMsg'	=> 1,
				"codigo" => 509,
				"msg" => utf8_encode("No fue posible enviar el correo electrónico porque no fue posible generar una clave dinámica (límite de 999 claves por día excedido). Por favor contacte al Administrador del Sistema. Error: ".$RBD->error()) ));
				exit();				
			}
			
			$claveDinamicaEncriptada = md5($claveDinamica);
			$URLRAIZ = "http://www.redefectiva.com";
			include($_SERVER['DOCUMENT_ROOT']."/inc/lib/mail/templates/contratos/correoContrato.php");
			$SENDMAIL = true;

			$mail = new correo('', '', $LOG, $RBD, $LOG, $WBD, 'DEF', 'legal@redefectiva.com', 'Red Efectiva');
			$mail->MAIL->AddAddress($correo);
			$mail->MAIL->addReplyTo('legal@redefectiva.com', 'Legal');
			$mail->MAIL->CharSet	= 'UTF-8';
			$mail->MAIL->Subject  	= "Contrato Red Efectiva";
			$mail->MAIL->isHTML(true);
			$mail->MAIL->Body     	= $content;

			$idUsuario = $_SESSION['idU'];
			$sqlContrato = "SELECT `idContrato`
			FROM `redefectiva`.`dat_contrato` AS contrato
			WHERE contrato.`RFC` = '$RFC'
			AND contrato.`idEstatusContrato` = 0;";
			$resultContrato = $RBD->query($sqlContrato);
			if ( $RBD->error() == "" ) {
				if ( mysqli_num_rows($resultContrato) > 0 ) {
					$row = mysqli_fetch_assoc($resultContrato);
					$idContrato = $row["idContrato"];
				} else {
					$LOG->error("No fue posible enviar el correo electrónico porque no se encontró un contrato dado de alta para el Cliente o Representante Legal. Por favor contacte al Administrador del Sistema. QUERY: ".$sqlContrato);
					echo json_encode(array(
					"success" => false,
					'showMsg'	=> 1,
					"codigo" => 514,
					"msg" => utf8_encode("No fue posible enviar el correo electrónico porque no se encontró un contrato dado de alta para el Cliente o Representante Legal. Por favor contacte al Administrador del Sistema.") ));
					exit();					
				}
			} else {
				//Error al ejecutar el query
				$LOG->error("No fue posible enviar el correo electrónico. Por favor contacte al Administrador del Sistema. QUERY: ".$sqlContrato." Error: ".$RBD->error());
				echo json_encode(array(
				"success" => false,
				'showMsg'	=> 1,
				"codigo" => 502,
				"msg" => utf8_encode("No fue posible enviar el correo electrónico. Por favor contacte al Administrador del Sistema. Error: ".$RBD->error()) ));
				exit();					
			}
			$sqlVersion = "SELECT `idVersionConvenio`
			FROM `redefectiva`.`cat_versionconvenio`
			WHERE `idEstatus` = 0;";
			$resultVersion = $RBD->query($sqlVersion);
			if ( $RBD->error() == "" ) {
				if ( mysqli_num_rows($resultVersion) == 1 ) {
					$row = mysqli_fetch_assoc($resultVersion);
					$idVersion = $row["idVersionConvenio"];
				} else if ( mysqli_num_rows($resultVersion) == 0 ) {
					//Error no encontro alguna version activa
					$LOG->error("No fue posible enviar el correo electrónico porque no existe alguna versión activa del contrato. Por favor contacte al Administrador del Sistema. QUERY: ".$sqlVersion);
					echo json_encode(array(
					"success" => false,
					'showMsg'	=> 1,
					"codigo" => 503,
					"msg" => utf8_encode("No fue posible enviar el correo electrónico porque no existe alguna versión activa del contrato. Por favor contacte al Administrador del Sistema.") ));
					exit();
				} else {
					//Error encontro mas de una version activa
					$LOG->error("No fue posible enviar el correo electrónico porque existe más de una versión activa del contrato. Por favor contacte al Administrador del Sistema. QUERY: ".$sqlVersion);
					echo json_encode(array(
					"success" => false,
					'showMsg'	=> 1,
					"codigo" => 512,
					"msg" => utf8_encode("No fue posible enviar el correo electrónico porque existe más de una versión activa del contrato. Por favor contacte al Administrador del Sistema.") ));
					exit();				
				}
			}else{
				$LOG->error("No fue posible enviar el correo electrónico. Por favor contacte al Administrador del Sistema. QUERY: ".$sqlCorreo." Error: ".$RBD->error());
				echo json_encode(array(
				"success" => false,
				'showMsg'	=> 1,
				"codigo" => 513,
				"msg" => utf8_encode("No fue posible enviar el correo electrónico. Por favor contacte al Administrador del Sistema. Error: ".$RBD->error()) ));
				exit();
			}
			
			if ( empty($correo) ) {
				echo json_encode(array(
				"success" => false,
				'showMsg'	=> 1,
				"codigo" => 510,
				"msg" => utf8_encode("No fue posible enviar el correo electrónico porque el Cliente no cuenta con una dirección de correo. Por favor contacte al Administrador del Sistema.") ));
				exit();
			}
			
			if ( !preg_match("/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $correo) ) {
				echo json_encode(array(
				"success" => false,
				'showMsg'	=> 1,
				"codigo" => 511,
				"msg" => utf8_encode("No fue posible enviar el correo electrónico porque el Cliente no cuenta con una dirección de correo válida. Por favor contacte al Administrador del Sistema.") ));
				exit();
			}
			
			if ( !$mail->MAIL->Send() ) {
				$response = json_encode(array(
					'showMsg'	=> 1,
					'success'	=> false,
					'errmsg'	=> "1 : ".$mail->MAIL->ErrorInfo,
					'msg'		=> 'No fue posible enviar el correo, intente nuevamente. Error: '.$mail->MAIL->ErrorInfo,
					'correo'	=> $correo
				));
	
				$LOG->error('Mailer error: ' . $mail->MAIL->ErrorInfo);
				echo $response;
				exit();
			} else {			
				$Estatus = 0; // No Aceptado puesto que apenas se esta enviando
				$idEstatus = 0;				
				$sqlBitacora = "CALL `redefectiva`.`SP_INSERT_CLIENTECONVENIO`($idCliente, $idContrato, $idVersion, 2, $Estatus, $idEstatus, '$correo', NULL, '$claveDinamica', '$claveDinamicaEncriptada', '$fecha', NULL, $idUsuario);";
				$resultBitacora = $WBD->SP($sqlBitacora);
				if ( $WBD->error() != "" ) {
					// Error al ejecutar Stored Procedure
					$LOG->error("No fue posible enviar el correo electrónico. Por favor contacte al Administrador del Sistema. QUERY: ".$sqlBitacora." Error: ".$WBD->error());
					echo json_encode(array(
					"success" => false,
					'showMsg'	=> 1,
					"codigo" => 504,
					"msg" => utf8_encode("No fue posible enviar el correo electrónico. Por favor contacte al Administrador del Sistema. Error: ".$WBD->error()) ));
					exit();
				}				
				
				//El correo se envio correctamente
				$response = json_encode(array(
					'showMsg'	=> 1,
					'success'	=> true,
					'errmsg'	=> "",
					'msg'		=> 'Correo Enviado',
					'correo'	=> $correo
				));
				echo $response;
				exit();
			}			
		} else {
			$LOG->error("No fue posible enviar el correo electrónico porque el Cliente no se encuentra activo ni suspendido. Por favor contacte al Administrador del Sistema. QUERY: ".$sqlCorreo);
			echo json_encode(array(
			"success" => false,
			'showMsg'	=> 1,
			"codigo" => 501,
			"msg" => utf8_encode("No fue posible enviar el correo electrónico porque el Cliente no se encuentra activo ni suspendido. Por favor contacte al Administrador del Sistema.") ));
			exit();		
		}
	} else {
		$LOG->error("No fue posible enviar el correo electrónico. Por favor contacte al Administrador del Sistema. QUERY: ".$sqlCorreo." Error: ".$RBD->error());
		echo json_encode(array(
		"success" => false,
		'showMsg'	=> 1,
		"codigo" => 500,
		"msg" => utf8_encode("No fue posible enviar el correo electrónico. Por favor contacte al Administrador del Sistema. Error: ".$RBD->error()) ));
		exit();
	}
?>