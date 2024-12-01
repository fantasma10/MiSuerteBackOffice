<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	
	$idCliente		= !empty( $_POST['idCliente'] )? $_POST['idCliente'] : 0;
	$idExpediente	= !empty( $_POST['idExpediente'] )? $_POST['idExpediente'] : 0;
	$nuevasFamilias	= !empty( $_POST['familias'] )? $_POST['familias'] : null;
	
	if ( $idCliente <= 0 ) {
		echo json_encode(array(
			"showMsg"	=> 1,
			"msg"		=> "Cliente inválido"
		));
		exit();
	}

	if ( $idExpediente <= 0 ) {
		echo json_encode(array(
			"showMsg"	=> 1,
			"msg"		=> "Realice de nuevo la selección"
		));
		exit();
	}
	
	if (!isset($nuevasFamilias) ) {
		echo json_encode(array(
			"showMsg" => 1,
			"mensaje" => "No es posible guardar los datos porque falta proporcionar las familias seleccionadas"
		));
		exit();	
	}
	
	$cliente = new Cliente($RBD, $WBD, $LOG);
	$cliente->load($idCliente);
	
	if ($cliente->ERROR_CODE == 0 ) {
		$familiasGuardadas		= explode(",", $cliente->FAMILIAS);
		$listaNuevasFamilias	= $nuevasFamilias;
		$nuevasFamilias			= explode(",", $nuevasFamilias);
		$listaFamilias			= $cliente->FAMILIAS;
		
		//Dar de baja aquellas familias no presentes en nuevasFamilias
		$QUERY = "CALL `redefectiva`.`SP_CLIENTEFAMILIAS_UPDATE`($cliente->ID_CLIENTE, '$listaNuevasFamilias', 3)";
		$WBD->query($QUERY);
		if($WBD->error()){
			echo json_encode(array(
				"showMsg"	=> 1,
				"mensaje"	=> "Error al asociar dar de baja familias del Cliente: ",
				"errmsg"	=> $WBD->error()
			));
			exit();
		}
		else{
			$response = array(
				'showMsg'	=> 1,
				'msg'		=> 'Operación Exitosa'
			);
		}
		
		//Insertar nuevas familias que pudiesen llegar a existir
		foreach($nuevasFamilias as $nuevaFamilia){
			if ( !in_array($nuevaFamilia, $familiasGuardadas) ) {
				$QUERY = "CALL `redefectiva`.`SP_CLIENTEFAMILIA_CREAR`($cliente->ID_CLIENTE, $nuevaFamilia)";
				$WBD->query($QUERY);
				if ( $WBD->error() ) {
					echo json_encode(array(
						"showMsg"	=> 1,
						"mensaje"	=> "Error al asociar una nueva familia con el Cliente",
						"errmsg"	=> $WBD->error()
					));
					$error = true;
					break;
				}
				else{
					$response = array(
						'showMsg'	=> 1,
						'msg'		=> 'Operación Exitosa'
					);
				}				
			}
		}

		$cliente->ID_NIVEL = $idExpediente;
		$resp = $cliente->guardarDatosGenerales();

		if($resp['success'] == true){
			$siguiente = 2;
			$response = array(
				'showMsg'	=> 1,
				'msg'		=> 'Operacion Exitosa',
				'errmsg'	=> '',
				'success'	=> true
			);
		}
		else{
			$response = array(
				'showMsg'	=> 1,
				'msg'		=> 'Ha ocurrido un error, inténtelo nuevamente',
				'errmsg'	=> $resp['errmsg'],
				'tip'		=> "generales"
			);
		}

		echo json_encode($response);
			
	}
	else{
		echo json_encode(array(
			"showMsg"	=> 1,
			"msg"		=> "Error al cargar el Cliente: ".$cliente->ERROR_MSG ) );
	}
?>