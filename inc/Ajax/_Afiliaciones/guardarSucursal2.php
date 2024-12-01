<?php

	error_reporting(0);
	ini_set('display_errors', 0);

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	
	$idCliente = !empty( $_POST['idCliente'] )? $_POST['idCliente'] : -500;
	$idSubcadena = isset( $_POST['idSubcadena'] )? $_POST['idSubcadena'] : -500;
	$nombreSucursal = !empty( $_POST['nombreSucursal'] )? $_POST['nombreSucursal'] : NULL;
	$idGiro = !empty( $_POST['idGiro'] )? $_POST['idGiro'] : -500;
	$idPais = !empty( $_POST['idPais'] )? $_POST['idPais'] : -500;
	$calle = !empty( $_POST['calle'] )? $_POST['calle'] : NULL;
	$numeroInterior = !empty( $_POST['numeroInterior'] )? $_POST['numeroInterior'] : NULL;
	$numeroExterior = !empty( $_POST['numeroExterior'] )? $_POST['numeroExterior'] : -500;
	$codigoPostal = !empty( $_POST['codigoPostal'] )? $_POST['codigoPostal'] : NULL;
	$idColonia = !empty( $_POST['idColonia'] )? $_POST['idColonia'] : -500;
	$idEstado = !empty( $_POST['idEstado'] )? $_POST['idEstado'] : -500;
	$idMunicipio = !empty( $_POST['idMunicipio'] )? $_POST['idMunicipio'] : -500;
	$telefono = !empty( $_POST['telefono'] )? $_POST['telefono'] : NULL;
	$idDireccion = isset( $_POST['idDireccion'] )? $_POST['idDireccion'] : NULL;
	$origen = isset( $_POST['origen'] )? $_POST['origen'] : NULL;
	$contactos = !empty( $_POST['contactos'] )? $_POST['contactos'] : NULL;
	$idLocalidad = isset( $_POST['idLocalidad'] )? $_POST['idLocalidad'] : -500;
	$comisiones = isset( $_POST['comisiones'] )? $_POST['comisiones'] : -500;
	$reembolso = isset( $_POST['reembolso'] )? $_POST['reembolso'] : -500;
	$CLABE = isset( $_POST['CLABE'] )? $_POST['CLABE'] : NULL;
	$idBanco = isset( $_POST['idBanco'] )? $_POST['idBanco'] : -500;
	$numCuenta = !empty( $_POST['numCuenta'] )? $_POST['numCuenta'] : NULL;
	$beneficiario = !empty( $_POST['beneficiario'] )? $_POST['beneficiario'] : NULL;
	$descripcion = !empty( $_POST['descripcion'] )? $_POST['descripcion'] : NULL;
	$esSubcadena = isset( $_POST['esSubcadena'] )? $_POST['esSubcadena'] : -500;

	//var_dump("idCliente: $idCliente");

	/*if ( empty($idSubcadena) ) {
		$idSubcadena = -500;
	}*/
	
	if ( $idSubcadena == "" ) {
		$idSubcadena = -500;
	}
		
	if ( $idCliente <= 0 ) {
		echo json_encode( array( "codigo" => 1,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un ID de Cliente" ) );
		exit();
	}	
	
	if ( !isset($nombreSucursal) ) {
		echo json_encode( array( "codigo" => 2,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un nombre de Sucursal" ) );
		exit();
	}
	
	if ( $idGiro <= 0 ) {
		echo json_encode( array( "codigo" => 3,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un Giro" ) );
		exit();
	}
	
	if ( $idPais <= 0 ) {
		echo json_encode( array( "codigo" => 4,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un Pais" ) );
		exit();
	}
	
	if ( !isset($calle) ) {
		echo json_encode( array( "codigo" => 5,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar una Calle" ) );
		exit();
	}	
	
	if ( !isset($numeroInterior) ) {
		$numeroInterior = "";
	}
	
	if ( $numeroExterior <= 0 || !is_numeric($numeroExterior) ) {
		echo json_encode( array( "codigo" => 7,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un Numero Exterior valido" ) );
		exit();
	}
	
	if ( !isset($codigoPostal) ) {
		echo json_encode( array( "codigo" => 8,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un Codigo Postal" ) );
		exit();
	}
	
	if ( $idColonia <= 0 ) {
		echo json_encode( array( "codigo" => 9,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar una Colonia" ) );
		exit();
	}
	
	if ( $idEstado <= 0 ) {
		echo json_encode( array( "codigo" => 10,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un Estado" ) );
		exit();
	}
	
	if ( $idMunicipio <= 0 ) {
		echo json_encode( array( "codigo" => 11,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un Municipio" ) );
		exit();
	}
	
	if ( !isset($telefono) ) {
		echo json_encode( array( "codigo" => 12,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un Telefono" ) );
		exit();
	}
	
	if ( $idDireccion < 0 ) {
		echo json_encode( array( "codigo" => 13,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un ID de Direccion" ) );
		exit();
	}
	
	if ( $idLocalidad < 0 ) {
		echo json_encode( array( "codigo" => 90,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un ID de Localidad" ) );
		exit();
	}	

	$oCliente = new AfiliacionCliente( $RBD, $WBD, $LOG );
	if ( $idSubcadena >= 0 ) {
		$oCliente->loadClienteReal($idCliente, $esSubcadena);
		$esClienteReal = true;
		$sql = $RBD->query("CALL `afiliacion`.`SP_COSTO_FIND`(".$oCliente->IDCOSTO.", ".$oCliente->IDNIVEL.")");
		$res = mysqli_fetch_assoc($sql);
		if ( mysqli_num_rows($sql) > 0 ) {
			if ( $res['codigo'] == -500 ) {
				echo json_encode( array( "codigo" => 95, "mensaje" => 'No es posible crear la sucursal porque es necesario que el cliente tenga un expediente definido.' ) );
				exit();
			}			
			if ( $oCliente->TIPOFORELO != $res['idTipoForelo'] ) {
				echo json_encode( array( "codigo" => 96, "mensaje" => utf8_encode('No es posible crear la sucursal porque su configuración de costos es inválida.') ) );
				exit();
			}
		}else{
			echo json_encode( array( "codigo" => 97, "mensaje" => utf8_encode('No es posible crear la sucursal porque su configuración de costos es inválida.') ) );
			exit();
		}
	} else {
		$oCliente->load($idCliente);
		$esClienteReal = false;
		$sql = $RBD->query("CALL `afiliacion`.`SP_COSTO_FIND`(".$oCliente->IDCOSTO.", ".$oCliente->IDNIVEL.")");
		$res = mysqli_fetch_assoc($sql);
		if ( mysqli_num_rows($sql) > 0 ) {
			if ( $res['codigo'] == -500 ) {
				echo json_encode( array( "codigo" => 98, "mensaje" => 'No es posible crear la sucursal porque es necesario que el cliente tenga un expediente definido.' ) );
				exit();
			}			
			if ( $oCliente->TIPOFORELO != $res['idTipoForelo'] ) {
				echo json_encode( array( "codigo" => 99, "mensaje" => utf8_encode('No es posible crear la sucursal porque su configuración de costos es inválida.') ) );
				exit();
			}
			$cobroA		= (!empty($res['CobroA']))? $res['CobroA'] : 0;
			$tipoCobro	= (!empty($res['TipoCobro']))? $res['TipoCobro'] : 0;
			if ( $oCliente->TIPOFORELO == 2 && $tipoCobro == 1 ) {
				echo json_encode( array( "codigo" => 94, "mensaje" => 'La configuracion de costos es incorrecta. Favor de contactar al departamento de Comercial' ) );
				exit();
			}
		}else{
			echo json_encode( array( "codigo" => 100, "mensaje" => utf8_encode('No es posible crear la sucursal porque su configuración de costos es inválida.') ) );
			exit();
		}
	}

	if ( $oCliente->ERROR_CODE != 0 ) {
		echo json_encode( array( "codigo" => 13, "mensaje" => "Error al cargar la Sucursal: ".$oCliente->ERROR_MSG ) );
		exit();
	}

	$oSucursal = new AfiliacionSucursal2( $RBD, $WBD, $LOG );

	if ( $idSubcadena >= 0 ) {
		$oSucursal->loadClienteReal($idCliente);
	} else {
		$oSucursal->load($idCliente);
	}

	$oSucursal->ES_CLIENTE_REAL = $esClienteReal;
	if ( $oSucursal->ERROR_CODE == 0 ) {
		if ( $oCliente->TIPOFORELO == 1 ) {
			$oCliente = new AfiliacionCliente( $RBD, $WBD, $LOG );
			if ( $idSubcadena >= 0 ) {
				$oCliente->loadClienteReal($idCliente, $esSubcadena);
			} else {
				$oCliente->load($idCliente);
			}

			if ( $oCliente->ERROR_CODE == 0 ) {
				$maximoPuntos = $oCliente->MAXIMOPUNTOS;
				if ( $maximoPuntos != 0 ) {
					$sucursalesArreglo = $oSucursal->SUCURSALES;
					$totalSucursales = count($sucursalesArreglo);
					if ( $totalSucursales >= $maximoPuntos ) {
						echo json_encode( array( "codigo" => 18, "mensaje" => utf8_encode("No es posible agregar más sucursales dado que ya se excedió el límite máximo permitido") ) );
						exit();
					}
				}
			} else {
				echo json_encode( array( "codigo" => 17, "mensaje" => "Error al cargar el Cliente: ".$oCliente->ERROR_MSG ) );
			}			

			$idCadena = $oCliente->IDCADENA;
			$version = $oCliente->IDVERSION;

			if ( $idSubcadena >= 0 ) {
				if ( $idSubcadena != "" ) {
					$idCliente = 0;
				}
			}

			if ( $idSubcadena == "" ) {
				$idSubcadena = 0;
			}
			
			if ( $idSubcadena == -500 ) {
				$idSubcadena = 0;
			}
			
			if ( count($contactos) > 0 ) {
				$idEstatusSucursal = 0;
			} else {
				$idEstatusSucursal = 1;
			}
			
			$sucursal = array(
				"idSucursal" => 0,
				"idCorresponsal" => 0,
				"idCliente" => $idCliente,
				"idSubCadena" => $idSubcadena,
				"idCadena" => $idCadena,
				"idEstatus" => $idEstatusSucursal,
				"idEmpleado" => 0,
				"idGrupo" => $oCliente->IDGRUPO,
				"idReferencia" => $oCliente->IDREFERENCIA,
				"idDireccion" => $idDireccion,
				"idVersion" => $version,
				"idGiro" => $idGiro,
				"idForelo" => 0,
				"NombreSucursal" => "'".utf8_decode($nombreSucursal)."'",
				"Telefono" => "'".$telefono."'",
				"Correo" => "'".$correo."'",
				"Calle" => "'".utf8_decode($calle)."'",
				"NumInt" => "'".$numeroInterior."'",
				"NumExt" => "'".$numeroExterior."'",
				"idPais" => $idPais,
				"idEntidad" => $idEstado,
				"idMunicipio" => $idMunicipio,
				"idLocalidad" => $idLocalidad,
				"idColonia" => $idColonia,
				"codigoPostal" => $codigoPostal,
				"idEstatusCuenta" => 0,
				"idBanco" => 0,
				"NumCuenta" => 'NULL',
				"CLABE" => 'NULL',
				"Beneficiario" => 'NULL',
				"Descripcion" => 'NULL',
				"idEstatusFORELO" => 'NULL',
				"idComisiones" => 'NULL',
				"idReembolso" => 0,
				"ReferenciaBanco" => 'NULL',
				"FecActivacion" => "'0000-00-00 00:00:00'",
				"idTipoDir" => 1
			);
			if ( $origen == 0 ) {
				$resCrearDireccion["success"] = true;
				$resCrearDireccion["data"]["idDireccion"] = $idDireccion;
			} else if ( $origen == 1 ) {
				$resCrearDireccion = $oSucursal->crearDireccion( NULL, $sucursal );
			}
			//$resCrearDireccion = $oSucursal->crearDireccion( NULL, $sucursal );
			if ( $resCrearDireccion["success"] ) {
				$idDireccion = $resCrearDireccion["data"]["idDireccion"];
				$sucursal["idDireccion"] = $idDireccion;
				$resCrearSucursal = $oSucursal->crearSucursal( NULL, $sucursal );
				if ( $resCrearSucursal["success"] ) {
					$idSucursal = $resCrearSucursal["data"]["idSucursal"];
					foreach( $contactos as $contacto ) {
						$contacto["idEstatus"] = 1;
						$contacto["nombre"] = utf8_decode($contacto["nombre"]);
						$contacto["apellidoPaterno"] = utf8_decode($contacto["apellidoPaterno"]);
						$contacto["apellidoMaterno"] = utf8_decode($contacto["apellidoMaterno"]);
						$resAgregarContacto = $oSucursal->agregarContacto( $idSucursal, $contacto );
						if ( !$resAgregarContacto["success"] ) {
							echo json_encode( array( "codigo" => 16, "mensaje" => "Error al agregar Contacto: {$resAgregarContacto['errmsg']}" ) );
							break;
						}
					}

					if ( $oSucursal->ES_CLIENTE_REAL ) {
						$oSucursal->loadClienteReal($oSucursal->IDCLIENTE, $esSubcadena);
					} else {
						$oSucursal->load($idCliente);
					}

					$oSucursal->ID_SUCURSAL_ACTIVA = $idSucursal;
					$resActualizarCuotas = $oSucursal->actualizarCuotas();

					if ( $resActualizarCuotas["success"] ) {
						echo json_encode( array( "codigo" => 0, "mensaje" => "Sucursal agregada exitosamente" ) );
					} else {
						echo json_encode( array( "codigo" => 80, "mensaje" => "Error al actualizar las Cuotas: ".utf8_encode($resActualizarCuotas['errmsg']) ) );
					}
				} else {
					echo json_encode( array( "codigo" => 15, "mensaje" => "Error al guardar la Sucursal: {$resCrearSucursal['errmsg']}" ) );
				}
			} else {
				echo json_encode( array( "codigo" => 14, "mensaje" => "Error al guardar la Direccion: {$resCrearDireccion['errmsg']}" ) );
			}
		} else if ( $oCliente->TIPOFORELO == 2 ) {
			if ( $comisiones < 0 ) {
				echo json_encode( array( "codigo" => 24,
				"mensaje" => "No es posible guardar los datos porque falta proporcionar comisiones" ) );
				exit();
			}
			
			if ( $reembolso < 0 ) {
				echo json_encode( array( "codigo" => 25,
				"mensaje" => "No es posible guardar los datos porque falta proporcionar reembolso" ) );
				exit();
			}			
			
			if ( $comisiones == 1 || $reembolso == 1 ) {
				if ( !isset($CLABE) ) {
					echo json_encode( array( "codigo" => 26,
					"mensaje" => "No es posible guardar los datos porque falta proporcionar CLABE" ) );
					exit();
				}
				
				if ( $idBanco <= 0 ) {
					echo json_encode( array( "codigo" => 27,
					"mensaje" => "No es posible guardar los datos porque falta proporcionar idBanco" ) );
					exit();
				}
				
				if ( !isset($numCuenta) ) {
					echo json_encode( array( "codigo" => 28,
					"mensaje" => "No es posible guardar los datos porque falta proporcionar un Numero de Cuenta" ) );
					exit();
				}
				
				if ( !isset($beneficiario) ) {
					echo json_encode( array( "codigo" => 29,
					"mensaje" => "No es posible guardar los datos porque falta proporcionar un Beneficiario" ) );
					exit();
				}
				
				if ( !isset($descripcion) ) {
					echo json_encode( array( "codigo" => 28,
					"mensaje" => "No es posible guardar los datos porque falta proporcionar una Descripcion" ) );
					exit();
				}
			}						
			$oCliente = new AfiliacionCliente( $RBD, $WBD, $LOG );
			if ( $idSubcadena >= 0 ) {
				$oCliente->loadClienteReal($idCliente, $esSubcadena);
				$esClienteReal = true;				
			} else {
				$oCliente->load($idCliente);
				$esClienteReal = false;
			}
			$oSucursal->ES_CLIENTE_REAL = $esClienteReal;
			if ( $oCliente->ERROR_CODE == 0 ) {
				$maximoPuntos = $oCliente->MAXIMOPUNTOS;
				if ( $maximoPuntos != 0 ) {
					$sucursalesArreglo = $oSucursal->SUCURSALES;
					$totalSucursales = count($sucursalesArreglo);
					if ( $totalSucursales >= $maximoPuntos ) {
						echo json_encode( array( "codigo" => 23, "mensaje" => utf8_encode("No es posible agregar más sucursales dado que ya se excedió el límite máximo permitido") ) );
						exit();
					}
				}
			} else {
				echo json_encode( array( "codigo" => 22, "mensaje" => "Error al cargar el Cliente: ".$oCliente->ERROR_MSG ) );
			}
			
			if ( $oSucursal->ES_CLIENTE_REAL ) {
				$resCrearRefBancaria = $oSucursal->crearReferenciaBancaria(0, 0, $idCliente);
			} else {
				$resCrearRefBancaria = $oSucursal->crearReferenciaBancaria(0, $idCliente, 0);
			}
			if ( $resCrearRefBancaria["success"] ) {
				$idFORELO = $resCrearRefBancaria["data"]["idForelo"];
				$referenciaBancaria = $resCrearRefBancaria["data"]["referenciaBancaria"];
				$oCuenta = new AfiliacionCuenta( $RBD, $WBD, $LOG );
				
				if ( $comisiones == 1 || $reembolso == 1 ) {
					$oCuenta->IDBANCO = $idBanco;
					$oCuenta->NUMCUENTA = $numCuenta;
					$oCuenta->CLABE = $CLABE;
					$oCuenta->BENEFICIARIO = utf8_decode($beneficiario);
					$oCuenta->DESCRIPCION = utf8_decode($descripcion);
					
					$resGuardarCuenta = $oCuenta->guardarCuenta( $idBanco, $numCuenta, $CLABE, $beneficiario, $descripcion );
									
					if ( $resGuardarCuenta["success"] ) {
						$idCuenta = $resGuardarCuenta["data"]["idCuenta"];
						$resActualizarForelo = $oSucursal->actualizarForelo( $idFORELO, 0, $comisiones, $reembolso, $idCuenta, $referenciaBancaria );
						if ( $resActualizarForelo["success"] ) {					
							//INICIA BLOQUE
							
							if ( $idSubcadena >= 0 ) {
								if ( $idSubcadena != "" ) {
									$idCliente2 = 0;
								} else {
									$idCliente2 = $idCliente;
								}
							} else {
								$idCliente2 = $idCliente;
							}
							
							if ( $idSubcadena == "" ) {
								$idSubcadena = 0;
							}						
							
							if ( $idSubcadena == -500 ) {
								$idSubcadena = 0;
							}							
							
							$idCadena = $oCliente->IDCADENA;
							$version = $oCliente->IDVERSION;
							
							if ( count($contactos) > 0 ) {
								$idEstatusSucursal = 0;
							} else {
								$idEstatusSucursal = 1;
							}
							
							$sucursal = array(
								"idSucursal" => 0,
								"idCorresponsal" => 0,
								"idCliente" => $idCliente2,
								"idSubCadena" => $idSubcadena,
								"idCadena" => $idCadena,
								"idEstatus" => 1,
								"idEmpleado" => 0,
								"idGrupo" => $oCliente->IDGRUPO,
								"idReferencia" => $oCliente->IDREFERENCIA,
								"idDireccion" => $idDireccion,
								"idVersion" => $version,
								"idGiro" => $idGiro,
								"idForelo" => $idFORELO,
								"NombreSucursal" => "'".utf8_decode($nombreSucursal)."'",
								"Telefono" => "'".$telefono."'",
								"Correo" => "'".$correo."'",
								"Calle" => "'".utf8_decode($calle)."'",
								"NumInt" => "'".$numeroInterior."'",
								"NumExt" => "'".$numeroExterior."'",
								"idPais" => $idPais,
								"idEntidad" => $idEstado,
								"idMunicipio" => $idMunicipio,
								"idLocalidad" => $idLocalidad,
								"idColonia" => $idColonia,
								"codigoPostal" => $codigoPostal,
								"idEstatusCuenta" => 0,
								"idBanco" => 0,
								"NumCuenta" => 'NULL',
								"CLABE" => 'NULL',
								"Beneficiario" => 'NULL',
								"Descripcion" => 'NULL',
								"idEstatusFORELO" => 'NULL',
								"idComisiones" => 'NULL',
								"idReembolso" => 0,
								"ReferenciaBanco" => 'NULL',
								"FecActivacion" => "'0000-00-00 00:00:00'",
								"idTipoDir" => 1
							);
							if ( $origen == 0 ) {
								$resCrearDireccion["success"] = true;
								$resCrearDireccion["data"]["idDireccion"] = $idDireccion;
							} else if ( $origen == 1 ) {
								$resCrearDireccion = $oSucursal->crearDireccion( NULL, $sucursal );
							}							
							//$resCrearDireccion = $oSucursal->crearDireccion( NULL, $sucursal );
							if ( $resCrearDireccion["success"] ) {
								$idDireccion = $resCrearDireccion["data"]["idDireccion"];
								$sucursal["idDireccion"] = $idDireccion;
								$resCrearSucursal = $oSucursal->crearSucursal( NULL, $sucursal );
								if ( $resCrearSucursal["success"] ) {
									$idSucursal = $resCrearSucursal["data"]["idSucursal"];
									foreach( $contactos as $contacto ) {
										$contacto["idEstatus"] = 1;
										$contacto["nombre"] = utf8_decode($contacto["nombre"]);
										$contacto["apellidoPaterno"] = utf8_decode($contacto["apellidoPaterno"]);
										$contacto["apellidoMaterno"] = utf8_decode($contacto["apellidoMaterno"]);										
										$resAgregarContacto = $oSucursal->agregarContacto( $idSucursal, $contacto );
										if ( !$resAgregarContacto["success"] ) {
											echo json_encode( array( "codigo" => 22, "mensaje" => "Error al agregar Contacto: {$resAgregarContacto['errmsg']}" ) );
											break;
										}
									}
									if ( $oSucursal->ES_CLIENTE_REAL ) {
										$oSucursal->loadClienteReal($idCliente);
									} else {
										$oSucursal->load($idCliente);
									}
									$oSucursal->ES_CLIENTE_REAL = $esClienteReal;
									$resActualizarForelo = $oSucursal->actualizarForelo( $idFORELO, $idSucursal, $comisiones, $reembolso, $idCuenta, $referenciaBancaria );
									if ( $oSucursal->ES_CLIENTE_REAL ) {
										$resCrearCuotas = $oSucursal->crearCuotas( $oCliente->IDCOSTO, $oCliente->IDNIVEL, $idFORELO, 0, $idCliente, $idSucursal );
									} else {
										$resCrearCuotas = $oSucursal->crearCuotas( $oCliente->IDCOSTO, $oCliente->IDNIVEL, $idFORELO, $idCliente, 0, $idSucursal );
									}
									if ( $resCrearCuotas["success"] ) {
										//$resActualizarCuotas = $oSucursal->actualizarCuotas();
										//if ( $resActualizarCuotas["success"] ) {
										$oSucursal->prepararSucursal($idSucursal);
										echo json_encode( array( "codigo" => 0, "mensaje" => "Sucursal agregada exitosamente" ) );
										//} else {
											//echo json_encode( array( "codigo" => 92, "mensaje" => "Error al actualizar las Cuotas: {$resActualizarCuotas['errmsg']}" ) );
										//}
									} else {
										echo json_encode( array( "codigo" => 81, "mensaje" => "Error al crear las Cuotas: {$resCrearCuotas['errmsg']}" ) );
									}
								} else {
									echo json_encode( array( "codigo" => 21, "mensaje" => "Error al crear la Sucursal: {$resCrearSucursal['errmsg']}" ) );
								}
							} else {
								echo json_encode( array( "codigo" => 20, "mensaje" => "Error al guardar la Direccion: {$resCrearDireccion['errmsg']}" ) );
							}						
							
							//TERMINA BLOQUE						
							
						} else {
							echo json_encode( array( "codigo" => 19, "mensaje" => "Error al actualizar FORELO: {$resActualizarForelo['errmsg']}" ) );
						}
					} else {
						echo json_encode( array( "codigo" => 18, "mensaje" => "Error al crear Cuenta: {$resGuardarCuenta['errmsg']}" ) );
					}
				} else {
						$idCuenta = 0;
						$resActualizarForelo = $oSucursal->actualizarForelo( $idFORELO, 0, $comisiones, $reembolso, $idCuenta, $referenciaBancaria );
						if ( $resActualizarForelo["success"] ) {					
							//INICIA BLOQUE
							
							if ( $idSubcadena >= 0 ) {
								if ( $idSubcadena != "" ) {
									$idCliente2 = 0;
								} else {
									$idCliente2 = $idCliente;
								}
							} else {
								$idCliente2 = $idCliente;
							}
							
							if ( $idSubcadena == "" ) {
								$idSubcadena = 0;
							}						
							
							if ( $idSubcadena == -500 ) {
								$idSubcadena = 0;
							}							
							
							$idCadena = $oCliente->IDCADENA;
							$version = $oCliente->IDVERSION;
							
							if ( count($contactos) > 0 ) {
								$idEstatusSucursal = 0;
							} else {
								$idEstatusSucursal = 1;
							}							
							
							$sucursal = array(
								"idSucursal" => 0,
								"idCorresponsal" => 0,
								"idCliente" => $idCliente2,
								"idSubCadena" => $idSubcadena,
								"idCadena" => $idCadena,
								"idEstatus" => 1,
								"idEmpleado" => 0,
								"idGrupo" => $oCliente->IDGRUPO,
								"idReferencia" => $oCliente->IDREFERENCIA,
								"idDireccion" => $idDireccion,
								"idVersion" => $version,
								"idGiro" => $idGiro,
								"idForelo" => $idFORELO,
								"NombreSucursal" => "'".utf8_decode($nombreSucursal)."'",
								"Telefono" => "'".$telefono."'",
								"Correo" => "'".$correo."'",
								"Calle" => "'".utf8_decode($calle)."'",
								"NumInt" => "'".$numeroInterior."'",
								"NumExt" => "'".$numeroExterior."'",
								"idPais" => $idPais,
								"idEntidad" => $idEstado,
								"idMunicipio" => $idMunicipio,
								"idLocalidad" => $idLocalidad,
								"idColonia" => $idColonia,
								"codigoPostal" => $codigoPostal,
								"idEstatusCuenta" => 0,
								"idBanco" => 0,
								"NumCuenta" => 'NULL',
								"CLABE" => 'NULL',
								"Beneficiario" => 'NULL',
								"Descripcion" => 'NULL',
								"idEstatusFORELO" => 'NULL',
								"idComisiones" => 'NULL',
								"idReembolso" => 0,
								"ReferenciaBanco" => 'NULL',
								"FecActivacion" => "'0000-00-00 00:00:00'",
								"idTipoDir" => 1
							);
							if ( $origen == 0 ) {
								$resCrearDireccion["success"] = true;
								$resCrearDireccion["data"]["idDireccion"] = $idDireccion;
							} else if ( $origen == 1 ) {
								$resCrearDireccion = $oSucursal->crearDireccion( NULL, $sucursal );
							}
							//$resCrearDireccion = $oSucursal->crearDireccion( NULL, $sucursal );
							if ( $resCrearDireccion["success"] ) {
								$idDireccion = $resCrearDireccion["data"]["idDireccion"];
								$sucursal["idDireccion"] = $idDireccion;
								$resCrearSucursal = $oSucursal->crearSucursal( NULL, $sucursal );
								if ( $resCrearSucursal["success"] ) {
									$idSucursal = $resCrearSucursal["data"]["idSucursal"];
									foreach( $contactos as $contacto ) {
										$contacto["idEstatus"] = 1;
										$contacto["nombre"] = utf8_decode($contacto["nombre"]);
										$contacto["apellidoPaterno"] = utf8_decode($contacto["apellidoPaterno"]);
										$contacto["apellidoMaterno"] = utf8_decode($contacto["apellidoMaterno"]);										
										$resAgregarContacto = $oSucursal->agregarContacto( $idSucursal, $contacto );
										if ( !$resAgregarContacto["success"] ) {
											echo json_encode( array( "codigo" => 22, "mensaje" => "Error al agregar Contacto: {$resAgregarContacto['errmsg']}" ) );
											break;
										}
									}
									if ( $oSucursal->ES_CLIENTE_REAL ) {
										$oSucursal->loadClienteReal($idCliente);
									} else {
										$oSucursal->load($idCliente);
									}
									$oSucursal->ES_CLIENTE_REAL = $esClienteReal;
									$resActualizarForelo = $oSucursal->actualizarForelo( $idFORELO, $idSucursal, $comisiones, $reembolso, $idCuenta, $referenciaBancaria );
									if ( $oSucursal->ES_CLIENTE_REAL ) {
										$resCrearCuotas = $oSucursal->crearCuotas( $oCliente->IDCOSTO, $oCliente->IDNIVEL, $idFORELO, 0, $idCliente, $idSucursal );
									} else {
										$resCrearCuotas = $oSucursal->crearCuotas( $oCliente->IDCOSTO, $oCliente->IDNIVEL, $idFORELO, $idCliente, 0, $idSucursal );
									}
									/*echo "<pre>";
									print_r($resCrearCuotas);
									echo "</pre>";*/
									if ( $resCrearCuotas["success"] ) {
										$oSucursal->prepararSucursal($idSucursal);
										echo json_encode( array( "codigo" => 0, "mensaje" => "Sucursal agregada exitosamente" ) );
										//} else {
											//echo json_encode( array( "codigo" => 81, "mensaje" => "Error al actualizar las Cuotas: {$resActualizarCuotas['errmsg']}" ) );
										//}
									} else {
										echo json_encode( array( "codigo" => 93, "mensaje" => "Error al crear las Cuotas: {$resCrearCuotas['errmsg']}" ) );
									}
								} else {
									echo json_encode( array( "codigo" => 91, "mensaje" => "Error al actualizar la Sucursal: {$resCrearSucursal['errmsg']}" ) );
								}
							} else {
								echo json_encode( array( "codigo" => 20, "mensaje" => "Error al guardar la Direccion: {$resCrearDireccion['errmsg']}" ) );
							}						
							
							//TERMINA BLOQUE						
							
						} else {
							echo json_encode( array( "codigo" => 19, "mensaje" => "Error al actualizar FORELO: {$resActualizarForelo['errmsg']}" ) );
						}					
				}
			} else {
				echo json_encode( array( "codigo" => 17, "mensaje" => "Error al crear FORELO: {$resCrearRefBancaria['errmsg']}" ) );
			}
		}
	} else {
		echo json_encode( array( "codigo" => 13, "mensaje" => "Error al cargar la Sucursal: ".$oSucursal->ERROR_MSG ) );
	}
?>