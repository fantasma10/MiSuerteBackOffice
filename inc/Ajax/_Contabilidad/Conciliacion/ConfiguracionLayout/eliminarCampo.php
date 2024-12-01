<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$nIdCadena	= !empty($_POST['nIdCadena'])	? $_POST['nIdCadena']	: 0;
	$nIdCampo	= !empty($_POST['nIdCampo'])	? $_POST['nIdCampo']	: '';

	$oCampo = new InfCampoConciliacion();
	$oCampo->setOWdb($oWdb);
	$oCampo->setNIdCadena($nIdCadena);
	$oCampo->setNIdCampo($nIdCampo);

	$resultado = $oCampo->sp_eliminar_campo();

	echo json_encode($resultado);

?>