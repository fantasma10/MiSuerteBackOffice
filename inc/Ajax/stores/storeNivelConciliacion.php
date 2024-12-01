<?php

	include("../../config.inc.php");
	include("../../session.inc.php");

	$sql = $RBD->query("CALL `data_contable`.`sp_select_nivelconciliacion`();");

	$data = array();
	$nCodigo = 0;

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'nIdNivelConciliacion'		=> $row['nIdNivelConciliacion'],
				'sDescripcion'				=> (!preg_match("!!u", $row['sDescripcion']))? utf8_encode($row['sDescripcion']) : $row['sDescripcion']
			);
		}
	}
	else{
		$nCodigo = 1;
	}

	echo json_encode(array(
		'nCodigo'	=> $nCodigo,
		'data'		=> $data,
		'total'		=> count($data)
	));

?>