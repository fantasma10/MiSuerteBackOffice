<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");
	global $RBD;

	function acentos($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}

	$idGrupo		= (isset($_GET['idGrupo']) AND $_GET['idGrupo'] >= 0 AND $_GET['idGrupo'] != '')?$_GET['idGrupo']:-1;
	$month			= (isset($_GET['month']))?$_GET['month']:0;
	$year			= (isset($_GET['year']))?$_GET['year']:0;
	$estatus		= (isset($_GET['estatus']))?$_GET['estatus']:0;
	$facturaAs		= (isset($_REQUEST['facturaAs']) AND $_REQUEST['facturaAs'] > -1)? $_REQUEST['facturaAs'] : -1;

	$start	= (!empty($_GET['start']))? $_GET['start'] : 0;
	$limit	= (!empty($_GET['end']))? $_GET['end'] : 10;

	$colsort	= (isset($_GET['iSortCol_0']) AND $_GET['iSortCol_0'] > -1)? $_GET['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_GET['sSortDir_0']))? $_GET['sSortDir_0'] : 0;
	$strToFind	= (!empty($_GET['sSearch']))? utf8_decode($_GET['sSearch']) : '';

	$strQ = "CALL `data_contable`.`SP_CORTES_GRUPO_LOAD`($idGrupo, $year, $month, '', 0, '', $colsort, '$ascdesc', '$strToFind', $start, $limit, $estatus, $facturaAs)";

	$sql = $RBD->query($strQ);

	if(!$RBD->error()){

		while($row= mysqli_fetch_assoc($sql)){
			$data[] = $row;
		}

		$sqlcount = $RBD->query("SELECT FOUND_ROWS() AS total");
		$res = mysqli_fetch_assoc($sqlcount);
		$iTotal = $res["total"];
		if($iTotal == 0){
			$data = array();
		}
		$iTotalDisplayRecords = ($iTotal < $limit)? $iTotal : $limit;

		$arrTable = array(
			"mainHead"	=>	"Cortes Grupo",
			"headers"	=>	array("Grupo", "Numero de Cuenta", "Fecha Inicio", "Fecha Final", "Importe Total", "Total Ventas", "Detalle", "Factura", "Estatus"),
			"rows"		=>	$data,
			"indexes"	=>	array("nombreGrupo", "numeroCuenta", "fechaInicio", "fechaFin", "importeTotal", "totalVentas", "detalle", "noFactura", "descEstatus"),
			"formats"	=>	array("", "", "", "", "money", "", "", "", "")
		);

		include("../../../excel/crearTblExcel.php");

		header('Content-Description: File Transfer');
		header('Content-Type=application/x-msdownload');
		header('Content-disposition:attachment;filename='.$filename.'.xls');
		header("Pragma:no-cache");
		header("Set-Cookie: fileDownload=true; path=/");

		echo $tbl;
	}
	else{
		echo $RBD->error();
	}


	
?>