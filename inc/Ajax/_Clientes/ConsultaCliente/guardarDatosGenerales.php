<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");


	$idAfiliacion	= (!empty($_POST['idAfiliacion']))	? $_POST['idAfiliacion']	: -1;
	$idCliente		= (!empty($_POST['idCliente']))		? $_POST['idCliente'] 		: -1;
	
	$idGrupo			= (isset($_POST['idGrupo']) AND $_POST['idGrupo'] >= 0)		? $_POST['idGrupo'] 							: -1;
	$idReferencia		= (!empty($_POST['idReferencia']))							? $_POST['idReferencia'] 						: -1;
	$idRegimen			= (!empty($_POST['idRegimen']))								? $_POST['idRegimen'] 						: -1;
	$RFC				= (!empty($_POST['rfcCliente']))							? $_POST['rfcCliente'] 								: "";
	$idGiro				= (!empty($_POST['idGiro']))								? $_POST['idGiro'] 								: -1;

	$razonSocial		= (!empty($_POST['razonSocial']))							? trim(urldecode($_POST['razonSocial'])) 		: "";
	$nombrePersona		= (!empty($_POST['nombreCliente']))							? trim(urldecode($_POST['nombreCliente']))		: "";
	$paternoCliente		= (!empty($_POST['paternoCliente']))						? trim(urldecode($_POST['paternoCliente'])) 		: "";
	$maternoCliente		= (!empty($_POST['maternoCliente']))						? trim(urldecode($_POST['maternoCliente'])) 		: "";
	
	$telefono			= (!empty($_POST['telefono']))								? $_POST['telefono'] 							: "";
	$email				= (!empty($_POST['correo']))									? trim(urldecode($_POST['correo'])) 				: "";
	
	$error = "";

	if($idGrupo == -1){
		$error .= "- Grupo Inválido\n";
	}
	if($idReferencia == -1){
		$error .= "Referencia Inválida\n";
	}
	if($idGiro == -1){
		$error .= "Giro Inválido\n";
	}
	

	if($error == ""){

	}
	else{
		$response = array(
			'showMsg'	=> 1,
			'msg'		=> $error,
			'success'	=> false
		);
	}

	$idCliente = (!empty($_POST['idCliente']))? $_POST['idCliente'] : 0;

	$C = new Cliente($RBD, $WBD, $LOG);
	$C->load($idCliente);

	$respuesta = array();


	if($C->ERROR_CODE == 0){
		$siguiente = 1;
	}
	else{
		$response = array(
			'showMsg'	=> 1,
			'success'	=> false,
			'msg'		=> 'No ha sido posible Cargar los Datos de la Afiliación',
			'errmsg'	=> $C->ERROR_CODE." : ".$C->ERROR_MSG
		);
	}

	$C->ID_GRUPO			= $idGrupo;
	$C->ID_REFERENCIA		= $idReferencia;
	$C->ID_REGIMEN			= $idRegimen;
	$C->RFC_CLIENTE			= strtoupper($RFC);
	$C->ID_GIRO				= $idGiro;
	$C->RAZON_SOCIAL		= utf8_decode($razonSocial);
	$C->NOMBRE_CLIENTE		= utf8_decode($nombrePersona);
	$C->PATERNO_CLIENTE		= utf8_decode($paternoCliente);
	$C->MATERNO_CLIENTE		= utf8_decode($maternoCliente);
	$C->TELEFONO			= str_replace("-", "", $telefono);
	$C->CORREO				= $email;


	$C->ID_EJECUTIVOCUENTA					= (!empty($_POST['idEjecutivoCuenta']))? $_POST['idEjecutivoCuenta'] : 0;
	$C->ID_EJECUTIVOVENTA					= (!empty($_POST['idEjecutivoVenta']))? $_POST['idEjecutivoVenta'] : 0;
	$C->ID_EJECUTIVOAFILIACION_INTERMEDIO	= (!empty($_POST['idEjecutivoAfiliacionInter']))? $_POST['idEjecutivoAfiliacionInter'] : 0;
	$C->ID_EJECUTIVOAFILIACION_AVANZADO		= (!empty($_POST['idEjecutivoAfiliacionAvanz']))? $_POST['idEjecutivoAfiliacionAvanz'] : 0;
	
	$sql = $RBD->query("CALL `redefectiva`.`SP_CLIENTE_VERIFICAR_RFC`('".$C->RFC_CLIENTE."', $idCliente)");

	if(!$RBD->error()){
		$res = mysqli_fetch_assoc($sql);
		$encontrado = $res['encontrado'];

		if($encontrado <= 0){
			$siguiente = 1;
		}
		else{
			$siguiente = 0;
			$response = array(
				'showMsg'	=> 1,
				'msg'		=> 'Ya existe un Cliente con el RFC capturado',
				'errmsg'	=> $resp['errmsg']
			);	
		}
	}
	else{
		$siguiente = 0;
		$response = array(
			'showMsg'	=> 1,
			'msg'		=> 'Ha ocurrido un error, inténtelo nuevamente',
			'errmsg'	=> $RBD->error(),
			"tip"		=> 'rfc'
		);
	}

	if($siguiente == 1){
		$resp = $C->guardarDatosGenerales();

		if($resp['success'] == true){
			$siguiente = 2;
			$response = array(
				'showMsg'	=> 1,
				'msg'		=> 'Operacion Exitosa',
				'errmsg'	=> '',
				'success'	=> true
			);
		}
		else{
			$response = array(
				'showMsg'	=> 1,
				'msg'		=> 'Ha ocurrido un error, inténtelo nuevamente',
				'errmsg'	=> $resp['errmsg'],
				'tip'		=> "generales"
			);
		}
	}
	
	$error = "";
	
	if($siguiente == 2){
		// Actualizar o Crear al Ejecutivo de Cuenta
		$idEjecutivo = $C->ID_EJECUTIVOCUENTA;
		$subcadena = $C->ID_CLIENTE;

		if($idEjecutivo > 0){
			// Buscar al Ejecutivo de Cuenta
			$sql		= "CALL `redefectiva`.`SP_EXISTE_EJECUTIVOSUBCADENA`($subcadena, 5);";
			$sql2		= "CALL `redefectiva`.`SP_UPDATE_EJECUTIVOSUBCADENA`($subcadena, $idEjecutivo, {$_SESSION['idU']}, _IDSUBCADENAEJECUTIVO_);";
			$fecVigen	= date('Y-m-d', strtotime('+10 Year'));
			$sql3		= "CALL `redefectiva`.`SP_INSERT_EJECUTIVOSUBCADENA`($subcadena, $idEjecutivo, '$fecVigen', {$_SESSION['idU']}, 5);";

			$RES = '';
			$RESsql = $RBD->SP($sql);	

			if (mysqli_num_rows($RESsql) > 0){
				$row = mysqli_fetch_assoc($RESsql);

				$arrReplace = array('_IDSUBCADENAEJECUTIVO_');
				$arrReplacements = array($row["idSubCadenaEjecutivo"]);

				$sql2 = str_replace($arrReplace, $arrReplacements, $sql2);

				$WBD->SP($sql2);

				if($WBD->error()){
					$error .= "2|Error al asignar el ejecutivo ".$sql2." ".$WBD->error();
				}
			}
			else{
				$WBD->SP($sql3);
				if($WBD->error()){
					$error .= "1|Error al asignar el ejecutivo ".$sql3." ".$WBD->error();	
				}
			}
		}

		// Actualizar o crear al ejecutivo de Venta
		$idEjecutivoVenta = $C->ID_EJECUTIVOVENTA;
		if($idEjecutivoVenta > 0){
			
			// Buscar al Ejecutivo de Venta
			$sql			= "CALL `redefectiva`.`SP_EXISTE_EJECUTIVOSUBCADENA`($subcadena, 2);";
			$sql2			= "CALL `redefectiva`.`SP_UPDATE_EJECUTIVOSUBCADENA`($subcadena, $idEjecutivoVenta, {$_SESSION['idU']}, _IDSUBCADENAEJECUTIVO_);";
			$fecVigen		= date('Y-m-d', strtotime('+10 Year'));
			$sql3			= "CALL `redefectiva`.`SP_INSERT_EJECUTIVOSUBCADENA`($subcadena, $idEjecutivoVenta, '$fecVigen', {$_SESSION['idU']}, 2);";

			$RES = '';
			$RESsql = $RBD->SP($sql);	
			
			if (mysqli_num_rows($RESsql) > 0){
				$row = mysqli_fetch_assoc($RESsql);

				$arrReplace = array('_IDSUBCADENAEJECUTIVO_');
				$arrReplacements = array($row["idSubCadenaEjecutivo"]);

				$sql2 = str_replace($arrReplace, $arrReplacements, $sql2);

				$WBD->SP($sql2);

				if($WBD->error()){
					$error .= "2|Error al asignar el ejecutivo ".$sql2;
				}
			}
			else{
				$WBD->SP($sql3);
				if($WBD->error()){
					$error .= "1|Error al asignar el ejecutivo ".$sql3." ".$WBD->error();	
				}
			}
		}

		// Actualizar o crear al ejecutivo de Venta
		$idEjecutivoRemesasYSorteos = $C->ID_EJECUTIVOAFILIACION_INTERMEDIO;
		if($idEjecutivoRemesasYSorteos > 0){
			// Buscar al Ejecutivo de Venta
			$sql		= "CALL `redefectiva`.`SP_EXISTE_EJECUTIVOSUBCADENA`($subcadena, 9);";
			$sql2		= "CALL `redefectiva`.`SP_UPDATE_EJECUTIVOSUBCADENA`($subcadena, $idEjecutivoRemesasYSorteos, {$_SESSION['idU']}, _IDSUBCADENAEJECUTIVO_);";
			$fecVigen	= date('Y-m-d', strtotime('+10 Year'));
			$sql3		= "CALL `redefectiva`.`SP_INSERT_EJECUTIVOSUBCADENA`($subcadena, $idEjecutivoRemesasYSorteos, '$fecVigen', {$_SESSION['idU']}, 9);";

			$RES = '';
			$RESsql = $RBD->SP($sql);	
			
			if (mysqli_num_rows($RESsql) > 0){
				$row = mysqli_fetch_assoc($RESsql);

				$arrReplace = array('_IDSUBCADENAEJECUTIVO_');
				$arrReplacements = array($row["idSubCadenaEjecutivo"]);

				$sql2 = str_replace($arrReplace, $arrReplacements, $sql2);

				$WBD->SP($sql2);

				if($WBD->error()){
					$error .= "2|Error al asignar el ejecutivo ".$sql2;
				}
			}
			else{
				$WBD->SP($sql3);
				if($WBD->error()){
					$error .= "1|Error al asignar el ejecutivo ".$sql3." ".$WBD->error();	
				}
			}
		}

		// Actualizar o crear al ejecutivo de Venta
		$idEjecutivoBancarios = $C->ID_EJECUTIVOAFILIACION_AVANZADO;
		if($idEjecutivoBancarios > 0){
			
			// Buscar al Ejecutivo de Venta
			$sql = "CALL `redefectiva`.`SP_EXISTE_EJECUTIVOSUBCADENA`($subcadena, 10);";
			$sql2 = "CALL `redefectiva`.`SP_UPDATE_EJECUTIVOSUBCADENA`($subcadena, $idEjecutivoBancarios, {$_SESSION['idU']}, _IDSUBCADENAEJECUTIVO_);";
			$fecVigen = date('Y-m-d', strtotime('+10 Year'));
			$sql3 = "CALL `redefectiva`.`SP_INSERT_EJECUTIVOSUBCADENA`($subcadena, $idEjecutivoBancarios, '$fecVigen', {$_SESSION['idU']}, 10);";

			$RES = '';
			$RESsql = $RBD->SP($sql);	
			
			if (mysqli_num_rows($RESsql) > 0){
				$row = mysqli_fetch_assoc($RESsql);

				$arrReplace = array('_IDSUBCADENAEJECUTIVO_');
				$arrReplacements = array($row["idSubCadenaEjecutivo"]);

				$sql2 = str_replace($arrReplace, $arrReplacements, $sql2);

				$WBD->SP($sql2);

				if($WBD->error()){
					$error .= "2|Error al asignar el ejecutivo ".$sql2;
				}
			}
			else{
				$WBD->SP($sql3);
				if($WBD->error()){
					$error .= "1|Error al asignar el ejecutivo ".$sql3." ".$WBD->error();	
				}
			}
		}
	}

	$response['error'] = $error;
	echo json_encode($response);
?>