<?php

include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$data=array();

if ($_POST){
/* tipo:
1:Buscar de integradores
2:Actualizar Integrador
3:Guardar Integrador 
4:Actualizar Estatus Integrador*/

		$tipo=$_POST['itipo'];
		if ($tipo==1){
			$array_params = array(
			array(
				'name'	=> 'p_nIdIntegrador',
				'type'	=> 'i',
				'value'	=> 0
			)
		);
			$oRdb->setSDatabase('paycash_one');
			$oRdb->setSStoredProcedure('sp_select_integradores');
			$oRdb->setParams($array_params);
			$result = $oRdb->execute();
			
			$data = $oRdb->fetchAll();
			$data =utf8ize($data);
		}else if($tipo==2){
			$array_params =array();
			$Mensaje ="Informacion guardada";
			
			$docs=array(array('nIdDocumento' =>$_POST['sdocRfc'],'nIdTipoDocumento' => 1),
				  array('nIdDocumento' =>$_POST['sdocDomicilio'],'nIdTipoDocumento' => 2),
				  array('nIdDocumento' =>$_POST['sdocCuenta'],'nIdTipoDocumento' => 3),
				  array('nIdDocumento' =>$_POST['sdocContrato'],'nIdTipoDocumento' => 4));
			$json=json_encode ($docs);
			
			foreach ($_POST as $clave=>$valor){
				$name=$clave;
				$type=$name[0];
				$value=$valor;
				if ($clave=='sIdDocumento'){
					$array_params[]=array('name'=>$name,'type'=>$type,'value'=>"$json");
				}else{
					$array_params[]=array('name'=>$name,'type'=>$type,'value'=>$value);
				}
			}
			$oRdb->setSDatabase('paycash_one');
			$oRdb->setSStoredProcedure('sp_update_integradores');
			$oRdb->setParams($array_params);
			$result = $oRdb->execute();
			
			if(!$result['bExito'] || $result['nCodigo'] != 0){
				$Mensaje = 'No ha sido posible actualizar la informacion del Integrador';
			}
		
			$data=array(
				'bExito'			=> true,
				'nCodigo'			=> 0,
				'sMensaje'			=> 'Informacion del Integrador actualizada',
				'sMensajeDetallado'	=> ''
			);
			
		}else if($tipo==3){
			$array_params =array();
			$Mensaje ="Informacion guardada";
			
			$docs=array(array('nIdDocumento' =>$_POST['sdocRfc'],'nIdTipoDocumento' => 1),
				  array('nIdDocumento' =>$_POST['sdocDomicilio'],'nIdTipoDocumento' => 2),
				  array('nIdDocumento' =>$_POST['sdocCuenta'],'nIdTipoDocumento' => 3),
				  array('nIdDocumento' =>$_POST['sdocContrato'],'nIdTipoDocumento' => 4));
			$json=json_encode ($docs);
			$nIdTipoReferencia=$_POST['iIdTipoReferencia'];
			$nIdIntegrador=0;
			$sToken=	$_POST['sToken'];
			$sCorreo=  $_POST['sCorreo'];
			$nCodigo=0;
			foreach ($_POST as $clave=>$valor){
				$name=$clave;
				$type=$name[0];
				$value=$valor;
				if ($clave=='sIdDocumento'){
					$array_params[]=array('name'=>$name,'type'=>$type,'value'=>"$json");
				}else{
					$array_params[]=array('name'=>$name,'type'=>$type,'value'=>$value);
				}
				
			}
			
			
			$oRdb->setSDatabase('paycash_one');
			$oRdb->setSStoredProcedure('sp_insert_integradores');
			$oRdb->setParams($array_params);
			$result = $oRdb->execute();
			
			if(!$result['bExito'] || $result['nCodigo'] != 0){
				$Mensaje = 'No ha sido posible guardar la informacion del Integrador';
			}
			$nCodigo=$result['nCodigo'];
			
			/* Enviar correo al integrador*/
			if ( $result['nCodigo']==0){
				$row = $oRdb->fetchAll();
				$nIdIntegrador=$row[0]['nIdIntegrador'];
				
				if($nIdTipoReferencia > 2){
						$texto = '<p style="color:#000000;">A continuación les compartimos su ID de Acceso y Token para la 	autenticación de la aplicación:</p>
						  <p><br>ID de Acceso: '.$nIdIntegrador.' </p>
						  <p><br>Token: '.$sToken.'</p>';
						}else{
							$texto = '<p style="color:#000000;">A continuación les compartimos su usuario para acceder al portal y cargar sus referencias :</p>
						  <p><br><a href="http://www.paycash.com.mx/emisores" style="color:#2196f3; font-size:14px; text-decoration:none;">http://www.paycash.com.mx/emisores</a></p>
						  <p><br>Usuario: '.$sCorreo.' </p>
						  <p><br>Password: 123456</p>';
						}
						
						include($_SERVER['DOCUMENT_ROOT']."/inc/lib/phpmailer/class.phpmailer.php");

						$facebook = 'https://www.facebook.com/paycashoficial1/';
						$twitter = 'https://twitter.com/paycashmx';
						$ruta = "https://".$_SERVER['HTTP_HOST']."/paycash";

						include($_SERVER['DOCUMENT_ROOT']."/paycash/afiliacion/envioToken.php");

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
						$oMailHandler->oMail->Port = $N_SMTP_PORT;
						$oMailHandler->oMail->Debugoutput = 'var_dump';
						$oMailHandler->oMail->AddAddress($sCorreo);
						$oMailHandler->oMail->addReplyTo('envios@redefectiva.com', 'Sistemas');
						$oMailHandler->oMail->CharSet = 'UTF-8';
						$oMailHandler->oMail->Subject = "Envio de Token";
						$oMailHandler->oMail->isHTML(true);
						
						$oMailHandler->oMail->Body = $cuerpo;

						if($oMailHandler->oMail->Send()){
							$data=array(
								"nCodigo"			=> 0,
								"bExito"			=> true,
								"sMensaje"			=> "Email enviado exitosamente."
							);
						}
						else{
							$data=array(
								"nCodigo"			=> 500,
								"bExito"			=> false,
								"sMensaje"			=> "No fue posible enviar el Email.",
								"sMensajeDetallado"	=> $oMailHandler->oMail->ErrorInfo
							);
						}
						
						/* loguear o hacer una cola reintento */
					
						$oMailHandler->oMail->__destruct();

			}
					
			$data=array(
				'bExito'			=> true,
				'nCodigo'			=> $nCodigo,
				'nIdIntegrador'     =>$nIdIntegrador,
				'sMensaje'			=> $Mensaje,
				'sMensajeDetallado'	=> ''
			);
			

			
		}else if ($tipo==4){
			$array_params =array();
			$Mensaje ="Informacion guardada";
			
			$array_params = array(
			array(
				'name'	=> 'IdProveedor',
				'type'	=> 'i',
				'value'	=> $_POST['idintegardor']
			));
			$oRdb->setSDatabase('paycash_one');
			$oRdb->setSStoredProcedure('sp_update_integrador_estatus');
			$oRdb->setParams($array_params);
			$result = $oRdb->execute();
			
			if(!$result['bExito'] || $result['nCodigo'] != 0){
				$Mensaje = 'No ha sido posible actualizar la informacion del Integrador';
			}
		
			$data=array(
				'bExito'			=> true,
				'nCodigo'			=> 0,
				'sMensaje'			=> 'Informacion del Integrador actualizada',
				'sMensajeDetallado'	=> ''
			);	
		}
		
	}
		//header('Content-Type: application/json');
		echo json_encode($data );