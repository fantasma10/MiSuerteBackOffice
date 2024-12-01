<?php

	include("../../config.inc.php");
	include("../../session.inc.php");

	$sql = $RBD->query("CALL `data_contable`.`sp_select_autorizaciones_diferencias`();");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'nIdAutorizacion'		=> $row['nIdAutorizacion'],
				'sNombreAutorizacion'	=> (!preg_match("!!u", $row['sNombreAutorizacion']))? utf8_encode($row['sNombreAutorizacion']) : $row['sNombreAutorizacion']
			);
		}
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>