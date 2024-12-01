<?php

	include("../../config.inc.php");
	include("../../session.inc.php");

	$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_FAMILIAS`();");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idFamilia'		=> $row['idFamilia'],
				'descFamilia'	=> (!preg_match("!!u", $row['descFamilia']))? utf8_encode($row['descFamilia']) : $row['descFamilia']
			);
		}
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>