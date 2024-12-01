<?php
	
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
    include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	$nIdCadena			= $_POST['nIdCadena'] != "-1"       ? $_POST['nIdCadena']		: 0;
	$nIdEstatus			= $_POST['nIdEstatus'];
	$nPorAutorizar		= $_POST['nPorAutorizar'];
	$dFechaInicial		= !empty($_POST['dFechaInicial'])	? $_POST['dFechaInicial']	: $nuevafecha;
	$dFechaFinal		= !empty($_POST['dFechaFinal'])		? $_POST['dFechaFinal']		: $nuevafecha;

	$oConciliacionDiferencia = new ConciliacionDiferencia();
	$oConciliacionDiferencia->setNIdCadena($nIdCadena);
	$oConciliacionDiferencia->setORdb($oRdb);

	$resultado = $oConciliacionDiferencia->obtener_importe_total_general($nIdEstatus, $dFechaInicial, $dFechaFinal, $nPorAutorizar);

	echo json_encode(array(
		"sEcho"					=> intval($_POST['sEcho']),
		"bExito"				=> $resultado['bExito'],
		"nCodigo"				=> $resultado['nCodigo'],
        "data"                  => $resultado['data']
	));
?>