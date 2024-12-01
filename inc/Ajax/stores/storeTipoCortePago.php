<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$idTipoCortePago	= (isset($_POST['idTipoCortePago']))? $_POST['idTipoCortePago'] : 0;
	$idEstatus			= (isset($_POST['idEstatus']))? $_POST['idEstatus'] : -1;

	$sql = $RBD->query("CALL `redefectiva`.`SP_TIPOCORTEPAGO_LOAD`($idTipoCortePago, '$idEstatus');");

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idTipoCortePago'	=> $row['idTipoCortePago'],
				'descTipoCortePago'	=> (!preg_match("!!u", $row['descTipoCortePago']))? utf8_encode($row['descTipoCortePago']) : $row['descTipoCortePago']
			);
		}
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>