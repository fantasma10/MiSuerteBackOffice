<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

/*

	PROCEDURE `SP_LOAD_CORTES_PROVEEDOR`(
		IN	Ck_idProveedor		INT,
		IN	Ck_numCuenta		CHAR(10),
		IN	Ck_idTipoProveedor	INT,
		IN	Ck_idAutorizacion	INT,
		IN	Ck_year				INT,
		IN	Ck_month			INT,
		IN	Ck_fechaInicio		DATE,
		IN	Ck_fechaFin			DATE,
		IN	Ck_totalOperaciones	INT,
		IN	Ck_idFactura		INT,
		IN	Ck_noFactura		VARCHAR(64),
		IN	Ck_fecPago			DATE
	)

*/

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	function acentos($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}

	$idProveedor		= (!empty($_REQUEST['proveedor']))? $_REQUEST['proveedor'] : 0;
	$month				= (!empty($_REQUEST['month']))? $_REQUEST['month'] : 0;
	$year				= (!empty($_REQUEST['year']))? $_REQUEST['year'] : 0;
	$estatus			= (isset($_REQUEST['estatus']) && $_REQUEST['estatus'] >= 0)? $_REQUEST['estatus'] : -1;
	$facturaAs			= (isset($_REQUEST['facturaAs']) AND $_REQUEST['facturaAs'] > -1)? $_REQUEST['facturaAs'] : -1;
	// EL valor por default del tipo de proveedor es 0 ya que se utiliza en la pantalla de consultas de cortes de proveedor
	$idTipoProveedor	= (!empty($_REQUEST['idTipoProveedor']))? $_REQUEST['idTipoProveedor'] : 0;

	$actual		= (!empty($_REQUEST["iDisplayStart"]))? $_REQUEST["iDisplayStart"] : 0;
	$cant		= (!empty($_REQUEST["iDisplayLength"]))? $_REQUEST["iDisplayLength"] : 20;

	$colsort	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$strToFind	= (!empty($_REQUEST['sSearch']))? $_REQUEST['sSearch'] : '';

	$query = "CALL `data_contable`.`SP_CORTES_PROVEEDOR_LOAD`($idProveedor, '', $idTipoProveedor, 0, $year, $month, '0000-00-00', '0000-00-00', 0, 0, '', '0000-00-00', $colsort, '$ascdesc', '$strToFind', $actual, $cant, $estatus, $facturaAs)";

	$sql = $RBD->query($query);

	if(!$RBD->error()){

		while($row= mysqli_fetch_assoc($sql)){

			$noFacturas = explode(",", $row['noFactura']);
			//"<a href='#SectionModal' data-toggle='modal' onclick='AbrirDetalleDeFactura(".$row['tipoDocumento'].", \"".$row['numCuentaProv']."\", \"".$row['noFactura']."\")'> ".$row['noFactura']."</a>")
			$arrlinks = array();

			foreach($noFacturas AS $noFactura){
				$arrlinks[] = "<a href='#SectionModal' data-toggle='modal' onclick='AbrirDetalleDeFactura(1, \"".$row['numCuenta']."\", \"".$noFactura."\" )'>".$noFactura."</a>";
			}

			$strlinks = implode(",<br>", $arrlinks);

			$colFactura = (empty($row["noFactura"]))? "<a href='#SectionModal' class='linkFacturas' data-toggle='modal' tipoProveedor='".$idTipoProveedor."' idCorte='".$row['idCorte']."' idProveedor='".$row['idProveedor']."' importe='".$row["importeTotal"]."' onclick='showListaFacturas(event)'>Asignar Factura</a>" : $strlinks;

			$data[] = array(
				acentos($row["nombreProveedor"]),
				$row["numCuenta"],
				$row["fechaInicio"],
				$row["fechaFin"],
				"\$ ".number_format($row["importeNeto"], 2),
				"\$ ".number_format($row["impIva"], 2),
				"\$ ".number_format($row["importeTotal"], 2),
				number_format($row["totalOperaciones"], 0),
				$colFactura,
				$row["fecPago"],
				acentos($row["descripcion"]),
				acentos($row["descEstatus"]),
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