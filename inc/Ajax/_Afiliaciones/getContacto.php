<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	
	$idCliente = !empty( $_POST['idAfiliacion'] )? $_POST['idAfiliacion'] : -500;
	$idContacto = !empty( $_POST['idContacto'] )? $_POST['idContacto'] : -500;
	$idSucursal = !empty( $_POST['idSucursal'] )? $_POST['idSucursal'] : -500;
	
	if ( $idCliente <= 0 ) {
		echo json_encode( array( "codigo" => 1,
		"mensaje" => "No es posible cargar los datos porque falta proporcionar un ID de Afiliacion" ) );
		exit();
	}
	
	if ( $idContacto <= 0 ) {
		echo json_encode( array( "codigo" => 3,
		"mensaje" => "No es posible cargar los datos porque falta proporcionar un ID de Contacto" ) );
		exit();
	}
	
	if ( $idSucursal <= 0 ) {
		echo json_encode( array( "codigo" => 3,
		"mensaje" => "No es posible cargar los datos porque falta proporcionar un ID de Sucursal" ) );
		exit();
	}
	
	$afiliacion = new AfiliacionSucursal2($RBD, $WBD, $LOG);
	$afiliacion->load($idCliente);
	
	if ( $afiliacion->ERROR_CODE == 0 ) {
		$resContactos = $afiliacion->getContactos($idSucursal);
		if ( $resContactos["success"] ) {
			$contactos = $resContactos["data"]["contactos"];
			foreach( $contactos as $contacto ) {
				$contacto["Nombre"] = utf8_encode($contacto["Nombre"]);
				$contacto["Paterno"] = utf8_encode($contacto["Paterno"]);
				$contacto["Materno"] = utf8_encode($contacto["Materno"]);
				if ( $contacto["id"] == $idContacto ) {
					$contactoRequerido = $contacto;
				}
			}
			if ( isset($contactoRequerido) ) {
				echo json_encode( array( "codigo" => 0, "contacto" => $contactoRequerido, "mensaje" => "Contacto cargado exitosamente" ) );
			} else {
				echo json_encode( array( "codigo" => 4, "mensaje" => "No se encontro el Contacto" ) );
			}			
		} else {
			echo json_encode( array( "codigo" => 5, "mensaje" => "Error al cargar contactos de la Sucursal: {$resContactos['errmsg']}" ) );
		}
	} else {
		echo json_encode( array( "codigo" => 4, "mensaje" => "Error al cargar la Sucursal: ".$afiliacion->ERROR_MSG ) );
	}
	
	//if ( $afiliacion->ERROR_CODE == 0 ) {
		//$contacto = $afiliacion->getContactos($);
		/*$contactos = $afiliacion->CONTACTOSINFO;
		$contactoRequerido = NULL;
		foreach ( $contactos as $contacto ) {
			if ( $contacto["id"] == $idContacto ) {
				$contactoRequerido = $contacto;
			}
		}
		if ( isset($contactoRequerido) ) {
			echo json_encode( array( "codigo" => 0, "contacto" => $contactoRequerido, "mensaje" => "Contacto cargado exitosamente" ) );
		} else {
			echo json_encode( array( "codigo" => 4, "mensaje" => "No se encontro el Contacto" ) );
		}*/
	//} else {
		//echo json_encode( array( "codigo" => 1, "mensaje" => "Error al cargar la Sucursal: ".$afiliacion->ERROR_MSG ) );
	//}
?>