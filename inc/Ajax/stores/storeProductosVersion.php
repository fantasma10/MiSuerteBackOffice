<?php

	include("../../config.inc.php");
	include("../../session.inc.php");


	$idVersion = (!empty($_POST['idVersion']))? $_POST['idVersion'] : 0;

	$sql = $RBD->query("CALL `redefectiva`.`SP_PRODUCTOS_VERSION`($idVersion);");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idProducto'	=> $row['idProducto'],
				'descProducto'	=> (!preg_match("!!u", $row['descProducto']))? utf8_encode($row['descProducto']) : $row['descProducto']
			);
		}
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>