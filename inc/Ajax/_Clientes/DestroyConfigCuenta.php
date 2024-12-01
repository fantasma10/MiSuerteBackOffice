<?php

	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	$idConfiguracion = (!empty($_POST["idConfiguracion"]))? $_POST["idConfiguracion"] : 0;

	$sql = $WBD->query("CALL `data_contable`.`SP_DELETE_CUENTA_CONF`($idConfiguracion)");

	if(!$WBD->error()){
		echo json_encode(array(
			"showMessage"	=> 0,
			"msg"			=> ""
		));
	}
	else{
		echo json_encode(array(
			"showMessage"	=> 1,
			"msg"			=> "Ha ocurrido un Error, Inténtelo de Nuevo Más Tarde",
			"errmsg"		=> $WBD->error()
		));
	}
?>