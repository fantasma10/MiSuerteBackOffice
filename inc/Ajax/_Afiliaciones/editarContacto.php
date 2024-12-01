<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	
	$idContacto = !empty( $_POST['idContacto'] )? $_POST['idContacto'] : -500;
	$idCliente = !empty( $_POST['idAfiliacion'] )? $_POST['idAfiliacion'] : -500;
	$idSucursal = !empty( $_POST['idSucursal'] )? $_POST['idSucursal'] : -500;
	$nombre = !empty( $_POST['nombre'] )? $_POST['nombre'] : NULL;
	$apellidoPaterno = !empty( $_POST['apellidoPaterno'] )? $_POST['apellidoPaterno'] : NULL;
	$apellidoMaterno = !empty( $_POST['apellidoMaterno'] )? $_POST['apellidoMaterno'] : NULL;
	$telefono = !empty( $_POST['telefono'] )? $_POST['telefono'] : NULL;
	$extension = !empty( $_POST['extension'] )? $_POST['extension'] : NULL;
	$correo = !empty( $_POST['correo'] )? $_POST['correo'] : NULL;
	$tipo = !empty( $_POST['tipo'] )? $_POST['tipo'] : -500;
	
	//var_dump("telefono: $telefono");
	
	/*var_dump("idContacto: $idContacto");
	var_dump("idCliente: $idCliente");
	var_dump("idSucursal: $idSucursal");
	var_dump("nombre: $nombre");
	var_dump("apellidoPaterno: $apellidoPaterno");
	var_dump("apellidoMaterno: $apellidoMaterno");
	var_dump("telefono: $telefono");
	var_dump("extension: $extension");
	var_dump("correo: $correo");
	var_dump("tipo: $tipo");*/
	
	if ( $idContacto <= 0 ) {
		echo json_encode( array( "codigo" => 9,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un ID de contacto" ) );
		exit();
	}	
	
	if ( $idCliente <= 0 ) {
		echo json_encode( array( "codigo" => 8,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un ID de afiliacion" ) );
		exit();
	}	
	
	if ( !isset($nombre) ) {
		echo json_encode( array( "codigo" => 1,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un nombre de contacto" ) );
		exit();
	}
	
	if ( !isset($apellidoPaterno) ) {
		echo json_encode( array( "codigo" => 2,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un apellido paterno de contacto" ) );
		exit();
	}
	
	if ( !isset($apellidoMaterno) ) {
		echo json_encode( array( "codigo" => 3,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un apellido materno de contacto" ) );
		exit();
	}
	
	if ( !isset($telefono) ) {
		echo json_encode( array( "codigo" => 4,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un telefono de contacto" ) );
		exit();
	}
	
	if ( !isset($extension) ) {
		/*echo json_encode( array( "codigo" => 5,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar una extension de contacto" ) );
		exit();*/
		$extension = "";
	}
	
	if ( !isset($correo) ) {
		echo json_encode( array( "codigo" => 6,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un correo de contacto" ) );
		exit();
	}
	
	if ( $tipo <= 0 ) {
		echo json_encode( array( "codigo" => 7,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un tipo de contacto" ) );
		exit();
	}
	
	$afiliacion = new AfiliacionSucursal2( $RBD, $WBD, $LOG );
	$afiliacion->load( $idCliente );
	
	if ( $afiliacion->ERROR_CODE == 0 ) {
		$contacto = array(
					"id" => $idContacto,
					"idContacto" => 'NULL',
					"idTipo" => $tipo,
					"nombre" => "'".utf8_decode($nombre)."'",
					"apellidoPaterno" => "'".utf8_decode($apellidoPaterno)."'",
					"apellidoMaterno" => "'".utf8_decode($apellidoMaterno)."'",
					"telefono" => "'$telefono'",
					"extension" => "'$extension'",
					"correo" => "'$correo'",
					"idEstatus" => 1
				);
		$resEditarContacto = $afiliacion->editarContacto( $idCliente, $contacto );
		if ( $resEditarContacto['success'] ) {
			echo json_encode( array( "codigo" => 0, "idCorresponsal" => $resEditarContacto["data"]["idContacto"], "mensaje" => "Contacto guardado exitosamente." ) );
		} else {
			echo json_encode( array( "codigo" => 1, "mensaje" => "Error al actualizar Contacto: {$resEditarContacto['errmsg']}" ) );
		}
	} else {
		echo json_encode( array( "codigo" => 10, "mensaje" => "Error al cargar la Sucursal: ".$afiliacion->ERROR_MSG ) );
	}
	
	/*$afiliacion = new AfiliacionSucursal2( $RBD, $WBD, $LOG );
	$afiliacion->load( $idAfiliacion );
	
	if ( $afiliacion->ERROR_CODE == 0 ) {
		if ( isset($afiliacion->IDSUCURSALTEMPORAL) ) {			
			if ( $idSucursal < 0 ) {
				$contacto = array(
							"idContacto" => $idContacto,
							"idTipo" => $tipo,
							"nombre" => "'".utf8_decode($nombre)."'",
							"apellidoPaterno" => "'".utf8_decode($apellidoPaterno)."'",
							"apellidoMaterno" => "'".utf8_decode($apellidoMaterno)."'",
							"telefono" => "'$telefono'",
							"extension" => "'$extension'",
							"correo" => "'$correo'",
							"idEstatus" => 1
						);
				$resEditarContacto = $afiliacion->editarContacto( NULL, $contacto );
				if ( $resEditarContacto['success'] ) {
					echo json_encode( array( "codigo" => 0, "idCorresponsal" => $resEditarContacto["data"]["idContacto"], "mensaje" => "Contacto guardado exitosamente." ) );
				} else {
					echo json_encode( array( "codigo" => 1, "mensaje" => "Error al actualizar Contacto: {$resEditarContacto['errmsg']}" ) );
				}
			} else {
				$contacto = array(
							"idContacto" => $idContacto,
							"idTipo" => $tipo,
							"nombre" => "'".utf8_decode($nombre)."'",
							"apellidoPaterno" => "'".utf8_decode($apellidoPaterno)."'",
							"apellidoMaterno" => "'".utf8_decode($apellidoMaterno)."'",
							"telefono" => "'$telefono'",
							"extension" => "'$extension'",
							"correo" => "'$correo'",
							"idEstatus" => 0
						);
				$resEditarContacto = $afiliacion->editarContacto( $idSucursal, $contacto );
				if ( $resEditarContacto['success'] ) {
					echo json_encode( array( "codigo" => 0, "idCorresponsal" => $resEditarContacto["data"]["idContacto"], "mensaje" => "Contacto guardado exitosamente." ) );
				} else {
					echo json_encode( array( "codigo" => 12, "mensaje" => "Error al actualizar Contacto: {$resEditarContacto['errmsg']}" ) );
				}			
			}			
		} else {
			if ( $idSucursal <= 0 ) {
				echo json_encode( array( "codigo" => 11,
				"mensaje" => "No es posible actualizar los datos porque falta proporcionar un ID de Sucursal" ) );
				exit();
			}			
			$contacto = array(
						"idContacto" => $idContacto,
						"idTipo" => $tipo,
						"nombre" => "'".utf8_decode($nombre)."'",
						"apellidoPaterno" => "'".utf8_decode($apellidoPaterno)."'",
						"apellidoMaterno" => "'".utf8_decode($apellidoMaterno)."'",
						"telefono" => "'$telefono'",
						"extension" => "'$extension'",
						"correo" => "'$correo'",
						"idEstatus" => 0
					);
			$resEditarContacto = $afiliacion->editarContacto( $idSucursal, $contacto );
			if ( $resEditarContacto['success'] ) {
				echo json_encode( array( "codigo" => 0, "idCorresponsal" => $resEditarContacto["data"]["idContacto"], "mensaje" => "Contacto guardado exitosamente." ) );
			} else {
				echo json_encode( array( "codigo" => 12, "mensaje" => "Error al actualizar Contacto: {$resEditarContacto['errmsg']}" ) );
			}		
		}
	} else {
		echo json_encode( array( "codigo" => 10, "mensaje" => "Error al cargar la Sucursal: ".$afiliacion->ERROR_MSG ) );
	}*/
?>
