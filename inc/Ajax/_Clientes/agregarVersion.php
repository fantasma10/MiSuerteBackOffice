<?php
	include("../../config.inc.php");
	include("../../session.ajax.inc.php");

	$idGrupo        = (!empty($_POST["idGrupo"]))? $_POST["idGrupo"] : 0;
	$idCadena       = (!empty($_POST["idCadena"]))? $_POST["idCadena"] : 0;
	$idSubCadena    = (!empty($_POST["idSubCadena"]))? $_POST["idSubCadena"] : 0;
	$idCorresponsal = (!empty($_POST["idCorresponsal"]))? $_POST["idCorresponsal"] : 0;
	$idVersion      = (!empty($_POST["idVersion"]))? $_POST["idVersion"] : 0;

	$idUsuario		= $_SESSION["idU"];

	$sql = $WBD->query("CALL `redefectiva`.`SP_INSERT_PERMISOS_DE_GRUPO`($idGrupo, $idCadena, $idVersion, $idUsuario)");

	if(!$WBD->error()){
		$row = mysqli_fetch_assoc($sql);

		if($row['CodigoError'] == 0){
			$arResult = array(
				"showMsg"	=> 0,
				"msg"		=> 'Versión Agregada Exitosamente'
			);
		}
		else{
			$arResult = array(
				"showMsg"	=> 1,
				"msg"		=> 'No ha sido posible agregar la Versión, Inténtelo de Nuevo Más tarde',
				"row"		=> $row,
				"query"		=> "CALL `redefectiva`.`SP_INSERT_PERMISOS_DE_GRUPO`($idGrupo, $idCadena, $idVersion, $idUsuario)"
			);
		}
	}
	else{
		$arResult = array(
			"showMsg"	=> 1,
			"msg"		=> 'Ha ocurrido un Error, Inténtelo de Nuevo Más tarde',
			"errmsg"	=> $WBD->error()
		);
	}

	echo json_encode($arResult);
?>