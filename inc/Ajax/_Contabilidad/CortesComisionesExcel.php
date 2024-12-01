<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");
	global $RBD;

	function acentos($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}

	$idCadena		= (isset($_GET['idCadena']) AND $_GET['idCadena'] >= 0 AND $_GET['idCadena'] != '')?$_GET['idCadena']:-1;
	$idSubCadena	= (isset($_GET['idSubCadena']) AND $_GET['idSubCadena'] >= 0 AND $_GET['idSubCadena'] != '')?$_GET['idSubCadena']:-1;
	$idCorresponsal	= (isset($_GET['idCorresponsal']) AND $_GET['idCorresponsal'] >= 0 AND $_GET['idCorresponsal'] != '')?$_GET['idCorresponsal']:-1;
	$month			= (isset($_GET['month']))?$_GET['month']:0;
	$year			= (isset($_GET['year']))?$_GET['year']:0;
	$idEstatus		= (isset($_GET['idEstatus']))?$_GET['idEstatus']:0;
	$facturaAs		= (isset($_REQUEST['facturaAs']) AND $_REQUEST['facturaAs'] > -1)? $_REQUEST['facturaAs'] : -1;
	$idInstruccion	= (isset($_GET['idInstruccion']))? $_GET['idInstruccion'] : -1;
	$idLiquidacion	= (isset($_GET['idLiquidacion']))? $_GET['idLiquidacion'] : -1;

	//$start	= (!empty($_POST['iDisplayStart']))? $_POST['iDisplayStart'] : 0;
	//$limit	= (!empty($_POST['iDisplayLength']))? $_POST['iDisplayLength'] : 10;

	$start		= (!empty($_REQUEST['start']))? $_REQUEST['start'] : 0;
	$limit		= (!empty($_REQUEST['end']))? $_REQUEST['end'] : 10;
	
	$colsort	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$strToFind	= (!empty($_REQUEST['strToFind']))? utf8_decode($_REQUEST['strToFind']) : '';

	$strQ = "CALL `data_contable`.`SP_CORTES_COMISION_LOAD_2`($idCadena, $idSubCadena, $idCorresponsal, $year, $month, '', 0, '', $colsort, '$ascdesc', '$strToFind', $start, $limit, $idEstatus, $facturaAs, $idInstruccion, $idLiquidacion)";
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
			"mainHead"	=>	"Pagos Corresponsales",
			"headers"	=>	array("Pago", "Cadena", "SubCadena", "Corresponsal", "N&uacute;mero de Cuenta", "Cuenta Contable", "Instrucci&oacute;n","Importe Total", "Total de Ventas", "Factura", "Estatus"),
			"rows"		=>	$data,
			"indexes"	=>	array("descTipoLiquidacion", "nombreCadena", "nombreSubCadena", "nombreCorresponsal", "numCuenta", "ctaContable", "descTipoInstruccion", "importeTotal", "totalVentas", "noFactura", "descEstatus"),
			"formats"	=>	array("", "", "", "", "", "", "", "money","","","")
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