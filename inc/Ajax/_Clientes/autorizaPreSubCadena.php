<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");
	include("../../../inc/obj/XMLPreSubCadena.php");

	$idPreSubCadena = (!empty($_POST['idSubCadena']))? $_POST['idSubCadena'] : 0;
	$res = autorizarPreSubCadena($idPreSubCadena, $RBD, $WBD);

	echo json_encode(
		array(
			'showMsg'	=> $res["SHOWMSG"],
			'msg'		=> $res["MSG"],
			'errmsg'	=> $res["ERROR"]
		)
	);

	function wordMatch($txt){
		return (!preg_match("!!u", $txt))? utf8_encode($txt) : $txt;
	}

	function getSubString($string, $length=NULL){
	    //Si no se especifica la longitud por defecto es 50
	    if ($length == NULL)
	        $length = 50;
	    //Primero eliminamos las etiquetas html y luego cortamos el string
	    $stringDisplay = substr(strip_tags($string), 0, $length);
	    //Si el texto es mayor que la longitud se agrega puntos suspensivos
	    //if (strlen(strip_tags($string)) > $length)
	        //$stringDisplay .= ' ...';
	    return $stringDisplay;
	}

	function autorizarPreSubCadena($idPreSubCadena, $RBD, $WBD){
		$oSub = new XMLPreSubCad($RBD, $WBD);
		$oSub->load($idPreSubCadena);
		$idPreSub = $idPreSubCadena;

		$ERROR		= "";
		$MSG		= "";
		$SHOWMSG	= 0;

		$referencia1 = $oSub->getReferenciaBancaria();
		$idCadena	= $oSub->getIdCadena();
		$idGrupo	= $oSub->getIdGrupo();
		$idGiro		= 0;
		$nombre		= $oSub->getNombre();
		$tel1		= $oSub->getTel1();
		$tel2		= '';
		$fax		= '';
		$correo		= $oSub->getCorreo();
		$codigo		= '';
		$referencia	= $oSub->getIdReferencia();

		$idEmpleado	= $_SESSION['idU'];
		$idVersion	= $oSub->getVersion();
		$idPreSub	= $oSub->getID();
		$clabe		= $oSub->getClabe();
		$rfc		= $oSub->getCRRfc();
		$nombreBen	= wordMatch($oSub->getCNombre()." ".$oSub->getCPaterno()." ".$oSub->getCMaterno());

		if($referencia == ""){
			return array(
				'ERROR'		=> '',
				'MSG'		=> 'Debe asignar una Referencia',
				'SHOWMSG'	=> 1
			);
		}

		if($idVersion == ""){
			return array(
				'ERROR'		=> '',
				'MSG'		=> 'Debe asignar una Versión',
				'SHOWMSG'	=> 1
			);
		}

		if($idGrupo == ""){
			return array(
				'ERROR'		=> '',
				'MSG'		=> 'Debe asignar un Grupo',
				'SHOWMSG'	=> 1
			);
		}

		if($idGiro == ""){
			$idGiro = 0;
		}

		$idRepLegal	= $oSub->getCRepLegal();
		/* Validar si tiene los depositos necesarios */
		$sql = $RBD->query("CALL `prealta`.`SP_SUMA_DEPOSITOS_CARGOS`('$referencia1', $idCadena, $idPreSubCadena,-1)");
		if($RBD->error()){
			return array(
				'ERROR'		=> $RBD->error(),
				'MSG'		=> 'Error suma',
				'SHOWMSG'	=> 1
			);
		}
		$row = mysqli_fetch_assoc($sql);
		
		$sql = $RBD->query("CALL `prealta`.`SP_SUMA_CARGOS_COMPARTIDOS`('$referencia1', $idCadena, $idPreSubCadena,-1)");
		if($RBD->error()){
			return array(
				'ERROR'		=> $RBD->error(),
				'MSG'		=> 'Error suma',
				'SHOWMSG'	=> 1
			);
		}
		$res = mysqli_fetch_assoc($sql);
	
		$depositos	= $row['importe_depositos'];
		$cargos		= $res['IMPORTE_CARGOS'];
		//echo "<pre>"; echo var_dump($row); echo "</pre>";
		/* Si el importe de los depositos en mayor o igual al de los cargos se puede continuar con el proceso de autorizar */
		if($depositos >= $cargos){

			//crear los datos generales
			$nombre = utf8_decode($nombre);
			$strQ = "CALL `prealta`.`SP_SUBCADENA_ALTA`($idGrupo, $idCadena, $idGiro, '$nombre', '$tel1', '$tel2', '$fax', '$correo', '$codigo', $referencia, $idEmpleado, $idEmpleado, $idVersion, $idPreSubCadena)";
			$sql = $WBD->query($strQ);

			if($WBD->error()){
				return array(
					'SHOWMSG'	=> 1,
					'ERROR'		=> $WBD->error(),
					'MSG'		=> "No ha sido posible crear la SubCadena"
				);
			}

			$res = mysqli_fetch_assoc($sql);
			// validamos si ocurrio algun error en la creacion de la subcadena
			if($res['result'] > 0){
				return array(
					'ERROR'		=> $res['result'],
					'MSG'		=> $res['msg'],
					'SHOWMSG'	=> 1
				);
			}

			$idSubCadena = $res['idSubCadena'];

			//arreglo donde se guardan todos los mensajes de error
			$arrError = array(
				'FOUND'		=> 0,
				'ERROR' 	=> '',
				'MSG'		=> '',
				'SHOWMSG'	=> 1
			);

			// DAR DE ALTA LAS COMISIONES
			$sql = $WBD->query("CALL `prealta`.`SP_ALTA_PERMISOS`($idCadena, $idSubCadena, -1, $idPreSubCadena, -1);");
			if($WBD->error()){
				$arrError['ERROR']	.= 'Comisiones : '.$WBD->error()."<br>";
				$arrError['MSG']	.= " - No se pudieron dar de Alta las Comisiones \\n";
				$arrError['FOUND']	= 1;
			}

			// CREAR EL REPRESENTANTE LEGAL
			$strQ = "CALL `prealta`.`SP_ALTA_REPRESENTANTE_LEGAL`($idRepLegal, $idEmpleado)";
			$sql = $WBD->query($strQ);

			if($WBD->error()){
				$arrError['ERROR']	.= 'Representante Legal : '.$WBD->error().'<br>';
				$arrError['MSG']	.= "- No se creó el representante Legal";
				$arrError['FOUND']	= 1;
			}

			$row = mysqli_fetch_assoc($sql);

			if($row['CodigoRespuesta'] > 0){
				$arrError['ERROR']	.= 'Representante Legal : '.$row['CodigoRespuesta'];
				$arrError['MSG']	.= "- ".$row['msg'];
				$arrError['FOUND']	= 1;
			}
			
			// CREAR EL CONTRATO
			$idRepLegal = $row['idRepLegal'];

			if($idRepLegal != null){
				// INSERTAR LA DIRECCION DEL CONTRATO
				$idDir	= $oSub->getDireccion();
				$idCDir = $oSub->getCDireccion();

				if($idDir != $idCDir){
					$idDireccion = $idCDir;
					$calle		= $oSub->getCCalle();
					$cnint		= $oSub->getCNint();
					$cnext		= $oSub->getCNext();
					$idPais		= $oSub->getCPais();
					$cestado	= $oSub->getCEstado();
					$cciudad	= $oSub->getCCiudad();
					$ccolonia	= $oSub->getCColonia();
					$ccp		= $oSub->getCCP();
					$ctipo		= $oSub->getCTipoDireccion();
					$sql = "CALL `prealta`.`SP_INSERT_DIRECCION`('$calle', '$cnint', '$cnext', $idPais, $cestado, $cciudad, $ccolonia, $ccp, $ctipo, $idEmpleado);";
					$result = $WBD->SP($sql);
					if($WBD->error()){
						$ERROR = $WBD->error();
					}
					else{
						return array(
							'ERROR'		=> $WBD->error(),
							'MSG'		=> 'No fue posible crear la Dirección del Contrato',
							'SHOWMSG'	=> 1
						);
					}
				}
				else{
					$idDireccion = $idDir;
				}

				$idEjec = $oSub->getIdECuenta();
				if($idEjec >= 100){
					$idEjec = $idEjec;
				}
				else{
					if($idEjec >= 10){
						$idEjec = '0'.$idEjec;
					}
					else {
						$idEjec = '00'.$idEjec;
					}
				}

				$fecha = substr(date("Ymd"),2,7);
				$sql ="CALL `redefectiva`.`SP_COUNT_CONTRATOSDEEJECUTIVO`($idEjec);";

				$result = $RBD->SP($sql);
				$countC = 0;
				list($countC) = mysqli_fetch_row($result);
				$countC = $countC+1;

				if($countC>=100){
					$countC=$countC;
				}
				else{
					if ($countC>=10) {
						$countC = '0'.$countC;
					}
					else{
						$countC = '00'.$countC;
					}
				}

				$n1=rand(0, 9);
				$n2=rand(0, 9);				

				$numeroContrato = $idEjec.$fecha.$countC.$n1.$n2;

				$idVenta		= $oSub->getIdEVenta();
				$idRegimen		= $oSub->getCRegimen();
				$rSocial		= $oSub->getCRSocial();
				$fconst			= ($oSub->getCFConstitucion() != "")? $oSub->getCFConstitucion() : date("Y-m-d H:i:s");
				$crrfc			= $oSub->getCRRfc();
				$idPreContrato	= $oSub->getContrato();

				/* INSERTAR EL CONTRATO */
				$strQ = "CALL `prealta`.`SP_INSERT_CONTRATO`('$numeroContrato', $idVenta, $idRegimen, '$rSocial', '$fconst', '$crrfc', $idRepLegal, $idDireccion, $idEmpleado, '$fecha', $idSubCadena, $idPreContrato);";
				$sql = $WBD->query($strQ);

				if($WBD->error()){
					$arrError['ERROR']	.= 'Contrato : '.$WBD->error().'<br>';
					$arrError['MSG']	.= "- No se pudo insertar el Contrato";
					$arrError['FOUND']	= 1;
				}
				else{
					$res = mysqli_fetch_assoc($sql);

					if($res['CodigoRespuesta'] > 0){
						$arrError['ERROR']	.= $res['CodigoRespuesta'];
						$arrError['MSG']	.= "-".$res['Msg']." ".$res['idContrato']." \\n";
						$arrError['FOUND']	= 1;
					}
				}
			}

			/* INSERTAR LOS COMPROBANTES */
			$arrComp = array(
				array('idComprobante' => $oSub->getDDomicilio(),		'desc' => 'Comprobante de Domicilio'),
				array('idComprobante' => $oSub->getDBanco(),			'desc' => 'Carátula de Banco'),
				array('idComprobante' => $oSub->getDRepLegal(),			'desc' => 'Identificación del Representante Legal'),
				array('idComprobante' => $oSub->getDRSocial(),			'desc' => 'RFC Razón Social'),
				array('idComprobante' => $oSub->getDAConstitutiva(),	'desc' => 'Acta Consitutiva'),
				array('idComprobante' => $oSub->getDPoderes(),			'desc' => 'Poderes')
			);

			foreach($arrComp AS $comp){
				if($comp['idComprobante'] != ""){
					$strQ = "CALL `prealta`.`SP_ALTA_ARCHIVO`($idSubCadena, {$comp['idComprobante']}, $idEmpleado, 2)";
					$sql = $WBD->query($strQ);
					if($WBD->error()){
						$arrError['ERROR']	.= 'Crear ARchivo : '.$WBD->error().'<br>';
						$arrError['MSG']	.= "-No se pudo crear el Archivo : ".$comp['desc']." \\n";
						$arrError['FOUND']	= 1;
					}
				}
			}

			/* INSERTAR LA DIRECCION DE LA SUBCADENA (DATO OPCIONAL)*/
			if($idDir != ''){
				$strQ = "CALL `prealta`.`SP_DIRECCION_ALTA`($idDir, $idSubCadena, 2, $idEmpleado)";
				$sql = $WBD->query($strQ);
				
				if($WBD->error()){
					$arrError['ERROR']	.= 'Insertar Direccion de SubCadena : '.$WBD->error().'<br>';
					$arrError['MSG']	.= "- No se pudo insertar la dirección de la SubCadena \\n";
					$arrError['FOUND']	= 1;
				}
			}

			// INSERTAR LOS CONTACTOS (DATO OPCIONAL)
			$contactos = $oSub->getContactos();
			$numContactos = count($contactos);

			if($numContactos > 0){
				foreach($contactos AS $contacto){
					$query = "CALL `prealta`.`SP_CONTACTO_ALTA`({$contacto->getTipoContacto()},
						'".wordMatch($contacto->getNombre())."',
						'".wordMatch($contacto->getPaterno())."',
						'".wordMatch($contacto->getMaterno())."',
						'".wordMatch($contacto->getTelefono())."',
						'".wordMatch($contacto->getExtTel())."',
						'".wordMatch($contacto->getCorreo())."',
						$idEmpleado,
						'".$contacto->getId()."',
						'".$contacto->getInfId()."',
						'$idSubCadena',
						2
						)";
					$WBD->query($query);

					if($WBD->error()){
						$arrError['ERROR']	.= 'Contactos : '.$WBD->error().'<br>';
						$arrError['MSG']	.= '- No se pudo crear el Contacto';
						$arrError['FOUND']	= 1;
					}
				}
			}

			// CREAR LOS CARGOS
			$query = "CALL `prealta`.`SP_LOAD_PRECARGOS`($idCadena, $idPreSubCadena, -1)";
			$sql = $RBD->query($query);

			if($RBD->error()){
				$arrError['ERROR']	.= 'Leer PreCargos : '.$WBD->error().'<br>';
				$arrError['MSG']	.= '- No se pudieron leer los cargos\\n';
				$arrError['FOUND']	= 1;
			}
			else{
				$montoAfiliacion = 0;
				while($row = mysqli_fetch_assoc($sql)){
					//INSERTAR EN LA TABLA DE CONFIGURACION GENERAL
					$query = "CALL `redefectiva`.`SP_CREATE_CONFIGURACION_CARGOS`({$row['idConcepto']}, {$row['Configuracion']}, {$row['idCadena']}, $idSubCadena, {$row['idCorresponsal']}, {$row['importe']}, '{$row['fechaInicio']}', '{$row['observaciones']}')";
					$sql1 = $WBD->query($query);

					if($WBD->error()){
						$arrError['ERROR']	.= 'Crear Configuracion de Cargos : '.$WBD->error().'<br>';
						$arrError['MSG']	.= '-No se pudo dar de alta la configuración del cargo\\n';
						$arrError['FOUND']	= 1;
					}
					//SI EL CARGO NO ES AFILIACION
					if($row['idConcepto'] != 99){
						$query2 = "CALL `prealta`.`SP_ALTA_CARGO`({$row['idConf']}, $idCadena, $idPreSubCadena, -1, $idCadena, $idSubCadena, -1)";
						$sql2 = $WBD->query($query2);

						if($WBD->error()){
							$arrError['ERROR']	.= 'Alta Cargo : '.$WBD->error().'<br>';
							$arrError['MSG']	.= '-No se pudo crear el cargo\\n';
							$arrError['FOUND']	= 1;
						}
					}
					else{
						if($row['Configuracion'] == 0){
							$montoAfiliacion = $row['importe'];
						}
					}
				}
			}
		
			// CREAR LA CUENTA DE FORELO
			$nombreCuenta = getSubString('', 45);
			$strQ = "CALL `redefectiva`.`SP_ALTA_CUENTA_CLIENTE`($idEmpleado, $idCadena, $idSubCadena, -1, '$nombreCuenta')";
			$sql = $WBD->query($strQ);
			
			if($WBD->error()){
				$arrError['ERROR']	.= 'Cuenta de forelo : '.$WBD->error().'<br>';
				$arrError['MSG']	.= 'No se creó la Cuenta de Forelo<br>';
				$arrError['FOUND']	= 1;
			}
			else{
				$row = mysqli_fetch_assoc($sql);

				if($row['CodigoRespuesta'] > 0){
					return array(
						'ERROR'		=> $row['CodigoRespuesta'],
						'MSG'		=> $row['MsgRespuesta'],
						'SHOWMSG'	=> 1
					);
				}
				else{
					$numCuenta = $row['NumCuenta'];

					// DAR DE ALTA LA CUENTA EN LA SUBCADENA
					$strQ = "CALL `data_contable`.`SP_SET_CUENTA_CLIENTE`($idEmpleado, $idSubCadena, -1, '$numCuenta')";
					$sql = $WBD->query($strQ);
					if(!$WBD->error()){
						$row = mysqli_fetch_assoc($sql);
						if($row['CodigoRespuesta'] > 0){
							return array(
								'ERROR'		=> $row['CodigoRespuesta'],
								'MSG'		=> $row['MsgRespuesta'],
								'SHOWMSG'	=> 1,
								'HINT'		=> 0
							);
						}
						else{

							// CREAR LA REFERENCIA DEL FORELO
							$strQ = "CALL `data_contable`.`SP_SET_REFERENCIA_FORELO`($idEmpleado, '$numCuenta', '$referencia1')";
							$sql = $WBD->query($strQ);
							if($WBD->error()){
								$arrError['ERROR']	.= 'Set Referencia Forelo : '.$WBD->error().'<br>';
								$arrError['MSG']	.= 'No se creó la Referencia de la Cuenta';
								$arrError['FOUND']	= 1;
							}
							if(!$WBD->error()){
								$row = mysqli_fetch_assoc($sql);
								if($row['CodigoRespuesta'] > 0){
									$arrError['ERROR']	.= $row['CodigoRespuesta'];
									$arrError['MSG']	.= $row['MsgRespuesta'];
									$arrError['FOUND']	= 1;
								}
								else{
									$strQ = "CALL `data_contable`.`SP_ALTA_CUENTA_BANCO`($idEmpleado, 1, -1, '$numCuenta', '$clabe', '$rfc', '$nombreBen', '', @resCode, @resMs)";
									$sql = $WBD->query($strQ);
									if($WBD->error()){
										$arrError['ERROR']	.= 'Alta Cuenta Banco : '.$WBD->error().'<br>';
										$arrError['MSG']	.= '- No se pudo Crear la cuenta\\n';
										$arrError['FOUND']	= 1;
									}
								}
							}

							// CREAR LOS MOVIMIENTOS DEL FORELO (DEPOSITOS)
							$strQ = "CALL `data_contable`.`SP_BANCO_PROCESA_CUENTA`('$referencia1')";
							$sql = $WBD->query($strQ);

							if($WBD->error()){
								$arrError['ERROR']	.= 'Depositos : '.$WBD->error().' '.$strQ.'<br>';
								$arrError['MSG']	.= 'Error al Procesar los depósitos';
								$arrError['FOUND']	= 1;
							}
							else{
								$row = mysqli_fetch_array($sql);

								/*if($row[0] == 0){
									$arrError['ERROR']	.= 'Depositos : '.$row[0].' '.$strQ;
									$arrError['MSG']	.= $row[1].'\\n';
									$arrError['FOUND']	= 1;
								}*/

								//cobrar la afiliación
								if($montoAfiliacion > 0){
									$str = "CALL `redefectiva`.`SPO_MOVIMIENTO`('$numCuenta', $montoAfiliacion, 0, 'Afiliacion', 99, $idEmpleado);";
									$sql = $WBD->query($str);

									if($WBD->error()){
										$arrError['ERROR']	.= 'Cobro : '.$WBD->error().' '.$str;
										$arrError['MSG']	.= '- No se pudo cobrar la afiliación'.'\\n';
										$arrError['FOUND']	= 1;
									}
									else{
										$row = mysqli_fetch_assoc($sql);

										if($row['CodigoRespuesta'] > 0){
											$arrError['ERROR']	.= 'Cobro : '.$row['CodigoRespuesta'];
											$arrError['MSG']	.= '- '.$row['DescRespuesta'].'\\n';
											$arrError['FOUND']	= 1;
										}
									}
								}
							}
						}
					}
					else{
						$arrError['ERROR']	.= 'Actualizar Cuenta de SubCadena'.$WBD->error().'';
						$arrError['MSG']	.= "-Error al Actualizar la Cuenta en la SubCadena<br>";
						$arrError['FOUND']	= 1;
					}
				}
			}

			if($arrError['FOUND'] >= 1){
				return $arrError;
			}
			else{
				return array(
					'SHOWMSG'	=> 0,
					'ERROR'		=> '',
					'MSG'		=> 'SubCadena Creada Correctamente ('.$idSubCadena.')'
				);
			}
		}
		else{
			return array(
				'ERROR'		=> "No cuenta con los depósitos necesarios",
				'MSG'		=> "No cuenta con los depósitos necesarios",
				'SHOWMSG'	=> 1
			);
		}
	}
?>