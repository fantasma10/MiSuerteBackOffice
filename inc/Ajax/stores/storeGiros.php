<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_GIROS`();");

	$data = array();

	$error = "";

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idGiro'		=> $row['idGiro'],
				'nombreGiro'	=> (!preg_match('!!u', $row['nombreGiro']))? utf8_encode($row['nombreGiro']) : $row['nombreGiro']
			);
		}
	}
	else{
		$error = $RBD->error();
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data),
		'error'	=> $error
	));

?>