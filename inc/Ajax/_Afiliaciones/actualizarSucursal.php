<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	
	$idCliente = !empty( $_POST['idAfiliacion'] )? $_POST['idAfiliacion'] : -500;
	$idSucursal = !empty( $_POST['idSucursal'] )? $_POST['idSucursal'] : -500;
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
	$idLocalidad = isset( $_POST['idLocalidad'] )? $_POST['idLocalidad'] : -500;

	$comisiones = isset( $_POST['comisiones'] )? $_POST['comisiones'] : -500;
	$reembolso = isset( $_POST['reembolso'] )? $_POST['reembolso'] : -500;
	$CLABE = isset( $_POST['CLABE'] )? $_POST['CLABE'] : NULL;
	$idBanco = !empty( $_POST['idBanco'] )? $_POST['idBanco'] : -500;
	$numCuenta = !empty( $_POST['numCuenta'] )? $_POST['numCuenta'] : NULL;
	$beneficiario = !empty( $_POST['beneficiario'] )? $_POST['beneficiario'] : NULL;
	$descripcion = !empty( $_POST['descripcion'] )? $_POST['descripcion'] : NULL;
	
	$contactos = !empty( $_POST['contactos'] )? $_POST['contactos'] : NULL;
	$vieneDeNuevaSucursal = (isset($_POST['vieneDeNuevaSucursal']))? $_POST['vieneDeNuevaSucursal'] : NULL;
	$esSubcadena = isset( $_POST['esSubcadena'] )? $_POST['esSubcadena'] : -500;
	
	$origen = isset( $_POST['origen'] )? $_POST['origen'] : -500;
	
	if ( $idCliente <= 0 ) {
		echo json_encode( array( "codigo" => 1,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un ID de Afiliacion" ) );
		exit();
	}	
	
	if ( !isset($nombreSucursal) ) {
		echo json_encode( array( "codigo" => 2,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un nombre de Sucursal" ) );
		exit();
	}
	
	if ( $idGiro <= 0 ) {
		echo json_encode( array( "codigo" => 3,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un Giro" ) );
		exit();
	}
	
	if ( $idPais <= 0 ) {
		echo json_encode( array( "codigo" => 4,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un Pais" ) );
		exit();
	}
	
	if ( !isset($calle) ) {
		echo json_encode( array( "codigo" => 5,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar una Calle" ) );
		exit();
	}
	
	if ( !isset($numeroInterior) ) {
		$numeroInterior = "";
	}
	
	if ( $numeroExterior <= 0 ) {
		echo json_encode( array( "codigo" => 7,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un Numero Exterior" ) );
		exit();
	}
	
	if ( !isset($codigoPostal) ) {
		echo json_encode( array( "codigo" => 8,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un Codigo Postal" ) );
		exit();
	}
	
	if ( $idColonia <= 0 ) {
		echo json_encode( array( "codigo" => 9,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar una Colonia" ) );
		exit();
	}
	
	if ( $idEstado <= 0 ) {
		echo json_encode( array( "codigo" => 10,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un Estado" ) );
		exit();
	}
	
	if ( $idMunicipio <= 0 ) {
		echo json_encode( array( "codigo" => 11,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un Municipio" ) );
		exit();
	}
	
	if ( !isset($telefono) ) {
		echo json_encode( array( "codigo" => 12,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un Telefono" ) );
		exit();
	}
	
	if ( $idSucursal <= 0 ) {
		echo json_encode( array( "codigo" => 11,
		"mensaje" => "No es posible actualizar los datos porque falta proporcionar un ID de Sucursal" ) );
		exit();
	}
	
	if ( $idLocalidad < 0 ) {
		echo json_encode( array( "codigo" => 90,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un ID de Localidad" ) );
		exit();
	}	
	
	$oCliente = new AfiliacionCliente( $RBD, $WBD, $LOG );
	if ( !$vieneDeNuevaSucursal ) {
		$oCliente->load($idCliente);
		$sql = $RBD->query("CALL `afiliacion`.`SP_COSTO_FIND`(".$oCliente->IDCOSTO.", ".$oCliente->IDNIVEL.")");
		$res = mysqli_fetch_assoc($sql);
		if ( mysqli_num_rows($sql) > 0 ) {
			if ( $res['codigo'] == -500 ) {
				echo json_encode( array( "codigo" => 98, "mensaje" => 'No es posible actualizar la sucursal porque es necesario que el cliente tenga un expediente definido.' ) );
				exit();
			}			
			if ( $oCliente->TIPOFORELO != $res['idTipoForelo'] ) {
				echo json_encode( array( "codigo" => 99, "mensaje" => utf8_encode('No es posible actualizar la sucursal porque su configuración de costos es inválida.') ) );
				exit();
			}
			$cobroA		= (!empty($res['CobroA']))? $res['CobroA'] : 0;
			$tipoCobro	= (!empty($res['TipoCobro']))? $res['TipoCobro'] : 0;
			if ( $oCliente->TIPOFORELO == 2 && $tipoCobro == 1 ) {
				echo json_encode( array( "codigo" => 94, "mensaje" => 'La configuracion de costos es incorrecta. Favor de contactar al departamento de Comercial' ) );
				exit();
			}
		}else{
			echo json_encode( array( "codigo" => 100, "mensaje" => utf8_encode('No es posible actualizar la sucursal porque su configuración de costos es inválida.') ) );
			exit();
		}
	} else {
		$oCliente->loadClienteReal($idCliente, $esSubcadena);
		$sql = $RBD->query("CALL `afiliacion`.`SP_COSTO_FIND`(".$oCliente->IDCOSTO.", ".$oCliente->IDNIVEL.")");
		$res = mysqli_fetch_assoc($sql);
		if ( mysqli_num_rows($sql) > 0 ) {
			if ( $res['codigo'] == -500 ) {
				echo json_encode( array( "codigo" => 95, "mensaje" => 'No es posible actualizar la sucursal porque es necesario que el cliente tenga un expediente definido.' ) );
				exit();
			}			
			if ( $oCliente->TIPOFORELO != $res['idTipoForelo'] ) {
				echo json_encode( array( "codigo" => 96, "mensaje" => utf8_encode('No es posible actualizar la sucursal porque su configuración de costos es inválida.') ) );
				exit();
			}
		}else{
			echo json_encode( array( "codigo" => 97, "mensaje" => utf8_encode('No es posible actualizar la sucursal porque su configuración de costos es inválida.') ) );
			exit();
		}
	}
	$version = $oCliente->IDVERSION;
	
	if ( $oCliente->ERROR_CODE != 0 ) {
		echo json_encode( array( "codigo" => 13, "mensaje" => "Error al cargar la Sucursal: ".$oCliente->ERROR_MSG ) );
		exit();
	}	
	
	$oSucursal = new AfiliacionSucursal2( $RBD, $WBD, $LOG );
	if ( !$vieneDeNuevaSucursal ) {
		$oSucursal->load($idCliente);
		$esClienteReal = false;
	} else {
		$oSucursal->loadClienteReal($idCliente);
		$esClienteReal = true;
	}
	
	$oSucursal->ES_CLIENTE_REAL = $esClienteReal;
	
	if ( $oSucursal->ERROR_CODE == 0 ) {
		if ( $oCliente->TIPOFORELO == 1 ) {
			$sucursal = $oSucursal->getSucursal( $idSucursal );
			if ( isset($sucursal) ) {
				$sucursal["NombreSucursal"] = "'".utf8_decode($nombreSucursal)."'";
				$sucursal["Calle"] = "'".utf8_decode($calle)."'";
				$sucursal["NumInt"] = "'".$numeroInterior."'";
				$sucursal["NumExt"] = "'".$numeroExterior."'";
				$sucursal["idPais"] = $idPais;
				$sucursal["idEntidad"] = $idEstado;
				$sucursal["idMunicipio"] = $idMunicipio;
				$sucursal["idLocalidad"] = $idLocalidad;
				$sucursal["codigoPostal"] = $codigoPostal;
				$sucursal["Telefono"] = "'".$telefono."'";
				$sucursal["Correo"] = "''";
				$sucursal["FecActivacion"] = 'NULL';
				$sucursal["idVersion"] = $version;
				$sucursal["idGiro"] = $idGiro;
				$sucursal["idColonia"] = $idColonia;
				if ( count($contactos) > 0 ) {
					$idEstatusSucursal = 0;
				} else {
					$idEstatusSucursal = 1;
				}
				$sucursal["idEstatus"] = $idEstatusSucursal;
				if ( $origen == 1 ) {
					$resCrearDireccion = $oSucursal->crearDireccion( NULL, $sucursal );
					$sucursal["idDireccion"] = $resCrearDireccion["data"]["idDireccion"];
					$sucursal["idDir"] = $resCrearDireccion["data"]["idDireccion"];
					$sucursal["idDireccionAntiguo"] = 0;
				}
				$resEditarSucursal = $oSucursal->editarSucursal( $idSucursal, $sucursal );
				if ( $resEditarSucursal["success"] ) {
					$resEditarDireccion = $oSucursal->editarDireccion( $idSucursal, $sucursal );
					if ( $resEditarDireccion["success"] ) {
						foreach( $contactos as $contacto ) {
							if ( $contacto["idSucursal"] == "temp" ) {
								$contacto["nombre"] = utf8_decode($contacto["nombre"]);
								$contacto["apellidoPaterno"] = utf8_decode($contacto["apellidoPaterno"]);
								$contacto["apellidoMaterno"] = utf8_decode($contacto["apellidoMaterno"]);							
								$contacto["nombreTipoContacto"] = "'".utf8_decode($contacto["nombreTipoContacto"])."'";
								$contacto["idEstatus"] = 1;
								$resAgregarContacto = $oSucursal->agregarContacto( $idSucursal, $contacto );
								if ( !$resAgregarContacto["success"] ) {
									echo json_encode( array( "codigo" => 18, "mensaje" => "Error al actualizar la Sucursal: {$resAgregarContacto['errmsg']}" ) );
									break;
								}
							}
						}
						/*if ( !$vieneDeNuevaSucursal ) {
							$oCliente->load($idCliente);
						} else {
							$oCliente->loadClienteReal($idCliente, $esSubcadena);
						}*/
						if ( !$vieneDeNuevaSucursal ) {
							$oSucursal->load($idCliente);
						} else {
							$oSucursal->loadClienteReal($idCliente);
						}
						$oSucursal->ID_SUCURSAL_ACTIVA = $idSucursal;
						$oSucursal->prepararSucursal($idSucursal);
						$resActualizarCuotas = $oSucursal->actualizarCuotas();
						if ( $resActualizarCuotas["success"] ) {
							echo json_encode( array( "codigo" => 0, "mensaje" => "Sucursal agregada exitosamente" ) );
						} else {
							echo json_encode( array( "codigo" => 80, "mensaje" => "Error al actualizar las Cuotas: ".utf8_encode($resActualizarCuotas['errmsg']) ) );
						}						
						//echo json_encode( array( "codigo" => 0, "mensaje" => "Sucursal Actualizada exitosamente" ) );
					} else {
						echo json_encode( array( "codigo" => 17, "mensaje" => "Error al actualizar la Direccion: {$resEditarDireccion['errmsg']}" ) );
					}
				} else {
					echo json_encode( array( "codigo" => 16, "mensaje" => "Error al actualizar la Sucursal: {$resEditarSucursal['errmsg']}" ) );
				}
			} else {
				echo json_encode( array( "codigo" => 15, "mensaje" => "No se encontro Sucursal" ) );
			}
		} else if ( $oCliente->TIPOFORELO == 2 ) {
			if ( $comisiones < 0 ) {
				echo json_encode( array( "codigo" => 19,
				"mensaje" => "No es posible guardar los datos porque falta proporcionar comisiones" ) );
				exit();
			}
			
			if ( $reembolso < 0 ) {
				echo json_encode( array( "codigo" => 20,
				"mensaje" => "No es posible guardar los datos porque falta proporcionar reembolso" ) );
				exit();
			}			
			
			if ( $comisiones == 1 || $reembolso == 1 ) {
				if ( !isset($CLABE) ) {
					echo json_encode( array( "codigo" => 21,
					"mensaje" => "No es posible guardar los datos porque falta proporcionar CLABE" ) );
					exit();
				}
				
				if ( $idBanco <= 0 ) {
					echo json_encode( array( "codigo" => 22,
					"mensaje" => "No es posible guardar los datos porque falta proporcionar idBanco" ) );
					exit();
				}
				
				if ( !isset($numCuenta) ) {
					echo json_encode( array( "codigo" => 23,
					"mensaje" => "No es posible guardar los datos porque falta proporcionar un Numero de Cuenta" ) );
					exit();
				}
				
				if ( !isset($beneficiario) ) {
					echo json_encode( array( "codigo" => 24,
					"mensaje" => "No es posible guardar los datos porque falta proporcionar un Beneficiario" ) );
					exit();
				}
				
				if ( !isset($descripcion) ) {
					echo json_encode( array( "codigo" => 25,
					"mensaje" => "No es posible guardar los datos porque falta proporcionar una Descripcion" ) );
					exit();
				}
			}
			
			$oCuenta = new AfiliacionCuenta( $RBD, $WBD, $LOG );
			$sucursal = $oSucursal->getSucursal( $idSucursal );

			if ( !isset($sucursal) ) {
				echo json_encode( array( "codigo" => 27, "mensaje" => "No se encontro Sucursal" ) );
				exit();
			}
			
			if($sucursal["idCuentaBanco"] == 'NULL'){
				if ( $oSucursal->ES_CLIENTE_REAL ) {
					$resCrearRefBancaria = $oSucursal->crearReferenciaBancaria(0, 0, $idCliente);
				} else {
					$resCrearRefBancaria = $oSucursal->crearReferenciaBancaria(0, $idCliente, 0);
				}
				//$res = $oSucursal->crearReferenciaBancaria($idSucursal);
				$sucursal["ReferenciaBanco"] = $resCrearRefBancaria['data']['referenciaBancaria'];
				$sucursal["idForelo"] = $resCrearRefBancaria['data']['idForelo'];
				
			}

			if ( $comisiones == 1 || $reembolso == 1 ) {
				$oCuenta->IDCUENTA = ($sucursal["idCuentaBanco"] == 'NULL')? 0 : $sucursal["idCuentaBanco"];
				$oCuenta->IDBANCO = $idBanco;
				$oCuenta->NUMCUENTA = $numCuenta;
				$oCuenta->CLABE = $CLABE;
				$oCuenta->BENEFICIARIO = utf8_decode($beneficiario);
				$oCuenta->DESCRIPCION = utf8_decode($descripcion);

				$resGuardarCuenta = $oCuenta->guardarCuenta();
				/*echo "<pre>";
				($resGuardarCuenta);
				echo "</pre>";*/
				if ( $resGuardarCuenta["success"] ) {
					$idFORELO = $sucursal["idForelo"];
					$sucursal["idCuentaBanco"] = $resGuardarCuenta["data"]["idCuenta"];
				}
				
				if ( $resGuardarCuenta["success"] ) {
					$idFORELO = $sucursal["idForelo"];
					$idCuenta = $resGuardarCuenta["data"]["idCuenta"];
					$referenciaBancaria = $sucursal["ReferenciaBanco"];
					$resActualizarForelo = $oSucursal->actualizarForelo( $idFORELO, $idSucursal, $comisiones, $reembolso, $idCuenta, $referenciaBancaria );
					if ( $resActualizarForelo["success"] ) {
						$sucursal["NombreSucursal"] = "'".utf8_decode($nombreSucursal)."'";
						$sucursal["Calle"] = "'".utf8_decode($calle)."'";
						$sucursal["NumInt"] = "'".$numeroInterior."'";
						$sucursal["NumExt"] = "'".$numeroExterior."'";
						$sucursal["idPais"] = $idPais;
						$sucursal["idEntidad"] = $idEstado;
						$sucursal["idMunicipio"] = $idMunicipio;
						$sucursal["idLocalidad"] = $idLocalidad;
						$sucursal["codigoPostal"] = $codigoPostal;
						$sucursal["Telefono"] = "'".$telefono."'";
						$sucursal["Correo"] = "''";
						$sucursal["FecActivacion"] = 'NULL';
						$sucursal["idVersion"] = $version;
						$sucursal["idGiro"] = $idGiro;
						$sucursal["idColonia"] = $idColonia;
						if ( count($contactos) > 0 ) {
							$idEstatusSucursal = 0;
						} else {
							$idEstatusSucursal = 1;
						}
						$sucursal["idEstatus"] = $idEstatusSucursal;
						//var_dump("TEST A");
						//var_dump("origen: $origen");
						if ( $origen == 1 ) {
							$resCrearDireccion = $oSucursal->crearDireccion( NULL, $sucursal );
							$sucursal["idDireccion"] = $resCrearDireccion["data"]["idDireccion"];
							$sucursal["idDir"] = $resCrearDireccion["data"]["idDireccion"];
							$sucursal["idDireccionAntiguo"] = 0;
						}						
						$resEditarSucursal = $oSucursal->editarSucursal( $idSucursal, $sucursal );
						if ( $resEditarSucursal["success"] ) {
							$resEditarDireccion = $oSucursal->editarDireccion( $idSucursal, $sucursal );
							if ( $resEditarDireccion["success"] ) {
								foreach( $contactos as $contacto ) {
									if ( $contacto["idSucursal"] == "temp" ) {
										$contacto["nombre"] = utf8_decode($contacto["nombre"]);
										$contacto["apellidoPaterno"] = utf8_decode($contacto["apellidoPaterno"]);
										$contacto["apellidoMaterno"] = utf8_decode($contacto["apellidoMaterno"]);										
										$contacto["nombreTipoContacto"] = "'".utf8_decode($contacto["nombreTipoContacto"])."'";
										$contacto["idEstatus"] = 1;
										$resAgregarContacto = $oSucursal->agregarContacto( $idSucursal, $contacto );
										if ( !$resAgregarContacto["success"] ) {
											echo json_encode( array( "codigo" => 31, "mensaje" => "Error al actualizar la Sucursal: {$resAgregarContacto['errmsg']}" ) );
											break;
										}
									}
								}
								$oSucursal->prepararSucursal($idSucursal);
								/*$resActualizarCuotas = $oSucursal->actualizarCuotas();
								if ( $resActualizarCuotas["success"] ) {
									echo json_encode( array( "codigo" => 0, "mensaje" => "Sucursal agregada exitosamente" ) );
								} else {
									echo json_encode( array( "codigo" => 81, "mensaje" => "Error al actualizar las Cuotas: {$resActualizarCuotas['errmsg']}" ) );
								}*/
								echo json_encode( array( "codigo" => 0, "mensaje" => "Sucursal Actualizada exitosamente" ) );
							} else {
								echo json_encode( array( "codigo" => 30, "mensaje" => "Error al actualizar la Direccion: {$resEditarDireccion['errmsg']}" ) );
							}
						} else {
							echo json_encode( array( "codigo" => 29, "mensaje" => "Error al actualizar la Sucursal: {$resEditarSucursal['errmsg']}" ) );
						}
					} else {
						echo json_encode( array( "codigo" => 28, "mensaje" => "Error al guardar el FORELO: {$resActualizarForelo['errmsg']}" ) );
					}
				} else {
					echo json_encode( array( "codigo" => 26, "mensaje" => "Error al guardar la Cuenta: {$resGuardarCuenta['errmsg']}" ) );
				}
			} else {
				$idCuenta = ($sucursal["idCuentaBanco"] == 'NULL')? 0 : $sucursal["idCuentaBanco"];
				$idFORELO = $sucursal["idForelo"];
				$referenciaBancaria = $sucursal["ReferenciaBanco"];
				if ( $idFORELO == 'NULL' || $idFORELO == '' || $idFORELO == 0 ) {
					if ( $oSucursal->ES_CLIENTE_REAL ) {
						$resCrearRefBancaria = $oSucursal->crearReferenciaBancaria(0, 0, $idCliente);
					} else {
						$resCrearRefBancaria = $oSucursal->crearReferenciaBancaria(0, $idCliente, 0);
					}
					$sucursal["ReferenciaBanco"] = $resCrearRefBancaria['data']['referenciaBancaria'];
					$sucursal["idForelo"] = $resCrearRefBancaria['data']['idForelo'];
					$idFORELO = $sucursal["idForelo"];
					$referenciaBancaria = $sucursal["ReferenciaBanco"];
				}
				$resActualizarForelo = $oSucursal->actualizarForelo( $idFORELO, $idSucursal, $comisiones, $reembolso, $idCuenta, $referenciaBancaria );
				if ( $resActualizarForelo["success"] ) {
					$sucursal["NombreSucursal"] = "'".utf8_decode($nombreSucursal)."'";
					$sucursal["Calle"] = "'".utf8_decode($calle)."'";
					$sucursal["NumInt"] = "'".$numeroInterior."'";
					$sucursal["NumExt"] = "'".$numeroExterior."'";
					$sucursal["idPais"] = $idPais;
					$sucursal["idEntidad"] = $idEstado;
					$sucursal["idMunicipio"] = $idMunicipio;
					$sucursal["idLocalidad"] = $idLocalidad;
					$sucursal["codigoPostal"] = $codigoPostal;
					$sucursal["Telefono"] = "'".$telefono."'";
					$sucursal["Correo"] = "''";
					$sucursal["FecActivacion"] = 'NULL';
					$sucursal["idVersion"] = $version;
					$sucursal["idGiro"] = $idGiro;
					$sucursal["idColonia"] = $idColonia;
					if ( count($contactos) > 0 ) {
						$idEstatusSucursal = 0;
					} else {
						$idEstatusSucursal = 1;
					}
					$sucursal["idEstatus"] = $idEstatusSucursal;
					//var_dump("TEST B");
					//var_dump("origen: $origen");
					if ( $origen == 1 ) {
						$resCrearDireccion = $oSucursal->crearDireccion( NULL, $sucursal );
						$sucursal["idDireccion"] = $resCrearDireccion["data"]["idDireccion"];
						$sucursal["idDir"] = $resCrearDireccion["data"]["idDireccion"];
						$sucursal["idDireccionAntiguo"] = 0;
					}
					$resEditarSucursal = $oSucursal->editarSucursal( $idSucursal, $sucursal );
					if ( $resEditarSucursal["success"] ) {
						$resEditarDireccion = $oSucursal->editarDireccion( $idSucursal, $sucursal );
						if ( $resEditarDireccion["success"] ) {
							foreach( $contactos as $contacto ) {
								if ( $contacto["idSucursal"] == "temp" ) {
									$contacto["nombre"] = utf8_decode($contacto["nombre"]);
									$contacto["apellidoPaterno"] = utf8_decode($contacto["apellidoPaterno"]);
									$contacto["apellidoMaterno"] = utf8_decode($contacto["apellidoMaterno"]);									
									$contacto["nombreTipoContacto"] = "'".utf8_decode($contacto["nombreTipoContacto"])."'";
									$contacto["idEstatus"] = 1;
									$resAgregarContacto = $oSucursal->agregarContacto( $idSucursal, $contacto );
									if ( !$resAgregarContacto["success"] ) {
										echo json_encode( array( "codigo" => 31, "mensaje" => "Error al actualizar la Sucursal: {$resAgregarContacto['errmsg']}" ) );
										break;
									}
								}
							}
							$oSucursal->prepararSucursal($idSucursal);
							/*$resActualizarCuotas = $oSucursal->actualizarCuotas();
							if ( $resActualizarCuotas["success"] ) {
								echo json_encode( array( "codigo" => 0, "mensaje" => "Sucursal agregada exitosamente" ) );
							} else {
								echo json_encode( array( "codigo" => 82, "mensaje" => "Error al actualizar las Cuotas: {$resActualizarCuotas['errmsg']}" ) );
							}*/							
							echo json_encode( array( "codigo" => 0, "mensaje" => "Sucursal Actualizada exitosamente" ) );
						} else {
							echo json_encode( array( "codigo" => 30, "mensaje" => "Error al actualizar la Direccion: {$resEditarDireccion['errmsg']}" ) );
						}
					} else {
						echo json_encode( array( "codigo" => 29, "mensaje" => "Error al actualizar la Sucursal: {$resEditarSucursal['errmsg']}" ) );
					}
				} else {
					echo json_encode( array( "codigo" => 28, "mensaje" => "Error al guardar el FORELO: {$resActualizarForelo['errmsg']}" ) );
				}			
			}
			
		}
	} else {
		echo json_encode( array( "codigo" => 14, "mensaje" => "Error al cargar el Cliente: ".$oSucursal->ERROR_MSG ) );
	}
?>
