<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$idTipoProveedor = (isset($_POST['idTipoProveedor']) AND $_POST['idTipoProveedor'] >= 0)? $_POST['idTipoProveedor'] : -1;

	$sql = $RBD->query("CALL `redefectiva`.`SP_TIPOPROVEEDOR_LOAD`($idTipoProveedor);");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idTipoProveedor'	=> $row['idTipoProveedor'],
				'descTipoProveedor'	=> (!preg_match("!!u", $row['descTipoProveedor']))? utf8_encode($row['descTipoProveedor']) : $row['descTipoProveedor']
			);
		}
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>