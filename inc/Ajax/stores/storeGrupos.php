<?php

	include("../../config.inc.php");
	include("../../session.inc.php");

	$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_GRUPOS`();");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idGrupo'		=> $row['idGrupo'],
				'nombreGrupo'	=> (!preg_match("!!u", $row['nombreGrupo']))? utf8_encode($row['nombreGrupo']) : $row['nombreGrupo']
			);
		}
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>