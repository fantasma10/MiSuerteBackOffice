<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$pais = (!empty($_POST['idpais']))? $_POST['idpais'] : 0;

	$res = NULL;
	$sql2 = "CALL `paycash`.`sp_select_estados`('$pais');";
	$res = $MRDB->SP($sql2);

	if($res != NULL){

		while($r = mysqli_fetch_array($res)){
			$data[] = array(
				'idEstado'		=> $r[0],
				'descEstado'	=> (!preg_match("!!u", $r[1]))? utf8_encode($r[1]) : $r[1]
			);
		}

	}
	else{
		
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>