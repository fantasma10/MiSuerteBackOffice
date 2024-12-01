<?php
    include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
    include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
    include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

    

    $start			= (!empty($_POST["iDisplayStart"]))								? $_POST["iDisplayStart"]	: 0;
	$limit			= (!empty($_POST["iDisplayLength"]))							? $_POST["iDisplayLength"]	: 10;
	$sortCol		= (isset($_POST['iSortCol_0']) AND $_POST['iSortCol_0'] > -1)	? $_POST['iSortCol_0']		: 0;
	$sortDir		= (!empty($_POST['sSortDir_0']))								? $_POST['sSortDir_0']		: 'ASC';
    $str			= (!empty($_POST['sSearch']))									? $_POST['sSearch']			: '';
    

    $_nIdEmisor=!empty($_POST["cmbClientes"])? $_POST["cmbClientes"]:0;
	$_estatus=!empty($_POST["cmbEstatus"])? $_POST["cmbEstatus"]:-1;
	$_FechaInicio=!empty($_POST["p_dFechaInicio"])? $_POST["p_dFechaInicio"]:'0000-00-00';
	$_FechaFin=!empty($_POST["p_dFechaFin"])? $_POST["p_dFechaFin"]:'0000-00-00';

    $oRDPN->setBDebug(1);

	$oReporte = new PC_OrdenesPagoAyddo($_nIdEmisor,$_estatus,$_FechaInicio,$_FechaFin,$oRDPN);
  
	$resultado = $oReporte->GetList($start,$limit);
    if(!$resultado['bExito'] || $resultado['nCodigo'] != 0 || $resultado['num_rows'] == 0){
		$aaData = array();
		$iTotal = 0;
	}
	else{
		$aaData = $resultado['data'];
		$iTotal = $resultado['found_rows'];
	}


	$output = array(
		"sEcho"					=> intval($_POST['sEcho']),
		"iTotalRecords"			=> $iTotal,
		"iTotalDisplayRecords"	=> $iTotal,
		"aaData"				=> utf8ize($aaData),
		"errmsg"				=> ''
	);

	echo json_encode($output);
?>