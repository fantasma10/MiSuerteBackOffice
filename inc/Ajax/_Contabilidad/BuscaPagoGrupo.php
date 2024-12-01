<?php

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");
	$idPermiso = (isset($_SESSION['Permisos']['Tipo'][3]))?$_SESSION['Permisos']['Tipo'][3]:1;

	global $RBD;

	function acentos($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}

	$idGrupo		= (isset($_GET['idGrupo']) AND $_GET['idGrupo'] >= 0 AND $_GET['idGrupo'] != '')?$_GET['idGrupo']:-1;
	$month			= (isset($_GET['month']))?$_GET['month']:0;
	$year			= (isset($_GET['year']))?$_GET['year']:0;
	$estatus		= (isset($_GET['estatus']))?$_GET['estatus']:-1;
	$facturaAs		= (isset($_REQUEST['facturaAs']) AND $_REQUEST['facturaAs'] > -1)? $_REQUEST['facturaAs'] : -1;
	$idInstruccion	= (isset($_GET['idInstruccion']))? $_GET['idInstruccion'] : -1;

	$start	= (!empty($_GET['iDisplayStart']))? $_GET['iDisplayStart'] : 0;
	$limit	= (!empty($_GET['iDisplayLength']))? $_GET['iDisplayLength'] : 10;

	$colsort	= (isset($_GET['iSortCol_0']) AND $_GET['iSortCol_0'] > -1)? $_GET['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_GET['sSortDir_0']))? $_GET['sSortDir_0'] : 0;
	$strToFind	= (!empty($_GET['sSearch']))? utf8_decode($_GET['sSearch']) : '';

	$strQ = "CALL `data_contable`.`SP_CORTES_GRUPO_LOAD_2`($idGrupo, $year, $month, '', 0, '', $colsort, '$ascdesc', '$strToFind', $start, $limit, $estatus, $facturaAs, $idInstruccion)";
	$sql = $RBD->query($strQ);

	$data = array();

	if(!$RBD->error()){
		$fila = 0;
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				((empty($row['noFactura']))? "<input type='checkbox' idcorte='".$row['idCorte']."' numcuenta='".$row['numeroCuenta']."' class='check' row='".$fila."' importe='".number_format($row['importePago'], 2)."'>" : ""),
				acentos($row['nombreGrupo']),
				$row['numeroCuenta'],
				acentos($row['descTipoInstruccion']),
				$row['fechaInicio'],
				$row['fechaFin'],
				"\$".number_format($row['importePago'], 2),
				$row['totalVentas'],
				acentos($row['detalle']),
				//(($row['noFactura'] == null)? '<a href="#">Asignar Factura</a>' : "<a href='#SectionModal' data-toggle='modal' onclick='AbrirDetalleDeFactura(".$row['tipoDocumento'].", \"".$row['numCuentaProv']."\", \"".$row['noFactura']."\")'> ".$row['noFactura']."</a>"),

				((empty($row['idFactura']))? "" : $row['noFactura']),
				acentos($row['descEstatus'])
			);

			$fila++;
		}

		$sqlcount = $RBD->query("SELECT FOUND_ROWS() AS total");
		$res = mysqli_fetch_assoc($sqlcount);
		$iTotal = $res["total"];
		$error = "";
	}
	else{
		$error = $RBD->error();
		$iTotal = 0;
	}

	$iTotalDisplayRecords = ($iTotal < $limit)? $iTotal : $limit;
	$output = array(
		"sEcho"                 => intval($_GET['sEcho']),
		"iTotalRecords"         => $iTotal,
		"iTotalDisplayRecords"  => $iTotal,
		"aaData"                => $data,
		"errmsg"				=> $error
	);

	echo json_encode($output);
?>