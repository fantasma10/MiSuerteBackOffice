<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$idTipoRegimen	= (!empty($_POST['idTipoRegimen']))? $_POST['idTipoRegimen'] : 0;
	$idEstatus		= (!empty($_POST['idEstatus']))? $_POST['idEstatus'] : -1;


	$sql = $RBD->query("CALL `afiliacion`.`SP_REGIMEN_LOAD`($idTipoRegimen, $idEstatus);");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idTipoRegimen'	=> $row['idTipoRegimen'],
				'nombre'		=> (!preg_match("!!u", $row['nombre']))? utf8_encode($row['nombre']) : $row['nombre']
			);
		}
	}
	else{
		$error = $RBD->error();
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data),
		'error' => $error
	));

?>