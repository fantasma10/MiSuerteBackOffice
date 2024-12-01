<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	include("../../../inc/config.inc.php");
	include("../../../inc/session.inc.php");

	$errores = array();
	$errores[1062] = "El Contacto Seleccionado Ya Existe"; /* error de llave duplicada */

	$idCorresponsal	= (!empty($_POST["idCorresponsal"]))? $_POST["idCorresponsal"] : 0;
	$idContacto		= (!empty($_POST["idContacto"]))? $_POST["idContacto"] : 0;
	$idEmpleado		= $_SESSION["idU"];

	/*
	verificar si el contacto fue agregado al corresponsal anteriormente,
	en caso de que haya sido agregado y después dado de baja solo se cambia el estatus
	*/

	$sql = $WBD->query("CALL `redefectiva`.`SP_VERIFICA_ACTUALIZA_CONTACTO`($idCorresponsal, $idContacto);");

	if(!$WBD->error()){
		$res = mysqli_fetch_assoc($sql);
		if($res['insertar'] == 1){
			$sql = $WBD->query("CALL redefectiva.SP_INSERTA_CONTACTO_CORRESPONSAL($idCorresponsal, $idContacto, $idEmpleado)");

			if(!$WBD->error()){
				$respuesta = array(
					'showMsg'	=> 0,
					'msg'		=> '',
					'errmsg'	=> ''
				);
			}
			else{
				$errcode = mysqli_errno($WBD->LINK);

				$respuesta = array(
					'showMsg'	=> 1,
					'msg'		=> (!empty($errores[$errcode]))? $errores[$errcode] : 'Ha ocurrido un Error, Inténtelo de Nuevo',
					'errmsg'	=> $WBD->error()
				);
			}
		}
		else{
			$respuesta = array(
				'showMsg'	=> 0,
				'msg'		=> 'Contacto Agregado Exitosamente',
				'errmsg'	=> ''
			);
		}
	}
	else{
		$respuesta = array(
			'showMsg'	=> 1,
			'msg'		=> 'Ha ocurrido un error, Inténtelo de Nuevo más tarde',
			'errmsg'	=> $WBD->error()
		);
	}

	echo json_encode($respuesta);
?>