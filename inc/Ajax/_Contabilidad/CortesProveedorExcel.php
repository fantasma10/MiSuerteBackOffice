<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");
	global $RBD;

	function acentos($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}

	$idProveedor		= (!empty($_REQUEST['proveedor']))? $_REQUEST['proveedor'] : 0;
	$idEstatus			= (!empty($_REQUEST['estatus']))? $_REQUEST['estatus'] : -1;
	$month				= (!empty($_REQUEST['month']))? $_REQUEST['month'] : 0;
	$year				= (!empty($_REQUEST['year']))? $_REQUEST['year'] : 0;
	$idTipoProveedor	= (!empty($_REQUEST['idTipoProveedor']))? $_REQUEST['idTipoProveedor'] : 0;
	$facturaAs			= (isset($_REQUEST['facturaAs']) AND $_REQUEST['facturaAs'] > -1)? $_REQUEST['facturaAs'] : -1;

	$actual		= (!empty($_REQUEST["start"]))? $_REQUEST["start"] : 0;
	$cant		= (!empty($_REQUEST["end"]))? $_REQUEST["end"] : 20;

	$colsort	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$strToFind	= (!empty($_REQUEST['sSearch']))? $_REQUEST['sSearch'] : '';

	$query = "CALL `data_contable`.`SP_CORTES_PROVEEDOR_LOAD`($idProveedor, '', $idTipoProveedor, 0, $year, $month, '0000-00-00', '0000-00-00', 0, 0, '', '0000-00-00', $colsort, '$ascdesc', '$strToFind', $actual, $cant, $idEstatus, $facturaAs)";

	$sql = $RBD->query($query);

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
		$iTotalDisplayRecords = ($iTotal < $cant)? $iTotal : $cant;

		$arrTable = array(
			"mainHead"	=>	"Cortes Proveedor",
			"headers"	=>	array("Proveedor", "Numero de Cuenta", "Fecha Inicio", "Fecha Final", "Importe", "Iva", "Importe Total", "Total Operaciones", "Factura", "Fecha de Pago", "Descripcion"),
			"rows"		=>	$data,
			"indexes"	=>	array("nombreProveedor", "numCuenta", "fechaInicio", "fechaFin", "importeNeto", "impIva", "importeTotal", "totalOperaciones", "noFactura", "fecPago", "descripcion"),
			"formats"	=>	array("", "", "", "", "", "money", "money", "money", "", "", "", "")
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