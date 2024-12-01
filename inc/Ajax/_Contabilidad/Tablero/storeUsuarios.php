<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	$oUsuario = new Usuarios($RBD, $WBD);
	$arrRes = $oUsuario->listaUsuarios();

	if($arrRes['codigoRespuesta'] == 0){
		echo json_encode(array(
			'nCodigo'	=> 0,
			'bExito'	=> true,
			'sMensaje'	=> 'Consulta Ok',
			'data'		=> utf8ize($arrRes['data'])
		));
	}
?>