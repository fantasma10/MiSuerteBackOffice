<?php

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	$idTipoCliente = (!empty($_POST['idTipoCliente']))? $_POST['idTipoCliente'] : 0;

	$sql = $RBD->query("CALL `nautilus`.`SP_CARGA_TIPO_ACCESO`($idTipoCliente)");

	if(!$RBD->error()){
		$data = array();

		while($row = mysqli_fetch_assoc($sql)){
			$data[] = $row;
		}

		echo json_encode(array("data" => $data));
	}
	else{
		echo json_encode(array(
			'errmsg'	=> $RBD->error(),
			'data'		=> array()
		));
	}
?>