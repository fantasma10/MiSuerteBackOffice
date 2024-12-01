<?php

	include("../../config.inc.php");
	include("../../session.inc.php");

	$idAcreedor = (!empty($_POST['idAcreedor']) && $_POST['idAcreedor'] >= 1)? $_POST['idAcreedor'] : 0;
	$idEstatus	= (isset($_POST['idEstatus']) && $_POST['idEstatus'] >= 0)? $_POST['idEstatus'] : -1;
	$RFC		= (!empty($_POST['RFC']) && trim($_POST['RFC']) != "")? $_POST['RFC'] : "";

	$sql = $RBD->query("CALL `redefectiva`.`SP_ACREEDOR_LOAD`($idAcreedor, '$RFC', $idEstatus);");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idProveedor'		=> $row['idAcreedor'],
				'nombreProveedor'	=> (!preg_match("!!u", $row['nombre']))? utf8_encode($row['nombre']) : $row['nombre']
			);
		}
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>