<?php

	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	require($_SERVER['DOCUMENT_ROOT']."/inc/lib/phpmailer/class.phpmailer.php");


	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST'];

	$idAfiliacion	= 0;
	$idSubCadena	= (isset($_POST['idSubCadena']))? $_POST['idSubCadena'] : -1;
	$email			= (!empty($_POST['email']))? $_POST['email'] : "";

	$oAf = new AfiliacionCliente($RBD, $WBD, $LOG);
	$oAf->loadClienteReal($idSubCadena, 1);

	$sqlC = $RBD->query("SELECT COUNT(*) AS `cuenta` FROM `afiliacion`.`dat_sucursal` WHERE idSubcadena = $idSubcadena AND `idEstatus` IN(1, 0)");
	$res = mysqli_fetch_assoc($sqlC);
	$oAf->NUMEROCORRESPONSALES = $res['cuenta'];

	$limit = $oAf->NUMEROCORRESPONSALES;

	$SENDMAIL = true;

	include($_SERVER['DOCUMENT_ROOT']."/inc/lib/mail/templates/referenciasBancarias2.php");
	
	if($SENDMAIL){
		$mail = new correo('', '', $LOG, $RBD, $LOG, $WBD);
		//$mail->MAIL->IsSMTP();  // telling the class to use SMTP
		$mail->MAIL->AddAddress($email);
		$mail->MAIL->addReplyTo('sistemas@redefectiva.com', 'Sistemas');
		$mail->MAIL->IsHTML(true);
		$mail->MAIL->Subject  	= "Referencias Bancarias";
		$mail->MAIL->isHTML(true);
		$mail->MAIL->Body     	= $tbl;
		//$mail->MAIL->WordWrap		= 50;

		if(!$mail->MAIL->Send()){

			$response = array(
				'showMsg'	=> 1,
				'success'	=> false,
				'errmsg'	=> "1 : ".$mail->MAIL->ErrorInfo,
				'msg'		=> 'No fue posible enviar el Correo, Intente nuevamente'
			);

			$LOG->error('Mailer error: ' . $mail->MAIL->ErrorInfo);
		}
		else {
				$response = array(
					'showMsg'	=> 1,
					'success'	=> true,
					'errmsg'	=> "",
					'msg'		=> 'Correo Enviado'
				);
		}
	}



	echo json_encode($response);
?>