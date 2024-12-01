<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$idProveedor = (!empty($_POST['idProveedor']))? $_POST['idProveedor'] : 0;

	$sql2	= "CALL `data_contable`.`SP_CONF_CORTE_PROVEEDOR_LISTA`($idProveedor);";
	$res	= $RBD->SP($sql2);

	$errmsg = "";

	if(!$RBD->error()){
		while($r = mysqli_fetch_array($res)){
			$data[] = array(
				'idConfiguracion'	=> $r['idConfiguracion'],
				'descripcion'		=> (!preg_match("!!u", $r['descripcion']))? utf8_encode($r['descripcion']) : $r['descripcion']
			);
		}
	}
	else{
		$data	= array();
		$errmsg	= $RBD->error();
	}

	echo json_encode(array(
		'data'		=> $data,
		'total'		=> count($data),
		'errmsg'	=> $errmsg
	));

?>
