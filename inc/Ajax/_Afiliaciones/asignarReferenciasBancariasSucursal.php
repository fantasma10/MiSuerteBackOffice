<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	
	$idCliente = !empty( $_POST['idAfiliacion'] )? $_POST['idAfiliacion'] : -500;
	
	if ( $idCliente <= 0 ) {
		echo json_encode( array( "codigo" => 1,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un nombre de Sucursal" ) );
		exit();
	}

	$cliente = new AfiliacionCliente( $RBD, $WBD, $LOG );
	$cliente->load( $idCliente );
	
	if ( $cliente->ERROR_CODE == 0 ) {
		$maximoPuntos = $cliente->MAXIMOPUNTOS;
		$tipoFORELO = $cliente->TIPOFORELO;
		//var_dump("maximoPuntos: $maximoPuntos");
		//var_dump("tipoFORELO: $tipoFORELO");
	} else {
		echo json_encode( array( "codigo" => 3, "mensaje" => "Error al cargar el Cliente: ".$cliente->ERROR_MSG ) );
		exit();	
	}
	
	if ( $tipoFORELO == 1 ) {
		echo json_encode( array( "codigo" => 0, "mensaje" => "Referencias Bancarias asignadas exitosamente" ) );
	} else if ( $tipoFORELO == 2 ) {

	}
	
	/*$afiliacionCliente = new AfiliacionCliente( $RBD, $WBD, $LOG );
	$afiliacionCliente->load( $idAfiliacion );
	
	if ( $afiliacionCliente->ERROR_CODE == 0 ) {
		$minimoPuntos = $afiliacionCliente->MINIMOPUNTOS;
	} else {
		echo json_encode( array( "codigo" => 3, "mensaje" => "Error al cargar la Sucursal: ".$afiliacionSucursal->ERROR_MSG ) );
		exit();
	}
	
	if ( $afiliacionCliente->TIPOFORELO == 2 ) {
		$afiliacionSucursal = new AfiliacionSucursal2( $RBD, $WBD, $LOG );
		$afiliacionSucursal->load( $idAfiliacion );
		
		if ( $afiliacionSucursal->ERROR_CODE == 0 ) {
			$sucursales = $afiliacionSucursal->SUCURSALES;
			if ( count($sucursales) >= $minimoPuntos ) {
				$errorReferencia = false;
				foreach( $sucursales as $sucursal ) {
					if ( $sucursal["idRefBancaria"] == "NULL" ) {
						$resCrearRefBancaria = $afiliacionSucursal->crearReferenciaBancaria();
						if ( $resCrearRefBancaria["success"] ) {
							$sucursal["idRefBancaria"] = $resCrearRefBancaria["data"]["idReferencia"];
							$sucursal["nombre"] = "'".utf8_decode($sucursal["nombre"])."'";
							$sucursal["telefono"] = "'".$sucursal["telefono"]."'";
							$resEditarDatosGenerales = $afiliacionSucursal->editarDatosGenerales( $sucursal["idSucursal"], $sucursal );
							if ( !$resEditarDatosGenerales["success"] ) {
								$errorReferencia = true;
							}
						} else {
							$errorReferencia = true;
						}
					}
				}
				if ( !$errorReferencia ) {
					echo json_encode( array( "codigo" => 0, "mensaje" => "Referencias Bancarias asignadas exitosamente" ) );
				} else {
					echo json_encode( array( "codigo" => 2, "mensaje" => "Error al asignar Referencias Bancarias a Sucursales" ) );
					exit();
				}
			} else {
				echo json_encode( array( "codigo" => 4, "mensaje" => "Para avanzar a la siguiente pantalla es necesario agregar al menos $minimoPuntos Sucursales" ) );
				exit();
			}
		} else {
			echo json_encode( array( "codigo" => 1, "mensaje" => "Error al cargar la Sucursal: ".$afiliacionSucursal->ERROR_MSG ) );
			exit();
		}
	} else if ( $afiliacionCliente->TIPOFORELO == 1 ) {
		$afiliacionSucursal = new AfiliacionSucursal2( $RBD, $WBD, $LOG );
		$afiliacionSucursal->load( $idAfiliacion );
		if ( $afiliacionSucursal->ERROR_CODE == 0 ) {
			$sucursales = $afiliacionSucursal->SUCURSALES;
			if ( count($sucursales) >= $minimoPuntos ) {
				echo json_encode( array( "codigo" => 0, "mensaje" => "Referencias Bancarias asignadas exitosamente" ) );
			} else {
				echo json_encode( array( "codigo" => 4, "mensaje" => "Para avanzar a la siguiente pantalla es necesario agregar al menos $minimoPuntos Sucursales" ) );
				exit();			
			}
		} else {
			echo json_encode( array( "codigo" => 5, "mensaje" => "Error al cargar la Sucursal: ".$afiliacionSucursal->ERROR_MSG ) );
			exit();		
		}		
	}*/	
?>
