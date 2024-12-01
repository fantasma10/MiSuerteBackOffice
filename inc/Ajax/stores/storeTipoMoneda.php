<?php

	include("../../config.inc.php");
	include("../../session.inc.php");

	$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_MONEDA`();");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'codigoMoneda'		=> $row['codigoMoneda'],
				'descripcionMoneda'	=> (!preg_match("!!u", $row['descripcionMoneda']))? utf8_encode($row['descripcionMoneda']) : $row['descripcionMoneda']
			);
		}
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>