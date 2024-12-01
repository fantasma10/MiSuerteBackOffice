<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	$oTipoOperacion = new Cat_TipoOperacion();
	$oTipoOperacion->setORdb($oRdb);

	$oTipoOperacion->setNIdTIpoOperacion(-1);
	$oTipoOperacion->setNIdEstatus(0);

	$arrRes = $oTipoOperacion->carga_catalogo();

	echo json_encode($arrRes);
?>