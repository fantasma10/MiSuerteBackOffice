<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");


	$idProveedor= (!empty($_GET['idProveedor']))? $_GET['idProveedor'] : 0;
	$numCuenta	= (!empty($_GET['numCuenta']))? $_GET['numCuenta'] : "";

	$actual		= (!empty($_GET["iDisplayStart"]))? $_GET["iDisplayStart"] : 0;
	$cant		= (!empty($_GET["iDisplayLength"]))? $_GET["iDisplayLength"] : 20;

	$colsort	= (isset($_GET['iSortCol_0']) AND $_GET['iSortCol_0'] > -1)? $_GET['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_GET['sSortDir_0']))? $_GET['sSortDir_0'] : 0;
	$strToFind	= (!empty($_GET['sSearch']))? $_GET['sSearch'] : '';

	$fechaInicio	= (!empty($_GET['fechaInicio']))? $_GET['fechaInicio'] : "0000-00-00";
	$fechaFinal		= (!empty($_GET['fechaFinal']))? $_GET['fechaFinal'] : "0000-00-00";

	$idEstatus	= (isset($_GET['idEstatus']) && $_GET['idEstatus'] >= 0)? $_GET['idEstatus'] : -1;
	$idTipoInstruccion = -1;

	$query = "CALL `data_contable`.`SP_INSTRUCCION_ACREEDOR_LOAD`($idProveedor, '$numCuenta', '$idEstatus', '$idTipoInstruccion', '$fechaInicio', '$fechaFinal', '$colsort', '$ascdesc', '$strToFind', '$actual', '$cant')";

	$sql = $RBD->query($query);

	if(!$RBD->error()){

		while($row = mysqli_fetch_assoc($sql)){

			$data[] = array(
				$row['idInstruccion'],
				acentos($row["nombre"]),
				$row["numCuenta"],
				$row["fecInstruccion"],
				"\$ ".number_format($row["importe"], 2),
				"\$ ".number_format($row["impIVA"], 2),
				"\$ ".number_format($row["importeTotal"], 2),
				acentos($row["descripcion"]),
				acentos($row["descEstatus"]),
				($row['idEstatus'] == 6)? '<a href="#" onclick="resetInstruccion(\''.$row['idInstruccion'].'\');">Reintentar</a>' : ''
			);

		}

		$sqlcount = $RBD->query("SELECT FOUND_ROWS() AS total");
		$res = mysqli_fetch_assoc($sqlcount);
		$iTotal = $res["total"];
		if($iTotal == 0){
			$data = array();
		}
		$iTotalDisplayRecords = ($iTotal < $cant)? $iTotal : $cant;
		$output = array(
			"sEcho"                 => intval($_GET['sEcho']),
			"iTotalRecords"         => $iTotal,
			"iTotalDisplayRecords"  => $iTotal,
			"aaData"                => $data
		);

		echo json_encode($output);
	}
	else{
		$output = array(
			"sEcho"                 => intval($_GET['sEcho']),
			"iTotalRecords"         => 0,
			"iTotalDisplayRecords"  => 0,
			"aaData"                => array(),
			"errmsg"				=> $RBD->error()
		);

		echo json_encode($output);
	}


?>