<?php

	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");
	include("../../../inc/obj/XMLPreCadena.php");

	$idCadena = (!empty($_POST['idCadena']))? $_POST['idCadena'] : 0;

	$oCadena = new XMLPreCadena($RBD,$WBD);
	$oCadena->load($idCadena);

	$res = $oCadena->AutorizarPreCadena();

	$error = $oCadena->getError();
	$msg = $oCadena->getMsg();

	echo json_encode(
		array(
			"showMsg"	=> ((!empty($error))? 1 : 0),
			"msg"		=> ((!empty($error))? $msg : "Cadena Creada Exitosamente"),
			"errmsg"	=> $error
		)
	);
?>