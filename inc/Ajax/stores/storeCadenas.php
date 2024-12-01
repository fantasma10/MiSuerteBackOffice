<?php

	include("../../config.inc.php");
	include("../../session.inc.php");

	$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_CADENAS`();");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idCadena'		=> $row['idCadena'],
				'nombreCadena'	=> (!preg_match("!!u", $row['nombreCadena']))? utf8_encode($row['nombreCadena']) : $row['nombreCadena']
			);
		}
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>