<?php

	include '../../../config.inc.php';

	$nIdCliente = (!empty($_POST['nIdCliente']))? trim($_POST['nIdCliente']) : 0;

	$QUERY = 'call `redefectiva`.`SP_PATCH_SUBCADENA_DATOS`("'.$nIdCliente.'")';

	$sql = $RBD->query($QUERY);
	$data = array();
	if(!$RBD->error()){
		if(mysqli_num_rows($sql) >= 1){
			$row = mysqli_fetch_assoc($sql);
		}
	}
	else{
		echo json_encode(array(
			'bExito' 			=> true,
			'nCodigo'			=> 0,
			'data'				=> array(),
			'sMensaje'			=> 'Ha ocurrido un error, intentelo de nuevo más tarde',
			'sMensajeDetallado'	=> $RBD->error()
		));
	}

	echo json_encode(array(
		'bExito' 	=> true,
		'nCodigo'	=> 0,
		'data'		=> $row,
		'sMensaje'	=> 'ok'
	));

?>