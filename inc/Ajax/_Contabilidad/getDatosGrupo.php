<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$idGrupo = (isset($_POST['idGrupo']))?$_POST['idGrupo'] : -1;

	$response = array();
	$RFC = '';

	$SQ = "CALL `redefectiva`.`SP_GRUPO_LOAD`($idGrupo, '$RFC')";
	$sql = $RBD->query($SQ);

	if(!$RBD->error()){

		$res = mysqli_fetch_assoc($sql);

		$response = array(
			'success'	=> true,
			'showMsg'	=> 0,
			'data'		=> array(
				'txtRFC'			=> $res['RFC'],
				'txtRazonSocial'	=> $res['razonSocial'],
				'txtNumCta'			=> $res['numCuenta']
			)
		);
	}
	else{
		$response = array(
			'success'	=> false,
			'showMsg'	=> 0,
			'data'		=> array(
				'txtRFC'			=> '',
				'txtRazonSocial'	=> '',
				'txtNumCta'			=> ''
			),
			'errmsg'	=> $RBD->error()
		);
	}

	echo json_encode($response);

?>