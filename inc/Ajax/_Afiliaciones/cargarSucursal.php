<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	
	$idCliente = (!empty($_POST['idAfiliacion']))? $_POST['idAfiliacion'] : -500;
	$idSucursal = (!empty($_POST['idSucursal']))? $_POST['idSucursal'] : -500;
	$vieneDeNuevaSucursal = (isset($_POST['vieneDeNuevaSucursal']))? $_POST['vieneDeNuevaSucursal'] : NULL;
	$esSubcadena = isset( $_POST['esSubcadena'] )? $_POST['esSubcadena'] : -500;
	
	/*if ( empty($idSubcadena) ) {
		$idSubcadena = -500;
	}*/	
	
	//var_dump("vieneDeNuevaSucursal: $vieneDeNuevaSucursal");
	if ( $idCliente <= 0 ) {
		echo json_encode( array( "codigo" => 1,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un ID de Cliente" ) );
		exit();
	}
	
	if ( $idSucursal <= 0 ) {
		echo json_encode( array( "codigo" => 2,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un ID de Sucursal" ) );
		exit();
	}
		
	/*var_dump("idAfiliacion: $idAfiliacion");
	var_dump("idSucursal: $idSucursal");*/
	
	if ( !$vieneDeNuevaSucursal ) {
		$afiliacionCliente = new AfiliacionCliente( $RBD, $WBD, $LOG );
		$afiliacionCliente->load( $idCliente );
		
		if ( $afiliacionCliente->ERROR_CODE == 0 ) {
			$afiliacion = new AfiliacionSucursal2( $RBD, $WBD, $LOG );
			$afiliacion->load( $idCliente );
			if ( $afiliacion->ERROR_CODE == 0 ) {
				$sucursal = $afiliacion->getSucursal( $idSucursal );
				if ( isset( $sucursal ) ) {
					echo json_encode( array( "codigo" => 0,
					"sucursal" => $sucursal,
					"tipoFORELO" => $afiliacionCliente->TIPOFORELO,
					//"tipoFORELO" => $idTipoForelo,
					"mensaje" => "Sucursal cargada exitosamente" ) );
					exit();
				} else {
					echo json_encode( array( "codigo" => 5,
					"mensaje" => "No se encontro la Sucursal" ) );
					exit();		
				}
			} else {
				echo json_encode( array( "codigo" => 4,
				"mensaje" => "No fue posible consultar la base de datos para cargar la Sucursal: ".$afiliacion->ERROR_MSG ) );
				exit();	
			}
		} else {
			echo json_encode( array( "codigo" => 3,
			"mensaje" => "No fue posible consultar la base de datos para cargar la Afiliacion: ".$afiliacionCliente->ERROR_MSG ) );
			exit();	
		}
	} else {
		
		$afiliacionCliente = new AfiliacionCliente( $RBD, $WBD, $LOG );
		$afiliacionCliente->loadClienteReal( $idCliente, $esSubcadena );		
			
		$afiliacion = new AfiliacionSucursal2( $RBD, $WBD, $LOG );
		$afiliacion->loadClienteReal( $idCliente );			
		
		if ( $afiliacion->ERROR_CODE == 0 ) {
			$sucursal = $afiliacion->getSucursal( $idSucursal );
			if ( isset( $sucursal ) ) {
				echo json_encode( array( "codigo" => 0,
				"sucursal" => $sucursal,
				"tipoFORELO" => $afiliacionCliente->TIPOFORELO,
				"mensaje" => "Sucursal cargada exitosamente" ) );
				exit();
			} else {
				echo json_encode( array( "codigo" => 5,
				"mensaje" => "No se encontro la Sucursal" ) );
				exit();		
			}
		} else {
			echo json_encode( array( "codigo" => 4,
			"mensaje" => "No fue posible consultar la base de datos para cargar la Sucursal: ".$afiliacion->ERROR_MSG ) );
			exit();	
		}
		/*} else {
			echo json_encode( array( "codigo" => 3,
			"mensaje" => "No fue posible consultar la base de datos para cargar la Afiliacion: ".$afiliacionCliente->ERROR_MSG ) );
			exit();	
		}*/
	}
?>
