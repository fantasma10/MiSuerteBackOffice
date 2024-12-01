<?php

	include '../../../config.inc.php';

	$nIdCliente			= (!empty($_POST['nIdCliente']))? $_POST['nIdCliente'] : 0;
	$nIdCorresponsal	= (!empty($_POST['nIdCorresponsal']))? $_POST['nIdCorresponsal'] : 0;
	
	if($nIdCliente > 0 && $nIdCorresponsal > 0){

		$QUERY = 'call `redefectiva`.`SP_PATCH_UPDATE_CORRESPONSAL`('.$nIdCliente.', '.$nIdCorresponsal.')';
		$sql = $WBD->query($QUERY);
		$data = array();
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
				'sMensaje'			=> 'Ha ocurrido un Error, contacte al administrador del sistema.',
				'sMensajeDetallado'	=> $WBD->error()
			));
		}
	}
	else{
		echo json_encode(array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Debe Seleccionar Corresponsal y Cliente',
			'sMensajeDetallado'	=> $WBD->error()
		));
	}

?>