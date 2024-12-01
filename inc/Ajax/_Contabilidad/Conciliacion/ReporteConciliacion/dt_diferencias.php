<?php
	
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	$nIdTipo				= !empty($_POST['nIdTipo'])										? $_POST['nIdTipo']					: 0;
	$nIdCorte				= !empty($_POST['nIdCorte'])									? $_POST['nIdCorte']				: 0;
	$nIdArchivo				= !empty($_POST['nIdArchivo'])									? $_POST['nIdArchivo']				: 0;
	$nIdNivelConciliacion	= !empty($_POST['nIdNivelConciliacion'])						? $_POST['nIdNivelConciliacion']	: 0;
	$start					= (!empty($_POST["iDisplayStart"]))								? $_POST["iDisplayStart"]			: 0;
	$limit					= (!empty($_POST["iDisplayLength"]))							? $_POST["iDisplayLength"]			: 20;
	$sortCol				= (isset($_POST['iSortCol_0']) AND $_POST['iSortCol_0'] > -1)	? $_POST['iSortCol_0']				: 0;
	$sortDir				= (!empty($_POST['sSortDir_0']))								? $_POST['sSortDir_0']				: 0;

	$oConciliacionDiferencia = new ConciliacionDiferencia();
	$oConciliacionDiferencia->setORdb($oRdb);
	$oConciliacionDiferencia->setNIdTipo($nIdTipo);
	$oConciliacionDiferencia->setNIdNivelConciliacion($nIdNivelConciliacion);
	$oConciliacionDiferencia->setNIdCorte($nIdCorte);
	$oConciliacionDiferencia->setNIdArchivo($nIdArchivo);

	$resultado = $oConciliacionDiferencia->obtener_detalle($start, $limit);

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