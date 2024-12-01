<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	$idReembolso = (!empty($_POST['idReembolso']))? $_POST['idReembolso'] : 0;

	$sQ = "CALL `data_contable`.`SP_REEMBOLSO_ELIMINAR`($idReembolso)";
	$WBD->query($sQ);

	if(!$WBD->error()){
		$data = array(
			'showMsg'	=> 1,
			'msg'		=> 'El Reembolso ha sido eliminado Correctamente',
			'errmsg'	=> '',
			'reload'	=> 1
		);
	}
	else{
		$data = array(
			'showMsg'	=> 1,
			'msg'		=> 'No ha sido posible eliminar el Reembolso',
			'errmsg'	=> $WBD->error(),
			'reload'	=> 0
		);
	}

	echo json_encode($data);

?>