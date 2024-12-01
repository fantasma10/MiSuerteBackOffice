<?php
	error_reporting(E_ALL);
	ini_set('display_errors',1 );
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_TIPOS_DE_CONTACTO`();");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idTipoContacto'	=> $row['idTipoContacto'],
				'descTipoContacto'	=> (!preg_match("!!u", $row['descTipoContacto']))? utf8_encode($row['descTipoContacto']) : $row['descTipoContacto']
			);
		}
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>