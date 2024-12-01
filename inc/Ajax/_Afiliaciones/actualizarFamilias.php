<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	
	$idCliente = !empty( $_POST['idCliente'] )? $_POST['idCliente'] : -500;
	$nuevasFamilias = !empty( $_POST['nuevasFamilias'] )? $_POST['nuevasFamilias'] : NULL;
	$idNivel = !empty( $_POST['idNivel'] )? $_POST['idNivel'] : -500;
	
	if ( $idCliente <= 0 ) {
		echo json_encode( array( "codigo" => 1,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un nombre de Sucursal" ) );
		exit();
	}

	if ( $idNivel <= 0 ) {
		echo json_encode( array( "codigo" => 1,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un ID de Nivel" ) );
		exit();
	}
	
	if ( !isset($nuevasFamilias) ) {
		echo json_encode( array( "codigo" => 4,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar  las familias seleccionadas" ) );
		exit();	
	}
	
	$cliente = new AfiliacionCliente( $RBD, $WBD, $LOG );
	$cliente->load( $idCliente );
	
	if ( $cliente->ERROR_CODE == 0 ) {
		$familiasGuardadas = explode("|", $cliente->FAMILIAS);
		$listaNuevasFamilias = str_replace("|", ",", $nuevasFamilias);
		$nuevasFamilias = explode("|", $nuevasFamilias);
		$listaFamilias = str_replace("|", ",", $cliente->FAMILIAS);
		
		//Dar de baja aquellas familias no presentes en nuevasFamilias
		$QUERY = "CALL `afiliacion`.`SP_CLIENTEFAMILIAS_UPDATE`($cliente->ID_CLIENTE, '$listaNuevasFamilias', 3)";
		$WBD->query($QUERY);
		if ( $WBD->error() ) {
			echo json_encode( array( "codigo" => 3, "mensaje" => "Error al asociar dar de baja familias del cliente: ".$WBD->error() ) );
			exit();
		}
		
		//Insertar nuevas familias que pudiesen llegar a existir
		foreach( $nuevasFamilias as $nuevaFamilia ) {
			if ( !in_array($nuevaFamilia, $familiasGuardadas) ) {
				$QUERY = "CALL `afiliacion`.`SP_CLIENTEFAMILIA_CREAR`($cliente->ID_CLIENTE, $nuevaFamilia)";
				$WBD->query($QUERY);
				if ( $WBD->error() ) {
					echo json_encode( array( "codigo" => 2, "mensaje" => "Error al asociar una nueva familia con un cliente: ".$WBD->error() ) );
					$error = true;
					break;
				}				
			}
		}
		
		$nivelOriginal = $cliente->IDNIVEL;
		if($idNivel != $nivelOriginal){
			$cliente->IDCOSTO = 0;
			$cliente->MAXIMOPUNTOS = 0;
		}
		$cliente->IDNIVEL = $idNivel;
		$resGuardarDatosGenerales = $cliente->guardarDatosGenerales();

		if($idNivel != $nivelOriginal){
			$cliente->eliminarForelo();
		}
		$cliente->prepararCliente();
		
		$SUC = new AfiliacionSucursal2($RBD, $WBD, $LOG);
		$SUC->load($idCliente);
		$SUC->eliminarCuotas();		
		
		if ( $resGuardarDatosGenerales["success"] ) {
			echo json_encode( array( "codigo" => 0, "mensaje" => "Familias del cliente actualizadas exitosamente" ) );
		} else {
			echo json_encode( array( "codigo" => 10, "mensaje" => "Error al actualizar expediente de la sucursal: {$resGuardarDatosGenerales['errmsg']}" ) );
		}
		
	} else {
		echo json_encode( array( "codigo" => 1, "mensaje" => "Error al cargar la Sucursal: ".$cliente->ERROR_MSG ) );
	}
?>
