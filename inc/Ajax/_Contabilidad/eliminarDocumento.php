<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	$idFactura = (!empty($_POST['idFactura']))? $_POST['idFactura'] : 0;

	$sQ = "CALL `data_contable`.`SP_FACTURAS_ELIMINAR`($idFactura)";
	$WBD->query($sQ);

	if(!$WBD->error()){
		$data = array(
			'showMsg'	=> 1,
			'msg'		=> 'Elemento Cancelado Correctamente',
			'errmsg'	=> '',
			'reload'	=> 1
		);
	}
	else{
		$data = array(
			'showMsg'	=> 1,
			'msg'		=> 'No ha sido posible eliminar el Elemento seleccionado',
			'errmsg'	=> $WBD->error(),
			'reload'	=> 0
		);
	}

	echo json_encode($data);

?>