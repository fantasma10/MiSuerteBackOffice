<?php
	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	
	$idContacto = !empty( $_POST['idContacto'] )? $_POST['idContacto'] : -500;
	$idCliente = !empty( $_POST['idAfiliacion'] )? $_POST['idAfiliacion'] : -500;
	$idSucursal = !empty( $_POST['idSucursal'] )? $_POST['idSucursal'] : -500;
	
	//var_dump("idSucursal: $idSucursal");
	
	if ( $idContacto <= 0 ) {
		echo json_encode( array( "codigo" => 9,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un ID de contacto" ) );
		exit();
	}
	
	if ( $idSucursal <= 0 ) {
		echo json_encode( array( "codigo" => 11,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un ID de sucursal" ) );
		exit();
	}	
	
	$afiliacion = new AfiliacionSucursal2($RBD, $WBD, $LOG);
	$afiliacion->load($idCliente);
	
	if ( $afiliacion->ERROR_CODE == 0 ) {
		$contacto = array(
					"id" => $idContacto,
					"idContacto" => 'NULL',
					"idTipo" => 'NULL',
					"nombre" => 'NULL',
					"apellidoPaterno" => 'NULL',
					"apellidoMaterno" => 'NULL',
					"telefono" => 'NULL',
					"extension" => 'NULL',
					"correo" => 'NULL',
					"idEstatus" => 3
				);
		$resEditarContacto = $afiliacion->editarContacto( $idSucursal, $contacto );
		if ( $resEditarContacto['success'] ) {
			$resEditarCorresponsalContacto = $afiliacion->editarCorresponsalContacto( $idSucursal, $contacto );
			if ( $resEditarCorresponsalContacto['success'] ) {
				$afiliacion->prepararSucursal($idSucursal);
				echo json_encode( array( "codigo" => 0, "idCorresponsal" => $resEditarContacto["data"]["idContacto"], "mensaje" => "Contacto eliminado exitosamente." ) );
			} else {
				echo json_encode( array( "codigo" => 14, "mensaje" => "Error al actualizar asociacion entre Corresponsal y Contacto: ".$afiliacion->ERROR_MSG ) );
			}
		} else {
			echo json_encode( array( "codigo" => 13, "mensaje" => "Error al actualizar el Contacto: {$resEditarContacto['errmsg']}" ) );
		}
	} else {
		echo json_encode( array( "codigo" => 10, "mensaje" => "Error al cargar la Sucursal: ".$afiliacion->ERROR_MSG ) );
	}
?>