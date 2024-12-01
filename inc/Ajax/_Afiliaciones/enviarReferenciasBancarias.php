<?php

	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	require($_SERVER['DOCUMENT_ROOT']."/inc/lib/phpmailer/class.phpmailer.php");


	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST'];

	$idAfiliacion	= (!empty($_POST['idAfiliacion']))? $_POST['idAfiliacion'] : -1;
	$idSubCadena	= -1;
	$email			= (!empty($_POST['email']))? $_POST['email'] : "";

	$oAf = new AfiliacionCliente($RBD, $WBD, $LOG);
	$oAf->load($idAfiliacion);

	$limit = $oAf->NUMEROCORRESPONSALES;

	if($oAf->EXISTE){
		/*if($oAf->TIPOFORELO == 1){*/

			$TIPOFORELO = $oAf->TIPOFORELO;

			if($oAf->IDESTATUSCUENTA == 0){
				$banco = $oAf->NOMBREBANCO;
				$clabe = $oAf->CLABE;
			}

			$costo = $oAf->COSTO;
			$costoTotal = $oAf->PAGO_PENDIENTE/*$oAf->COSTO * $oAf->NUMEROCORRESPONSALES*/;

			$REFBANCARIA = $oAf->REFERENCIABANCARIA;

			$SENDMAIL = true;

			$nombre = (!$oAf->IDTIPOPERSONA == 1)? $oAf->NOMBREPERSONA." ".$oAf->APATERNOPERSONA." ".$AMATERNOPERSONA : $oAf->RAZONSOCIAL;
			$NOMBREDELCLIENTE = $nombre;

			include($_SERVER['DOCUMENT_ROOT']."/inc/lib/mail/templates/referenciasBancarias.php");
		/*}*/
		/*else{
			$QUERY = "CALL `afiliaciones`.`SP_SUCURSAL_LISTA`($idAfiliacion, 0, 'ASC', '', 0, $limit)";
			$sql = $RBD->query($QUERY);


			if(!$RBD->error()){
				$tbl = "<table cellspacing='15'><header><tr><th>Sucursal</th><th>Referencia Bancaria</th></tr></header><tbody>";
				$sucursales = array();
				$referenciasEncontradas = 0;

				while($row = mysqli_fetch_assoc($sql)){
					$sucursales[] = array(
						"idSucursal"	=> $row['idCorresponsal'],
						"idRefBancaria"	=> $row['idRefBancaria']
					);

					if(!empty($row['idRefBancaria'])){
						$referenciasEncontradas++;
					}
					$nombre = !preg_match("!!u", $row['nombreCorresponsal'])? utf8_encode($row['nombreCorresponsal']) : $row['nombreCorresponsal'];

					$tbl.= "<tr><td>".$nombre."</td><td>".$row['referenciaBancaria']."</td></tr>";
				}
				
				$tbl.="</tbody></table>";

				if($referenciasEncontradas > 0){
					$SENDMAIL = true;
				}
				else{
					$response = array(
						'showMsg'	=> 1,
						'msg'		=> "No se envió ningún correo debido a que las sucursales no cuentan con referencia bancaria"
					);
				}
			}
			else{
				$response = array(
					'showMsg'	=> 1,
					'success'	=> false,
					'errmsg'	=> $RBD->error(),
					'msg'		=> 'No fue posible cargar la lista de Sucursales'
				);
				$LOG->error($response['msg']." | ".$QUERY." | ".$response['errmsg']);
			}
		}*/

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

				/*echo 'Message was not sent.';
				echo 'Mailer error: ' . $mail->MAIL->ErrorInfo;*/
				$LOG->error('Mailer error: ' . $mail->MAIL->ErrorInfo);
			}
			else {
				/*if($oAf->TIPOFORELO == 1){
					$resp = $oAf->correoEnviado($oAf->ID_CLIENTE, $oAf->IDREFERENCIABANCARIA, $oAf->TIPOFORELO, date("Y-m-d h:i:s"), $email);
				}
				else{
					//var_dump($sucursales);
					foreach($sucursales AS $index => $sucursal){

						if(!empty($sucursal['idRefBancaria'])){
							$resp = $oAf->correoEnviado($sucursal['idSucursal'], $sucursal['idRefBancaria'], 2, date("Y-m-d h:i:s"), $email);
							
							if($resp['success'] == false){
								$LOG->error("No se pudo enviar correo a la Sucursal #".$sucursal." | ".$email." | ".$resp['errmsg']);
							}
						}
					}
				}*/
				
				/*if($resp['success'] == true){*/
					$response = array(
						'showMsg'	=> 1,
						'success'	=> true,
						'errmsg'	=> "",
						'msg'		=> 'Correo Enviado'
					);
				/*}
				else{
					$response = array(
						'showMsg'	=> 1,
						'success'	=> true,
						'errmsg'	=> $resp['errmsg'],
						'msg'		=> 'No ha sido posible Enviar el Correo'
					);	
				}*/
			}
		}

	}

	echo json_encode($response);
?>