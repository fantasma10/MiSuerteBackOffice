<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");
	global $RBD;

	function acentos($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}

	$idCliente	= (!empty($_GET['idCliente']))? $_GET['idCliente'] : 0;
	$numCuenta	= (!empty($_GET['numCuenta']))? $_GET['numCuenta'] : "";

	//$actual		= (!empty($_GET["iDisplayStart"]))? $_GET["iDisplayStart"] : 0;
	//$cant		= (!empty($_GET["iDisplayLength"]))? $_GET["iDisplayLength"] : 20;

	$colsort	= (isset($_GET['iSortCol_0']) AND $_GET['iSortCol_0'] > -1)? $_GET['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_GET['sSortDir_0']))? $_GET['sSortDir_0'] : 0;
	$strToFind	= (!empty($_GET['sSearch']))? $_GET['sSearch'] : '';

	$fechaInicio	= (!empty($_GET['fechaInicio']))? $_GET['fechaInicio'] : "0000-00-00";
	$fechaFinal		= (!empty($_GET['fechaFinal']))? $_GET['fechaFinal'] : "0000-00-00";

	$idEstatus	= (isset($_GET['idEstatus']) && $_GET['idEstatus'] >= 0)? $_GET['idEstatus'] : -1;

	$idTipoInstruccion = -1;

	$actual	= (!empty($_GET['start']))? $_GET['start'] : 0;
	$cant	= (!empty($_GET['end']))? $_GET['end'] : 10;

	$idInstruccion	= (isset($_GET['idInstruccion']))? $_GET['idInstruccion'] : -1;
	$idLiquidacion	= (isset($_GET['idLiquidacion']))? $_GET['idLiquidacion'] : -1;

	$query = "CALL `data_contable`.`SP_INSTRUCCION_CLIENTE_LOAD`($idCliente, '$numCuenta', '$idEstatus', '$idTipoInstruccion', '$fechaInicio', '$fechaFinal', '$colsort', '$ascdesc', '$strToFind', '$actual', '$cant', $idInstruccion, $idLiquidacion)";
	//var_dump($query);
	$sql = $RBD->query($query);

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
		$iTotalDisplayRecords = ($iTotal < $cant)? $iTotal : $cant;

		$arrTable = array(
			"mainHead"	=>	"Instrucciones de Pago Clientes",
			"headers"	=>	array("Id Inst.", "Pago", "Cadena", "SubCadena", "Corresponsal", "Cliente", "N&uacute;mero de Cuenta","Cuenta Contable", "Instrucci&oacute;n", "Fecha", "Importe","Descripci&oacute;n", "Estatus"),
			"rows"		=>	$data,
			"indexes"	=>	array('idInstruccion', 'descTipoLiquidacion','nombreCadena', 'nombreSubCadena', 'nombreCorresponsal', 'nombreCliente', 'numCuenta','ctaContable', 'descripcicon', 'fecInstruccion', 'monto','descripcion', 'descEstatus'),
			"formats"	=>	array("", "", "", "", "", "", "", "", "", "", "money", "", "")
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