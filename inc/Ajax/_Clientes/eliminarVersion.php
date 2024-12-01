<?php

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	$idGrupo	= (!empty($_POST["idGrupo"]))? $_POST["idGrupo"] : 0;
	$idCadena	= (!empty($_POST["idCadena"]))? $_POST["idCadena"] : 0;
	$idVersion	= (!empty($_POST["idVersion"]))? $_POST["idVersion"] : 0;
	$idUsuario	= $_SESSION["idU"];

	$sql = $WBD->query("CALL `redefectiva`.`SP_DROP_PERMISOS_POR_CADENA`($idGrupo, $idCadena, $idVersion, $idUsuario);");

	if(!$WBD->error()){
		echo json_encode(array(
			"showMsg"	=> 0
		));
	}
	else{
		echo json_encode(array(
			"showMsg"	=> 1,
			"msg"		=> "Ha ocurrido un error, inténtelo más tarde",
			"errmsg"	=> $WBD->error()
		));
	}

?>