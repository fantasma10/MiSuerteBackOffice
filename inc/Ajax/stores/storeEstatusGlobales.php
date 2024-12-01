<?php

	include("../../config.inc.php");
	include("../../session.inc.php");

	$op = (!isset($_POST['op']))? 21 : $_POST['op'];

	$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_ESTATUS_GLOBAL`($op);");

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