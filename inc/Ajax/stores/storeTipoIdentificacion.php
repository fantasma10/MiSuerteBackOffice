<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_TIPOSDEIDENTIFICACION`();");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idTipoIdentificacion'		=> $row['idTipoIdentificacion'],
				'descTipoIdentificacion'	=> (!preg_match("!!u", $row['descTipoIdentificacion']))? utf8_encode($row['descTipoIdentificacion']) : $row['descTipoIdentificacion']
			);
		}
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>