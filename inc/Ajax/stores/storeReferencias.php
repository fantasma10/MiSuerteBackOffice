<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_REFERENCIAS`();");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idReferencia'		=> $row['idReferencia'],
				'nombreReferencia'	=> (!preg_match("!!u", $row['nombreReferencia']))? utf8_encode($row['nombreReferencia']) : $row['nombreReferencia']
			);
		}
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>