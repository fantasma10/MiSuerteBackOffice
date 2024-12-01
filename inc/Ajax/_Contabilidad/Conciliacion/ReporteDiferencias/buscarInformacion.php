<?php
	
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
    include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	$nIdCadena			= $_POST['nIdCadena'] != "-1"       ? $_POST['nIdCadena']		: 0;
	$nIdEstatus			= $_POST['nIdEstatus'];
	$nPorAutorizar		= $_POST['nPorAutorizar'];
	$dFechaInicial		= !empty($_POST['dFechaInicial'])	? $_POST['dFechaInicial']	: $nuevafecha;
	$dFechaFinal		= !empty($_POST['dFechaFinal'])		? $_POST['dFechaFinal']		: $nuevafecha;
	$start				= (!empty($_POST["iDisplayStart"]))								? $_POST["iDisplayStart"]	: 0;
	$limit				= (!empty($_POST["iDisplayLength"]))							? $_POST["iDisplayLength"]	: 20;
	$sortCol			= (isset($_POST['iSortCol_0']) AND $_POST['iSortCol_0'] > -1)	? $_POST['iSortCol_0']		: 0;
	$sortDir			= (!empty($_POST['sSortDir_0']))								? $_POST['sSortDir_0']		: 0;
	
	$oConciliacionDiferencia = new ConciliacionDiferencia();
	$oConciliacionDiferencia->setNIdCadena($nIdCadena);
	$oConciliacionDiferencia->setORdb($oRdb);

	$resultado = $oConciliacionDiferencia->obtener_detalle_general($start, $limit, $nIdEstatus, $dFechaInicial, $dFechaFinal, $nPorAutorizar);

    if(!$resultado['bExito']){
		$aaData = array();
		$iTotal = 0;
		$sMensaje = $resultado['sMensaje'];
	}
	else{
		$aaData = utf8ize($resultado['data']);
		$iTotal = $resultado['found_rows'];
		$sMensaje = '';
	}

	echo json_encode(array(
		"sEcho"					=> intval($_POST['sEcho']),
		"iTotalRecords"			=> $iTotal,
		"iTotalDisplayRecords"	=> $iTotal,
		"aaData"				=> $aaData,
		"errmsg"				=> $sMensaje
	));

?>