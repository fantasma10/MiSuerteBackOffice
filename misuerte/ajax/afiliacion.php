<?php

include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	

	$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;

	switch($tipo){

		case 1 :
			$nombreComercial  = $_POST["nombreComercial"];
			$razonSocial  = $_POST["razonSocial"];
			$rfc  = $_POST["rfc"];
			$beneficiario  = $_POST["beneficiario"];
			$telefono  = $_POST["telefono"];
			$correo  = $_POST["correo"];
			$idPais = $_POST["idPais"];
			$calle = $_POST["calle"];
			$numeroInterior = $_POST["numeroInterior"];
			$numeroExterior = $_POST["numeroExterior"];
			$codigoPostal = $_POST["codigoPostal"];
			$idColonia = $_POST["idColonia"];
			$idMunicipio = $_POST["idMunicipio"];
			$idEstado = $_POST["idEstado"];
			$comision  = $_POST["comision"];
			$porcentajeComision  = $_POST["porcentajeComision"];
			$liquidacionPagos  = $_POST["liquidacionPagos"];
			$pagoComisiones  = $_POST["pagoComisiones"];
			$retencion = $_POST["retencion"];
			$clabe = $_POST["clabe"];
			$referencia = $_POST["referencia"];
			$referenciaAlfa = $_POST["referenciaAlfa"];
			$idBanco = $_POST["idBanco"];
			$metodoPago = $_POST["metodoPago"];	
			$horaInicial = $_POST["horaInicial"];
			$horaFinal = $_POST["horaFinal"];
			$host = $_POST["host"];
			$port = $_POST["port"];
			$user = $_POST["user"];
			$password = $_POST["password"];
			$remoteFolder = $_POST["remoteFolder"];
			$id = $_SESSION["idU"];


			$sql = $MWDB->query("CALL `pronosticos`.`sp_insert_proveedor`('$nombreComercial','$razonSocial','$rfc',
				'$beneficiario','$telefono','$correo','$idPais','$calle','$numeroInterior','$numeroExterior',
				'$codigoPostal','$idColonia','$idMunicipio','$idEstado','$comision','$porcentajeComision',
				 '$liquidacionPagos','$pagoComisiones','$retencion','$clabe','$idBanco','$referencia',
				 '$referenciaAlfa','$metodoPago','$id','$horaInicial','$horaFinal','$host','$port','$user',
				 '$password','$remoteFolder')");


			if(!$MWDB->error()){
				echo json_encode(array(
					"showMessage"	=> 0,
					"msg"			=> "Procedimiento ejecutado con exito"
				));
			}else{
				echo json_encode(array(
					"showMessage"	=> 1,
					"msg"			=> "Ha ocurrido un Error, Inténtelo de Nuevo Más Tarde",
					"errmsg"		=> $MWDB->error()
				));
			}	

		break;


		case 2: 

			$nombreComercial  = $_POST["nombreComercial"];
			$razonSocial  = $_POST["razonSocial"];
			$rfc  = $_POST["rfc"];
			$beneficiario  = $_POST["beneficiario"];
			$telefono  = $_POST["telefono"];
			$correo  = $_POST["correo"];
			$idPais = $_POST["idPais"];
			$calle = $_POST["calle"];
			$numeroInterior = $_POST["numeroInterior"];
			$numeroExterior = $_POST["numeroExterior"];
			$codigoPostal = $_POST["codigoPostal"];
			$idColonia = $_POST["idColonia"];
			$idMunicipio = $_POST["idMunicipio"];
			$idEstado = $_POST["idEstado"];
			$comision  = $_POST["comision"];
			$porcentajeComision  = $_POST["porcentajeComision"];
			$liquidacionPagos  = $_POST["liquidacionPagos"];
			$pagoComisiones  = $_POST["pagoComisiones"];
			$retencion = $_POST["retencion"];
			$clabe = $_POST["clabe"];
			$referencia = $_POST["referencia"];
			$referenciaAlfa = $_POST["referenciaAlfa"];
			$idBanco = $_POST["idBanco"];
			$metodoPago = $_POST["metodoPago"];
			$socioId = $_POST["socioId"];		
			$id = $_SESSION["idU"];
			$token =  md5($referencia);

			$sql= $MWDB->query("CALL `pronosticos`.`sp_insert_cliente`('$nombreComercial','$razonSocial','$rfc',
				'$beneficiario','$telefono','$correo','$idPais','$calle','$numeroInterior','$numeroExterior',							  '$codigoPostal','$idColonia','$idMunicipio','$idEstado','$comision','$porcentajeComision',
							  '$liquidacionPagos','$pagoComisiones','$retencion','$clabe','$idBanco','$referencia',
							  '$referenciaAlfa','$metodoPago','$id','$token','$socioId')");

		break;


		case 3 :

			$banco = $_POST["banco"];
			$cuentaBancaria = $_POST["cuentaBancaria"];
			$cuentaContable = $_POST["cuentaContable"];
			$saldo = $_POST["saldo"];
			$unidad = 3;
			$operacion = $_POST["operacion"];
			$usuario = $_SESSION["idU"];

			$sql = $MWDB->query("CALL `redefectiva`.`SP_INSERT_CFGCUENTA`('$banco','$cuentaBancaria',
									'$cuentaContable','$unidad','$operacion','$saldo','$usuario')");


			if(!$MWDB->error()){
				echo json_encode(array(
					"showMessage"	=> 0,
					"msg"			=> "Procedimiento ejecutado con exito"
				));
			}else{
				echo json_encode(array(
					"showMessage"	=> 1,
					"msg"			=> "Ha ocurrido un Error, Inténtelo de Nuevo Más Tarde",
					"errmsg"		=> $MWDB->error()
				));
			}


		break;
	}



?>