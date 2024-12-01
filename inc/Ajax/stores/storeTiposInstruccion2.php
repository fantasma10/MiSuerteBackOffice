<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$idTipoMovimiento = (isset($_POST["idTipoMovimiento"]))? $_POST["idTipoMovimiento"] : -1;

	$sql = $RBD->query("CALL `redefectiva`.`SP_GET_TIPOINSTRUCCION`($idTipoMovimiento)");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idTipoInstruccion'	=> $row['idTipoInstruccion'],
				'descripcion'		=> (!preg_match("!!u", $row['descripcicon']))? utf8_encode($row['descripcicon']) : $row['descripcicon']
			);
		}
	}

	echo json_encode(array(
		'data'		=> $data,
		'total'		=> count($data),
		'nCodigo'	=> 0
	));

?>