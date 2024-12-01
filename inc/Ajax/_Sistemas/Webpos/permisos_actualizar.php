<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	session_start();

	if (isset($_SESSION['MiSuerte'])){
		if($IP != $_SESSION['sip']){
			echo json_encode(array(
				'bExito'	=> false,
				'nCodigo'	=> '9999',
				'sMensaje'	=> 'Su sesión ha caducado.'
			));
			exit();
		}
	}
	else{
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> '9998',
			'sMensaje'	=> 'Su sesión ha caducado.'
		));
		exit();
	}

	$nIdUsuario = $_SESSION['idU'];
	$sql = "CALL `data_webpos`.`SP_UPDATE_PERMISOS`($nIdUsuario);";
    $res = $WBD->query($sql);

    if($WBD->error() == ''){
        echo json_encode(array(
			'bExito'			=> false,
			'nCodigo'			=> 102,
			'sMensaje'			=> 'Los permisos han sido actualizados.',
			'sMensajeDetallado'	=> ''
        ));
    }
    else{
		echo json_encode(array(
			'bExito'			=> false,
			'nCodigo'			=> 102,
			'sMensaje'			=> 'Ha ocurrido un error, intente de nuevo más tarde',
			'sMensajeDetallado'	=> $WBD->error()
		));
    }

?>