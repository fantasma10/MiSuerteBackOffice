<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	
	$idCliente = !empty( $_POST['idAfiliacion'] )? $_POST['idAfiliacion'] : -500;
	$idSucursal = !empty( $_POST['idSucursal'] )? $_POST['idSucursal'] : -500;
	
	if ( $idCliente <= 0 ) {
		echo json_encode( array( "codigo" => 1,
		"mensaje" => "No es posible cargar los datos porque falta proporcionar un ID de Cliente" ) );
		exit();
	}		
	
	/*var_dump("idCliente: $idCliente");
	var_dump("idSucursal: $idSucursal");*/
	
	$afiliacion = new AfiliacionSucursal2($RBD, $WBD, $LOG);
	$afiliacion->load($idCliente);
	
	if ( $afiliacion->ERROR_CODE == 0 ) {
		$resContactos = $afiliacion->getContactos( $idSucursal );
		if ( $resContactos["success"] ) {
			$contactos = $resContactos["data"]["contactos"];
			$indice = 0;
			/*echo "<pre>";
			print_r($contactos);
			echo "</pre>";*/
			foreach( $contactos as $contacto ) {
				$contactos[$indice]["descTipoContacto"] = (!preg_match('!!u',$contacto["descTipoContacto"]))? utf8_encode($contacto["descTipoContacto"]) : $contacto["descTipoContacto"];
				$contactos[$indice]["Nombre"] = (!preg_match('!!u',$contacto["Nombre"]))? utf8_encode($contacto["Nombre"]) : $contacto["Nombre"];
				$contactos[$indice]["Paterno"] = (!preg_match('!!u',$contacto["Paterno"]))? utf8_encode($contacto["Paterno"]) : $contacto["Paterno"];
				$contactos[$indice]["Materno"] = (!preg_match('!!u',$contacto["Materno"]))? utf8_encode($contacto["Materno"]) : $contacto["Materno"];
				$indice++;
			}
			echo json_encode( array( "codigo" => 0, "contactos" => $contactos, "idSucursal" => $idSucursal, "mensaje" => "Contactos cargados exitosamente" ) );
		} else {
			echo json_encode( array( "codigo" => 1, "mensaje" => "No se encontro Sucursal" ) );
		}
	} else {
		echo json_encode( array( "codigo" => 1, "mensaje" => "Error al cargar la Sucursal: ".$afiliacion->ERROR_MSG ) );
	}
?>
