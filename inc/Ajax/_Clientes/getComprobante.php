<?php

	/*error_reporting(E_ALL);
	ini_set("display_errors", 1);*/

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	/*
	**	id				: Cadena	| SubCadena		| Corresponsal
	**	categoria		: 0 Cadena	| 1 SubCadena	| 2 Corresponsal
	**	idComprobante	: id del archivo
	*/
	$id				= (!empty($_POST['id']))? $_POST['id'] : 0;
	$categoria		= (!empty($_POST['categoria']))? $_POST['categoria'] : 0;
	$idComprobante	= (!empty($_POST['idComprobante']))? $_POST['idComprobante'] : 0;

	$sql = $RBD->query("CALL `prealta`.`SP_GET_NOMBREDOCUMENTO`($idComprobante);");

	if(!$RBD->error()){
		$row = mysqli_fetch_assoc($sql);
		$nombre = $row['nombreEncriptado'];

		if($nombre != ""){
			header('Location: ../../../../archivos/Comprobantes/'.$nombre);
		}
		else{
			echo "Comprobante no encontrado.";
		}
	}
	else{
		echo json_encode(
			array(
				'showMsg'	=> 1,
				'msg'		=> 'Error',
				'errmsg'	=> $RBD->error()
			)
		);
	}

?>