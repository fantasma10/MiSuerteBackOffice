<?php

	include("../../config.inc.php");
	include("../../session.inc.php");

	$tipoProv	= (isset($_POST['tipoProv']))? $_POST['tipoProv'] : 0;
	$text		= (isset($_POST['text']))? $_POST['text'] : '';

	$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_PROVEEDORES_INTERNOS`();");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idProveedor'		=> $row['idProveedor'],
				'nombreProveedor'	=> (!preg_match("!!u", $row['nombreProveedor']))? utf8_encode($row['nombreProveedor']) : $row['nombreProveedor']
			);
		}
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>