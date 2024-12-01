<?php

	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	
	$idCliente = !empty( $_POST['idAfiliacion'] )? $_POST['idAfiliacion'] : -500;
	$idSucursal = !empty( $_POST['idSucursal'] )? $_POST['idSucursal'] : -500;
	$vieneDeNuevaSucursal = (isset($_POST['vieneDeNuevaSucursal']))? $_POST['vieneDeNuevaSucursal'] : NULL;
	$esSubcadena = isset( $_POST['esSubcadena'] )? $_POST['esSubcadena'] : -500;

	if ( $idCliente <= 0 ) {
		echo json_encode( array( "codigo" => 2,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un ID de Afiliacion" ) );
		exit();
	}	
	
	if ( $idSucursal <= 0 ) {
		echo json_encode( array( "codigo" => 1,
		"mensaje" => "No es posible eliminar los datos porque falta proporcionar un ID de Sucursal" ) );
		exit();
	}	
	
	$oCliente = new AfiliacionCliente( $RBD, $WBD, $LOG );
	if ( !$vieneDeNuevaSucursal ) {
		$oCliente->load($idCliente);
		$sql = $RBD->query("CALL `afiliacion`.`SP_COSTO_FIND`(".$oCliente->IDCOSTO.", ".$oCliente->IDNIVEL.")");
		$res = mysqli_fetch_assoc($sql);
		if ( mysqli_num_rows($sql) > 0 ) {
			if ( $res['codigo'] == -500 ) {
				echo json_encode( array( "codigo" => 98, "mensaje" => 'No es posible eliminar la sucursal porque es necesario que el cliente tenga un expediente definido.' ) );
				exit();
			}			
			if ( $oCliente->TIPOFORELO != $res['idTipoForelo'] ) {
				echo json_encode( array( "codigo" => 99, "mensaje" => utf8_encode('No es posible eliminar la sucursal porque su configuración de costos es inválida.') ) );
				exit();
			}
			$cobroA		= (!empty($res['CobroA']))? $res['CobroA'] : 0;
			$tipoCobro	= (!empty($res['TipoCobro']))? $res['TipoCobro'] : 0;
			if ( $oCliente->TIPOFORELO == 2 && $tipoCobro == 1 ) {
				echo json_encode( array( "codigo" => 94, "mensaje" => 'La configuracion de costos es incorrecta. Favor de contactar al departamento de Comercial' ) );
				exit();
			}
		}else{
			echo json_encode( array( "codigo" => 100, "mensaje" => utf8_encode('No es posible eliminar la sucursal porque su configuración de costos es inválida.') ) );
			exit();
		}
	} else {
		$oCliente->loadClienteReal($idCliente, $esSubcadena);
		$sql = $RBD->query("CALL `afiliacion`.`SP_COSTO_FIND`(".$oCliente->IDCOSTO.", ".$oCliente->IDNIVEL.")");
		$res = mysqli_fetch_assoc($sql);
		if ( mysqli_num_rows($sql) > 0 ) {
			if ( $res['codigo'] == -500 ) {
				echo json_encode( array( "codigo" => 95, "mensaje" => 'No es posible eliminar la sucursal porque es necesario que el cliente tenga un expediente definido.' ) );
				exit();
			}			
			if ( $oCliente->TIPOFORELO != $res['idTipoForelo'] ) {
				echo json_encode( array( "codigo" => 96, "mensaje" => utf8_encode('No es posible eliminar la sucursal porque su configuración de costos es inválida.') ) );
				exit();
			}
		}else{
			echo json_encode( array( "codigo" => 97, "mensaje" => utf8_encode('No es posible eliminar la sucursal porque su configuración de costos es inválida.') ) );
			exit();
		}
	}
	
	if ( $oCliente->ERROR_CODE != 0 ) {
		echo json_encode( array( "codigo" => 13, "mensaje" => "Error al cargar la Sucursal: ".$oCliente->ERROR_MSG ) );
		exit();
	}	
	
	$afiliacion = new AfiliacionSucursal2( $RBD, $WBD, $LOG );
	if ( !$vieneDeNuevaSucursal ) {
		$afiliacion->load($idCliente);
	} else {
		$afiliacion->loadClienteReal($idCliente);
	}
	
	if ( $afiliacion->ERROR_CODE == 0 ) {
		if ( $oCliente->TIPOFORELO == 1 ) {
			$sucursal = $afiliacion->getSucursal( $idSucursal );
			if ( isset($sucursal) ) {
				$sucursal["idEstatus"] = 2;
				$sucursal["NombreSucursal"] = 'NULL';
				$sucursal["Telefono"] = 'NULL';
				$sucursal["Correo"] = 'NULL';
				$sucursal["FecActivacion"] = 'NULL';
				$resEditarSucursal = $afiliacion->editarSucursal( $idSucursal, $sucursal );		
				if ( $resEditarSucursal["success"] ) {
					$resEliminarDireccion = $afiliacion->eliminarDireccion( $sucursal["idDir"] );
					if ( $resEliminarDireccion["success"] ) {
						$afiliacion->ID_SUCURSAL_ACTIVA = $idSucursal;
						$resActualizarCuotas = $afiliacion->actualizarCuotas();
						if ( $resActualizarCuotas["success"] ) {
							echo json_encode( array( "codigo" => 0, "mensaje" => "Sucursal agregada exitosamente" ) );
						} else {
							echo json_encode( array( "codigo" => 80, "mensaje" => "Error al actualizar las Cuotas: ".utf8_encode($resActualizarCuotas['errmsg']) ) );
						}
						//echo json_encode( array( "codigo" => 0, "mensaje" => "Sucursal eliminada exitosamente" ) );
					} else {
						echo json_encode( array( "codigo" => 6, "mensaje" => "Error al eliminar la Sucursal: {$resEliminarDireccion['errmsg']}" ) );
					}
				} else {
					echo json_encode( array( "codigo" => 5, "mensaje" => "Error al editar la Sucursal: {$resEditarSucursal['errmsg']}" ) );
				}
			} else {
				echo json_encode( array( "codigo" => 4, "mensaje" => "No se encontro Sucursal" ) );
			}
		} else if ( $oCliente->TIPOFORELO == 2 ) {
			$sucursal = $afiliacion->getSucursal( $idSucursal );
			if ( isset($sucursal) ) {
				$sucursal["idEstatus"] = 2;
				$sucursal["NombreSucursal"] = 'NULL';
				$sucursal["Telefono"] = 'NULL';
				$sucursal["Correo"] = 'NULL';
				$sucursal["FecActivacion"] = 'NULL';
				$resEditarSucursal = $afiliacion->editarSucursal( $idSucursal, $sucursal );		
				if ( $resEditarSucursal["success"] ) {
					$resEliminarDireccion = $afiliacion->eliminarDireccion( $sucursal["idDir"] );
					if ( $resEliminarDireccion["success"] ) {
						$idFORELO = $sucursal["idForelo"];
						$resEliminarForelo = $afiliacion->eliminarForelo( $idFORELO );
						if ( $resEliminarForelo["success"] ) {
							$oCuenta = new AfiliacionCuenta( $RBD, $WBD, $LOG );
							$oCuenta->IDCUENTA = $sucursal["idCuentaBanco"];
							$resEliminarCuenta = $oCuenta->eliminarCuenta();
							if ( $resEliminarCuenta["success"] ) {
								$resEliminarCuota = $afiliacion->eliminarCuota( $idSucursal );
								if ( $resEliminarCuota["success"] ) {
									echo json_encode( array( "codigo" => 0, "mensaje" => "Sucursal eliminada exitosamente" ) );
								} else {
									echo json_encode( array( "codigo" => 81, "mensaje" => "Error al actualizar las Cuotas: {$resEliminarCuota['errmsg']}" ) );
								}								
								//echo json_encode( array( "codigo" => 0, "mensaje" => "Sucursal eliminada exitosamente" ) );
							} else {
								echo json_encode( array( "codigo" => 19, "mensaje" => "Error al eliminar la Sucursal: {$resEliminarCuenta['errmsg']}" ) );
							}
							//echo json_encode( array( "codigo" => 0, "mensaje" => "Sucursal eliminada exitosamente" ) );
						} else {
							echo json_encode( array( "codigo" => 18, "mensaje" => "Error al eliminar la Sucursal: {$resEliminarForelo['errmsg']}" ) );
						}
						//echo json_encode( array( "codigo" => 0, "mensaje" => "Sucursal eliminada exitosamente" ) );
					} else {
						echo json_encode( array( "codigo" => 17, "mensaje" => "Error al eliminar la Sucursal: {$resEliminarDireccion['errmsg']}" ) );
					}
				} else {
					echo json_encode( array( "codigo" => 16, "mensaje" => "Error al editar la Sucursal: {$resEditarSucursal['errmsg']}" ) );
				}
			} else {
				echo json_encode( array( "codigo" => 15, "mensaje" => "No se encontro Sucursal" ) );
			}
		}
	} else {
		echo json_encode( array( "codigo" => 14, "mensaje" => "Error al cargar las Sucursales: ".$afiliacion->ERROR_MSG ) );
	}
?>
