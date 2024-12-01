<?php

	include("../../config.inc.php");
	include("../../session.inc.php");

	$idEstatus = (!isset($_POST['idEstatus']))? -1 : $_POST['idEstatus'];

	$sql = $RBD->query("CALL `data_contable`.`SP_ESTATUS_LOAD`($idEstatus);");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idEstatus'		=> $row['idEstatus'],
				'descEstatus'	=> (!preg_match("!!u", $row['descEstatus']))? utf8_encode($row['descEstatus']) : $row['descEstatus']
			);
		}
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>