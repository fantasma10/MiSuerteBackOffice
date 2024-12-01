<?php
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");


$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;

switch($tipo){

	case 1: 

		$sql = $MRDB->query("CALL `pronosticos`.`sp_select_proveedores`()");

	
		$datos = array();

		$index = 0;

		while($row = mysqli_fetch_assoc($sql)){
			$datos[$index]["id"] = $row["nIdProveedor"];
			$datos[$index]["estatus"] = $row["nIdEstatus"];
			$datos[$index]["nombre"]= utf8_encode($row["sNombreComercial"]);
			$datos[$index]["comision"] = $row["nImporteComision"];		
			$datos[$index]["liquidacion"] = $row["nDiasLiquidacionPagos"];
			$datos[$index]["porcentajeComision"] = $row["nPorcentajeComision"];
			
			if($row["nNeteo"] == 1)
			{
				$datos[$index]["retencion"] = "Con Retencion";
			}else{
				$datos[$index]["retencion"] = "Sin Retencion";
			}
			$index++;
		}

	print json_encode($datos);

	break;

	case 2: 

		$sql = $MRDB->query("CALL `pronosticos`.`sp_select_clientes`()");

	
		$datos = array();

		$index = 0;

		while($row = mysqli_fetch_assoc($sql)){
			$datos[$index]["id"] = $row["nIdCliente"];
			$datos[$index]["estatus"] = $row["nIdEstatus"];
			$datos[$index]["nombre"]= utf8_encode($row["sNombreComercial"]);
			$datos[$index]["comision"] = $row["nImporteComision"];		
			$datos[$index]["liquidacion"] = $row["nDiasLiquidacionPagos"];
			$datos[$index]["porcentajeComision"] = $row["nPorcentajeComision"];
			if($row["nNeteo"] == 1)
			{
				$datos[$index]["retencion"] = "Sin Retencion";
			}else{
				$datos[$index]["retencion"] = "Con Retencion";
			}
			$index++;
		}


	print json_encode($datos);

	break;


	case 3: 	

		$id = $_POST["id"];

		$sql = $MRDB->query("CALL `pronosticos`.`sp_select_informacion_proveedor`('$id')");

	
		$datos = array();

		$index = 0;

		while($row = mysqli_fetch_assoc($sql)){
			$datos[$index]["nombreComercial"]= utf8_encode($row["sNombreComercial"]);
			$datos[$index]["razonSocial"] = utf8_encode($row["sRazonSocial"]);		
			$datos[$index]["rfc"] = $row["sRFC"];
			$datos[$index]["beneficiario"] = utf8_encode($row["sNombreBeneficiario"]);
			$datos[$index]["telefono"] = $row["sTelefono"];
			$datos[$index]["correo"] = $row["sEmail"];
			$datos[$index]["calle"] = utf8_encode($row["sCalle"]);
			$datos[$index]["numeroInterior"]= $row["sNumInterno"];
			$datos[$index]["numeroExterior"] = $row["nNumExterno"];		
			$datos[$index]["codigoPostal"] = $row["nCodigoPostal"];
			$datos[$index]["colonia"] = utf8_encode($row["sNombreColonia"]);
			$datos[$index]["municipio"] = utf8_encode($row["sNombreMunicipio"]);
			$datos[$index]["estado"] = utf8_encode($row["sNombreEntidad"]);
			$datos[$index]["comision"] = $row["nImporteComision"];		
			$datos[$index]["liquidacion"] = $row["nDiasLiquidacionPagos"];
			$datos[$index]["retencion"] = $row["nNeteo"];
			$datos[$index]["porcentajeComision"] = $row["nPorcentajeComision"];
			$datos[$index]["clabe"] = $row["sCLABE"];
			$datos[$index]["numerica"] = $row["sNumerica"];
			$datos[$index]["alfanumerica"] = $row["sAlfanumerica"];
			$datos[$index]["id"] = $row["nIdProveedor"];
			$datos[$index]["host"] = $row["sHost"];
			$datos[$index]["user"] = $row["sUser"];
			$datos[$index]["pass"] = $row["sPass"];
			$datos[$index]["port"] = $row["nPort"];
			$datos[$index]["folderRemote"] = $row["sRemoteFolder"];
			$datos[$index]["localFolder"] = $row["sLocalFolder"];
			$datos[$index]["file"] = $row["sFileName"];
			$datos[$index]["extension"] = $row["sExtension"];
			$datos[$index]["comisiones"] = $row["nDiasPagoComisiones"];

			$index++;
		}

	print json_encode($datos);

	break;


	case 4 :

	$id = $_POST["idProveedor"];
	$nombreComercial  = $_POST["nombreComercial"];
	$beneficiario  = $_POST["beneficiario"];
	$telefono  = $_POST["telefono"];
	$correo  = $_POST["correo"];
	$comision  = $_POST["comision"];
	$liquidacion  = $_POST["liquidacion"];
	$clabe = $_POST["clabe"];
	$retencion = $_POST["retencion"];
	$referencia = $_POST["referencia"];
	$referenciaAlfa = $_POST["referenciaAlfa"];
	$banco = $_POST["banco"];	
	$perComision = $_POST["perComision"];
	$nIdUsuario = $_SESSION['idU'];

	$host  = $_POST["host"];
	$port  = $_POST["port"];
	$user = $_POST["user"];
	$password = $_POST["password"];
	$remoteFolder = $_POST["remoteFolder"];
	$folderLocal = $_POST["folderLocal"];
	$fileName = $_POST["fileName"];	
	$fileExtension = $_POST["fileExtension"];
	$pagoComisiones = $_POST["pagoComisiones"];





	$sql = $MWDB->query("CALL `pronosticos`.`sp_update_informacion_proveedor`('$nombreComercial','$beneficiario', 
		'$telefono','$correo','$comision','$liquidacion','$clabe','$retencion',
		'$referencia','$referenciaAlfa','$banco','$nIdUsuario','$perComision','$id','$host','$port','$user',
		'$password','$remoteFolder','$folderLocal','$fileName','$fileExtension','$pagoComisiones')");



	if(!$MWDB->error()){
		echo json_encode(array(
			"showMessage"	=> 0,
			"msg"			=> "Procedimiento ejecutado con exito",
			"sMensaje"      => "Informacion Actualizada con Exito",
			"mensaje"		=> $mensaje
		));
	}else{
		echo json_encode(array(
			"showMessage"	=> 500,
			"msg"			=> "Ha ocurrido un Error, Inténtelo de Nuevo Más Tarde",
			"errmsg"		=> $MWDB->error()
		));
	}

	break;


	case 5:
		
		$id = $_POST["idEmisor"];
		$estatus = $_POST["estatus"];
		$nIdUsuario = $_SESSION['idU'];

		$sql = $MWDB->query("CALL `pronosticos`.`sp_update_estatus_emisor`('$id','$estatus','$nIdUsuario')");



	if(!$MWDB->error()){
		echo json_encode(array(
			"showMessage"	=> 0,
			"msg"			=> "Procedimiento ejecutado con exito",
			"sMensaje"      => "Informacion Actualizada con Exito"
		));
	}else{
		echo json_encode(array(
			"showMessage"	=> 500,
			"msg"			=> "Ha ocurrido un Error, Inténtelo de Nuevo Más Tarde",
			"errmsg"		=> $MWDB->error()
		));
	}

	break;


	case 6: 	

		$id = $_POST["id"];

		$sql = $MRDB->query("CALL `pronosticos`.`sp_select_informacion_cliente`('$id')");

	
		$datos = array();

		$index = 0;

		while($row = mysqli_fetch_assoc($sql)){
			$datos[$index]["nombreComercial"]= utf8_encode($row["sNombreComercial"]);
			$datos[$index]["razonSocial"] = utf8_encode($row["sRazonSocial"]);		
			$datos[$index]["rfc"] = $row["sRFC"];
			$datos[$index]["beneficiario"] = utf8_encode($row["sNombreBeneficiario"]);
			$datos[$index]["telefono"] = $row["sTelefono"];
			$datos[$index]["correo"] = $row["sEmail"];
			$datos[$index]["calle"] = utf8_encode($row["sCalle"]);
			$datos[$index]["numeroInterior"]= $row["sNumInterno"];
			$datos[$index]["numeroExterior"] = $row["nNumExterno"];		
			$datos[$index]["codigoPostal"] = $row["nCodigoPostal"];
			$datos[$index]["colonia"] = utf8_encode($row["sNombreColonia"]);
			$datos[$index]["municipio"] = utf8_encode($row["sNombreMunicipio"]);
			$datos[$index]["estado"] = utf8_encode($row["sNombreEntidad"]);
			$datos[$index]["comision"] = $row["nImporteComision"];		
			$datos[$index]["liquidacion"] = $row["nDiasLiquidacionPagos"];
			$datos[$index]["pagoComisiones"] = $row["nDiasPagoComisiones"];
			$datos[$index]["socio"] = $row["nIdSocio"];
			$datos[$index]["retencion"] = $row["nNeteo"];
			$datos[$index]["porcentajeComision"] = $row["nPorcentajeComision"];
			$datos[$index]["clabe"] = $row["sCLABE"];
			$datos[$index]["numerica"] = $row["sNumerica"];
			$datos[$index]["alfanumerica"] = $row["sAlfanumerica"];
			$datos[$index]["id"] = $row["nIdCliente"];
			$index++;
		}

	print json_encode($datos);

	break;



	case 7 :

	$id = $_POST["idCliente"];
	$nombreComercial  = $_POST["nombreComercial"];
	$beneficiario  = $_POST["beneficiario"];
	$telefono  = $_POST["telefono"];
	$correo  = $_POST["correo"];
	$comision  = $_POST["comision"];
	$liquidacion  = $_POST["liquidacion"];
	$clabe = $_POST["clabe"];
	$retencion = $_POST["retencion"];
	$referencia = $_POST["referencia"];
	$referenciaAlfa = $_POST["referenciaAlfa"];
	$banco = $_POST["banco"];	
	$perComision = $_POST["perComision"];
	$diasComisiones = $_POST["pagoComisiones"];
	$socio = $_POST["socio"];
	$nIdUsuario = $_SESSION['idU'];



	$sql = $MWDB->query("CALL `pronosticos`.`sp_update_informacion_cliente`('$nombreComercial','$beneficiario', 
		'$telefono','$correo','$comision','$liquidacion','$clabe','$retencion',
		'$referencia','$referenciaAlfa','$banco','$nIdUsuario','$perComision','$id','$diasComisiones','$socio')");



	if(!$MWDB->error()){
		echo json_encode(array(
			"showMessage"	=> 0,
			"msg"			=> "Procedimiento ejecutado con exito",
			"sMensaje"      => "Informacion Actualizada con Exito"
		));
	}else{
		echo json_encode(array(
			"showMessage"	=> 500,
			"msg"			=> "Ha ocurrido un Error, Inténtelo de Nuevo Más Tarde",
			"errmsg"		=> $MWDB->error()
		));
	}

	break;


	case 8:
		
		$id = $_POST["idCadena"];
		$estatus = $_POST["estatus"];
		$nIdUsuario = $_SESSION['idU'];

		$sql = $MWDB->query("CALL `pronosticos`.`sp_update_estatus_cadena`('$id','$estatus','$nIdUsuario')");



	if(!$MWDB->error()){
		echo json_encode(array(
			"showMessage"	=> 0,
			"msg"			=> "Procedimiento ejecutado con exito",
			"sMensaje"      => "Informacion Actualizada con Exito"
		));
	}else{
		echo json_encode(array(
			"showMessage"	=> 500,
			"msg"			=> "Ha ocurrido un Error, Inténtelo de Nuevo Más Tarde",
			"errmsg"		=> $MWDB->error()
		));
	}

	break;



	case 9:

		$id = $_POST["token"];
		$token =  md5($id.rand());

		echo json_encode(array(
			"showMessage"	=> 0,
			"msg"			=> "Procedimiento ejecutado con exito",
			"token"			=> $token
		));

	break;


}

?>