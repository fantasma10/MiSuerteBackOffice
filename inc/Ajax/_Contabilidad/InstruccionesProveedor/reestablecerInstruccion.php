<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$idInstruccion = (!empty($_POST['idInstruccion']))? $_POST['idInstruccion'] : 0;

	if($idInstruccion <= 0){
		echo json_encode(array(
			'success'	=> false,
			'msg'		=> "Número de Instrucción Inválida",
			'showMsg'	=> 1
		));exit();
	}

	$QUERY = "CALL `data_contable`.`SP_INSTRUCCION_PROVEEDOR_REESTABLECER`($idInstruccion)";

	$WBD->query($QUERY);

	if(!$WBD->error()){
		$response = array(
			'success'	=> true,
			'msg'		=> "Instrucción Reestablecida Correctamente",
			'showMsg'	=> 0
		);
	}
	else{
		$response = array(
			'success'	=> false,
			'msg'		=> "No ha sido posible Reestablecer la Instrucción",
			'showMsg'	=> 0,
			'errmsg'	=> $WBD->error()
		);
	}

	echo json_encode($response);
?>