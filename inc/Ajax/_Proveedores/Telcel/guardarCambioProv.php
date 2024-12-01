<?php
	include("../../../config.inc.php");
	include("../../../session.inc.php");

	$nIdProveedor	= (!empty($_POST['nIdProveedor']))? $_POST['nIdProveedor'] : 0;
	$nIdProvTmp		= (!empty($_POST['nIdProvTmp']))? $_POST['nIdProvTmp'] : 0;

	if(empty($_SESSION['idU'])){
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> 99,
			'sMensaje'	=> 'Es Necesario que inicie sesión nuevamenta para continuar'
		));
		exit();
	}

	if(is_numeric($nIdProveedor) && is_numeric($nIdProvTmp) && $nIdProveedor > 0 && $nIdProvTmp > 0){

		$nIdEmpleado = $_SESSION['idU'];

		$QUERY	= "CALL `redefectiva`.`SP_PATCH_UPDATE_TELCELROUTE`('".$nIdEmpleado."', '".$nIdProveedor."', '".$nIdProvTmp."');";
		$SQL	= $WBD->SP($QUERY);

		if(!$WBD->error()){
			echo json_encode(array(
				'bExito'	=> true,
				'nCodigo'	=> 0,
				'sMensaje'	=> 'ok'
			));
		}
		else{
			echo json_encode(array(
				'bExito'			=> false,
				'nCodigo'			=> 100,
				'sMensaje'			=> 'Ha ocurrido un error, contacte al administrador del sistema',
				'sMensajeDetallado'	=> $WBD->error()
			));
		}
	}
	else{
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> 100,
			'sMensaje'	=> 'Parámetros Incorrectos'
		));
	}
?>