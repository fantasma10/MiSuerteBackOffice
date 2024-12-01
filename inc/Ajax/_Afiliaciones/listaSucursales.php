<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$idAfiliacion	= (!empty($_REQUEST['idAfiliacion']))	? $_REQUEST['idAfiliacion']	: -1;
	$idCliente		= (!empty($_REQUEST['idAfiliacion']))	? $_REQUEST['idAfiliacion'] : -1;
	$idSubCadena	= (!empty($_REQUEST['idSubCadena']))	? $_REQUEST['idSubCadena'] 	: -1;

	$start	= (!empty($_REQUEST['iDisplayStart']))? $_REQUEST['iDisplayStart'] : 0;
	$limit	= (!empty($_REQUEST['iDisplayLength']))? $_REQUEST['iDisplayLength'] : 10;

	$colsort	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$strToFind	= (!empty($_REQUEST['sSearch']))? utf8_decode($_REQUEST['sSearch']) : '';

	if(isset($_REQUEST['real']) && $_REQUEST['real'] == "0"){
		$idSubCadena = $idAfiliacion;
		$idAfiliacion = 0;
	}

	$QUERY = "CALL `afiliacion`.`SP_SUCURSAL_LISTA`($idAfiliacion, $colsort, '$ascdesc', '$strToFind', $start, $limit, $idSubCadena);";
	//var_dump($QUERY);
	$sql = $RBD->query($QUERY);

	$data = array();

	if(!$RBD->error()){
		$fila = 0;
		while($row= mysqli_fetch_assoc($sql)){

			$data[] = array(
				(!preg_match("!!u", $row['NombreSucursal'])) ? utf8_encode($row['NombreSucursal']) : $row['NombreSucursal'],
				$row['referenciaBancaria']
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