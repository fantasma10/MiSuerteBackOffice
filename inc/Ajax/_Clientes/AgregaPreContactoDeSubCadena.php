<?php

	include("../../../inc/config.inc.php");
	include("../../../inc/session.inc.php");
	include("../../obj/XMLPreCorresponsal.php");

	$errores = array();
	$errores[1062] = "El Contacto Seleccionado Ya Existe"; /* error de llave duplicada */

	$idCorresponsal		= (!empty($_POST["idCorresponsal"]))? $_POST["idCorresponsal"] : 0;
	$idContacto			= (!empty($_POST["idContacto"]))? $_POST["idContacto"] : 0;
	$idTipoContacto		= (!empty($_POST["idTipoContacto"]))? $_POST["idTipoContacto"] : 0;
	$idEmpleado			= $_SESSION["idU"];
	$nombre				= (!empty($_POST['nombre'])) ? $_POST['nombre'] : '';
	$paterno			= (!empty($_POST['paterno'])) ? $_POST['paterno'] : '';
	$materno			= (!empty($_POST['materno'])) ? $_POST['materno'] : '';
	$ext				= (!empty($_POST['ext'])) ? $_POST['ext'] : '';
	$telefono			= (!empty($_POST['telefono'])) ? $_POST['telefono'] : '';
	$correo				= (!empty($_POST['correo'])) ? $_POST['correo'] : '';
	/*
	verificar si el contacto fue agregado al corresponsal anteriormente,
	en caso de que haya sido agregado y después dado de baja solo se cambia el estatus
	*/

	$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
	$oCorresponsal->load($idCorresponsal);
	$oCorresponsal->setID($idCorresponsal);
	$oCorresponsal->setContacto(new Contacto($RBD,$WBD));

	$oCorresponsal->CONTACTO->setNombre($nombre);
	$oCorresponsal->CONTACTO->setId($idContacto);
	$oCorresponsal->CONTACTO->setPaterno($paterno);
	$oCorresponsal->CONTACTO->setMaterno($materno);
	$oCorresponsal->CONTACTO->setTelefono($telefono);
	$oCorresponsal->CONTACTO->setExtTel($ext);
	$oCorresponsal->CONTACTO->setCorreo($correo);
	$oCorresponsal->CONTACTO->setTipoContacto($idTipoContacto);

	$oCorresponsal->setPreRevisadoCargos(false);
    $oCorresponsal->setPreRevisadoBancos(false);
    $oCorresponsal->setPreRevisadoVersion(false);
    $oCorresponsal->setPreRevisadoDocumentacion(false);
    $oCorresponsal->setPreRevisadoGenerales(false);
    $oCorresponsal->setPreRevisadoDireccion(false);
    $oCorresponsal->setPreRevisadoContactos(false);
    $oCorresponsal->setPreRevisadoCuenta(false);
    $oCorresponsal->setRevisadoCargos(false);
    $oCorresponsal->setRevisadoBancos(false);
    $oCorresponsal->setRevisadoVersion(false);
    $oCorresponsal->setRevisadoDocumentacion(false);
    $oCorresponsal->setRevisadoGenerales(false);
    $oCorresponsal->setRevisadoDireccion(false);
    $oCorresponsal->setRevisadoContactos(false);
    $oCorresponsal->setRevisadoEjecutivos(false);
    $oCorresponsal->setRevisadoCuenta(false);
    $oCorresponsal->setRevisadoContrato(false);
    $oCorresponsal->setRevisadoForelo(false);

	$bool = $oCorresponsal->AgregarContactoSub();

	//$res = mysqli_fetch_assoc($sql);

	$msg = $oCorresponsal->getMsg();

	if($bool == true){
		$respuesta = array(
			'showMsg'	=> 0,
			'msg'		=> $msg,
			'errmsg'	=> '',
			'paso'		=> 1
		);
	}
	else{
		$respuesta = array(
			'showMsg'	=> ($bool == false)? 1  : 0,
			'msg'		=> ($bool == false)? $msg : 'Contacto Agregado Exitosamente',
			'errmsg'	=> '',
			'paso'		=> 3,
			'bool'		=> $bool
		);
	}

	echo json_encode($respuesta);	

?>