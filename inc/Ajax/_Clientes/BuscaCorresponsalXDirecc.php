<?php
	include("../../config.inc.php");
	include("../../session.ajax.inc.php");

	if(!isset($_SESSION['Permisos'])){
		header("Location: ../../../logout.php"); 
	    exit(); 
	}

	$idPermiso 	= (isset($_SESSION['Permisos']['Tipo'][0]))?$_SESSION['Permisos']['Tipo'][0]:1;

	$idpais		= (isset($_GET['idPais']))?$_GET['idPais']: -2;
	$idedo		= (isset($_GET['idEdo']))?$_GET['idEdo']: -2;
	$idcd		= (isset($_GET['idMun']))?$_GET['idMun']: -2;
	$idcol		= (isset($_GET['idCol']))?$_GET['idCol']: -2;
	$status		= (isset($_GET['status']))?$_GET['status']:0;
	$idCadena	= (isset($_GET['idCadena']) AND $_GET["idCadena"] >=0)? $_GET["idCadena"] : -1;
	$idSubCad	= (isset($_GET['idSubCad']) AND $_GET["idSubCad"] >=0)? $_GET["idSubCad"] : -1;
	$idCor		= (isset($_GET['idCor']) AND $_GET["idCor"] >=0)? $_GET["idCor"] : -1;

	global $RBD;

	$start	= (!empty($_GET["iDisplayStart"]))? $_GET["iDisplayStart"] : 0;
	$cant	= (!empty($_GET["iDisplayLength"]))? $_GET["iDisplayLength"] : 20;

	$colsort	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$strToFind	= (!empty($_REQUEST['sSearch']))? $_REQUEST['sSearch'] : '';

	$Result = $RBD->query("CALL redefectiva.SP_LOAD_CORRESPONSALES_BY_PARAMS($idCadena, $idSubCad, $idCor, $idpais, $idedo, $idcd, $idcol, $start, $cant, $colsort, '$ascdesc', '$strToFind')");
	if($RBD->error() == ''){

		if(mysqli_num_rows($Result) > 0 ){

			$data = array();
			while($row=mysqli_fetch_assoc($Result)){
				$id = $row["idCorresponsal"];

				$data[] = array(
					$row["idCorresponsal"],
					(!preg_match('!!u', $row["nombreCorresponsal"]))? utf8_encode($row["nombreCorresponsal"]) : $row["nombreCorresponsal"],
					utf8_encode($row["telefono1"]),
					(!preg_match('!!u', utf8_encode($row["nombreEntidad"])))? utf8_encode($row["nombreEntidad"]) : utf8_encode($row["nombreEntidad"]),
					'<a href="#" onclick="getInfoCorresponsal5('.$id.')">Ver</a>'
				);
			}

			$sqlcount = $RBD->query("SELECT FOUND_ROWS() AS total");
			$res = mysqli_fetch_assoc($sqlcount);
			$iTotal = $res["total"];

			$iTotalDisplayRecords = ($iTotal < $cant)? $iTotal : $cant;
			$output = array(
				"sEcho"					=> intval($_GET['sEcho']),
				"iTotalRecords"			=> $iTotal,
				"iTotalDisplayRecords"	=> $iTotal,
				"aaData"				=> $data
			);

			echo json_encode($output);
		}
		else{
			$output = array(
				"sEcho"					=> intval($_GET['sEcho']),
				"iTotalRecords"			=> 0,
				"iTotalDisplayRecords"	=> 0,
				"aaData"				=> array()
			);
			echo json_encode( $output );
		}
	}
	else{

    	$output = array(
			"sEcho"					=> intval($_GET['sEcho']),
			"iTotalRecords"			=> 0,
			"iTotalDisplayRecords"	=> 0,
			"aaData"				=> array($RBD->error())
		);
		echo json_encode($output);
	}