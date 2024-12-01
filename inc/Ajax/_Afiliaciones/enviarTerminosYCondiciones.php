<?php

	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	require($_SERVER['DOCUMENT_ROOT']."/inc/lib/phpmailer/class.phpmailer.php");


	$idCliente	= (!empty($_POST['idCliente']))? $_POST['idCliente'] : -1;
	$email		= (!empty($_POST['email']))? $_POST['email'] : "";

	/*$oAf = new AfiliacionCliente($RBD, $WBD, $LOG);
	$oAf->load($idAfiliacion);*/


	$QUERY = "SELECT `Archivo`, `idTerminos` FROM `afiliacion`.`cat_terminos` WHERE `idEstatus` = 0";
	$sql = $RBD->query($QUERY);

	$res = mysqli_fetch_assoc($sql);

	if(empty($res['Archivo']) || $res['Archivo'] == null){
		$response = array(
			'showMsg'	=> 1,
			'success'	=> false,
			'errmsg'	=> "",
			'msg'		=> 'Archivo no Configurado'
		);
		echo json_encode($response);
		exit();
	}

	include($_SERVER['DOCUMENT_ROOT']."/inc/lib/mail/templates/terminosCondiciones.php");

	if(!$RBD->error()){
		$SENDMAIL = true;

		$arr	= explode("\\", $_SERVER['DOCUMENT_ROOT']);
		$ultimo	= count($arr) - 1;
		unset($arr[$ultimo]);

		$path = implode("\\", $arr);
		$fullpath = $path."\\"."archivosterminos\\".$res['Archivo'];

		$mail = new correo('', '', $LOG, $RBD, $LOG, $WBD);
		$mail->MAIL->AddAddress($email);
		$mail->MAIL->addReplyTo('sistemas@redefectiva.com', 'Sistemas');
		$mail->MAIL->IsHTML(true);
		$mail->MAIL->CharSet	= 'UTF-8';
		$mail->MAIL->Subject  	= "Términos y Condiciones";
		$mail->MAIL->isHTML(true);
		$mail->MAIL->Body     	= $tbl;
		$mail->MAIL->AddAttachment($fullpath);

		if(!$mail->MAIL->Send()){
			$response = array(
				'showMsg'	=> 1,
				'success'	=> false,
				'errmsg'	=> "1 : ".$mail->MAIL->ErrorInfo,
				'msg'		=> 'No fue posible enviar el Correo, Intente nuevamente'
			);

			$LOG->error('Mailer error: ' . $mail->MAIL->ErrorInfo);
		}
		else{
			$response = array(
				'showMsg'	=> 1,
				'success'	=> true,
				'errmsg'	=> "",
				'msg'		=> 'Correo Enviado'
			);
		}

	}
	else{
		$response = array(
			"showMsg"	=> 1,
			"msg"		=> "Intente nuevamente",
			"success"	=> true,
			"errmsg"	=> $RBD->error()
		);
	}

	/*if($oAf->EXISTE){

		$tbl = "T&eacute;rminos y Condiciones";
		if($SENDMAIL){
			$mail = new PHPMailer();
			$mail->IsSMTP();// telling the class to use SMTP
			$mail->Debugoutput	= 'html';
			$mail->CharSet		= 'UTF-8';
			$mail->Port			= 465;
			$mail->Host     	= "smtp.gmail.com"; 
			$mail->SMTPAuth 	= true;
			$mail->SMTPSecure	= "ssl";
			$mail->Username		= "aveloz@redefectiva.com";
			$mail->Password		= "Red123Efectiva2015";
			$mail->do_verp		= true;
			$mail->AddAttachment($fullpath);
			$mail->setFrom("sistemas@redefectiva.com", "Red Efectiva Sistemas");
			$mail->AddAddress($email);
			$mail->addReplyTo('sistemas@redefectiva.com', 'Sistemas');
			$mail->IsHTML(true);
			$mail->Subject  	= "Términos y Condiciones";
			$mail->isHTML(true);
			$mail->Body     	= $tbl;
			$mail->WordWrap		= 50;

			if(!$mail->Send()){

				$response = array(
					'showMsg'	=> 1,
					'success'	=> false,
					'errmsg'	=> "1 : ".$mail->ErrorInfo,
					'msg'		=> 'No fue posible enviar el Correo, Intente nuevamente'
				);

				$LOG->error('Mailer error: ' . $mail->ErrorInfo);
			}
			else{
				$idTerminos 	= $res['idTerminos'];
				$tipoForelo 	= $oAf->TIPOFORELO;
				$idDueno		= $oAf->ID;
				$fechaEnviado	= date("Y-m-d h:i:s");
				$idEmpleado		= $_SESSION['idU'];

				if($oAf->IDTERMINOS > 0){
					$Q = "CALL `afiliaciones`.`SP_ENVIOTERMINOS_ACTUALIZAR`(".$oAf->IDTERMINOS.", 1, $idEmpleado);";
					$WBD->query($Q);

					if($WBD->error()){
						$LOG->error("Error al Actualizar Envios de Terminos y Condiciones ".$Q." | ".$WBD->error());
					}
				}

				$Q = "CALL `afiliaciones`.`SP_ENVIOTERMINOS_CREAR`($idTerminos, $tipoForelo, $idDueno, '$fechaEnviado', 1, '$email', $idEmpleado);";	

				$sql = $WBD->query($Q);
				$result = mysqli_fetch_assoc($sql);

				if(!$WBD->error()){
					$oAf->IDTERMINOS = $result['idEnvioTerminos'];

					$res = $oAf->actualizarAfiliacion();

					if($res['success'] == true){
						$response = array(
							'showMsg'	=> 0,
							'success'	=> true,
							'errmsg'	=> 'Correo Enviado',
							'msg'		=> 'Correo Enviado'
						);	
					}
					else{
						$response = array(
							'showMsg'	=> 0,
							'success'	=> false,
							'errmsg'	=> $res['errmsg'],
							'msg'		=> 'No se pudo actualizar la Afiliacion'
						);
					}
				}
				else{
					$response = array(
						'showMsg'	=> 0,
						'success'	=> false,
						'errmsg'	=> $WBD->error(),
						'msg'		=> ''
					);

					$LOG->error("Error al crear el registro de Terminos y Condiciones ".$Q." | ".$WBD->error());
				}
			}
		}

	}
*/
	echo json_encode($response);
?>