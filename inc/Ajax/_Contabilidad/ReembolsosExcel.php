<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 0);

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");
	global $RBD;

	function acentos($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}

	$idCadena		= (isset($_GET['idCadena']) AND $_GET['idCadena'] >0)? $_GET['idCadena'] : -1;
	$idSubCadena	= (isset($_GET['idSubCadena']) AND $_GET['idSubCadena'] >0)? $_GET['idSubCadena'] : -1;
	$idCorresponsal	= (isset($_GET['idCorresponsal']) AND $_GET['idCorresponsal'] >0)? $_GET['idCorresponsal'] : -1;
	$numCuenta		= (!empty($_GET['numeroCuenta']))? $_GET['numeroCuenta'] : '';
	$fecha			= (!empty($_GET['fecha']))? $_GET['fecha'] : '0000-00-00';
	$estatus		= (isset($_GET['estatus']))? $_GET['estatus'] : -1;

	$colsort	= (isset($_GET['iSortCol_0']) AND $_GET['iSortCol_0'] > -1)? $_GET['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_GET['sSortDir_0']))? $_GET['sSortDir_0'] : 0;
	$strToFind	= (!empty($_GET['strToFind']))? $_GET['strToFind'] : '';

	$start	= (!empty($_GET['start']))? $_GET['start'] : 0;
	$limit	= (!empty($_GET['end']))? $_GET['end'] : 10;

	$strQ = "CALL `data_contable`.`SP_LOAD_REEMBOLSOS`($idCadena, $idSubCadena, $idCorresponsal, '$numCuenta',$colsort, '$ascdesc', '$strToFind', '$fecha', $estatus, $start, $limit)";
	//var_dump("strQ: $strQ");
	$sql = $RBD->query($strQ);

	if(!$RBD->error()){

		while($row= mysqli_fetch_assoc($sql)){
			$arr = array();
			foreach($row AS $index=> $r){
				if ( !preg_match('!!u', $texto) ) {
					$r = utf8_encode($r);
				}
				$arr[$index] = $r;
			}
			$data[] = $arr;
		}

		$sqlcount = $RBD->query("SELECT FOUND_ROWS() AS total");
		$res = mysqli_fetch_assoc($sqlcount);
		$iTotal = $res["total"];
		if($iTotal == 0){
			$data = array();
		}
		$iTotalDisplayRecords = ($iTotal < $limit)? $iTotal : $limit;

		$arrTable = array(
			"mainHead"	=>	"Reembolsos",
			"headers"	=>	array("Cadena", "SubCadena", "Corresponsal", "N&uacute;mero de Cuenta","Cuenta Contable", "Importe", "Fecha", "Justificaci&oacute;n", "Estatus"),
			"rows"		=>	$data,
			"indexes"	=>	array('nombreCadena', 'nombreSubCadena', 'nombreCorresponsal', 'numCuenta','ctaContable', 'importe', 'fechaReembolso', 'detalle', 'descEstatus'),
			"formats"	=>	array("", "", "", "", "", "money", "", "", "")
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