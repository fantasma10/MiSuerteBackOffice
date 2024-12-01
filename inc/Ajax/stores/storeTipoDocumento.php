<?php

	include("../../config.inc.php");
	include("../../session.inc.php");

	$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_TIPODOCUMENTO`();");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idTipoDocumento'	=> $row['idTipoDocumento'],
				'nombreDocumento'	=> $row['nombreDocumento']
			);
		}
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>