<?php
	include("../../../config.inc.php");
	include("../../../session.inc.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdUsuario = (!empty($_SESSION['idU']))? $_SESSION['idU'] : 0;
	$pwd		= (!empty($_POST['pwd']))? trim($_POST['pwd']) : '';

	if(empty($nIdUsuario) || $nIdUsuario == 0){
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> 99,
			'sMensaje'	=> 'Para continuar debe Iniciar Sesión nuevamente'
		));
		exit();
	}
	if(empty($pwd)){
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> 100,
			'sMensaje'	=> 'Es necesaria una contraseña para continuar'
		));
		exit();
	}

	$QUERY	= "CALL `redefectiva`.`SP_PATCH_VERIFICACODIGOUSUARIO`('".$nIdUsuario."','".$pwd."');";
	$SQL	= $RBD->SP($QUERY);

	if(!$RBD->error()){
		if(mysqli_num_rows($SQL) == 1){
			$row = mysqli_fetch_assoc($SQL);
			
			if($row['nIdEstatus'] != 0){
				echo json_encode(array(
					'bExito'			=> false,
					'nCodigo'			=> 102,
					'sMensaje'			=> 'No cuenta con permiso para continuar',
					'sMensajeDetallado'	=> $RBD->error()
				));
				exit();
			}

			echo json_encode(array(
				'bExito'	=> true,
				'nCodigo'	=> 0,
				'sMensaje'	=> 'OK'
			));
			
		}
		else{
			echo json_encode(array(
				'bExito'			=> false,
				'nCodigo'			=> 102,
				'sMensaje'			=> 'No cuenta con permiso para continuar',
				'sMensajeDetallado'	=> $RBD->error()
			));
		}

	}
	else{
		echo json_encode(array(
			'bExito'			=> false,
			'nCodigo'			=> 101,
			'sMensaje'			=> 'Ha ocurrido un Error, contacte al administrador del sistema',
			'sMensajeDetallado'	=> $RBD->error()
		));
		exit();
	}

?>