<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	$directorio = $_SERVER['HTTP_HOST'];
	$PATHRAIZ = "https://".$directorio;

	$idPerfil = $_SESSION['idPerfil'];
	$idOpcion = 20;

	$esEscritura = false;
	if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
	}

	$idCadena		= (isset($_GET['idCadena']) AND $_GET['idCadena'] >= '0')? $_GET['idCadena'] : -1;
	$idSubCadena	= (isset($_GET['idSubCadena']) AND $_GET['idSubCadena'] >= '0')? $_GET['idSubCadena'] : -1;
	$idCorresponsal	= (isset($_GET['idCorresponsal']) AND $_GET['idCorresponsal'] >0)? $_GET['idCorresponsal'] : -1;
	$numCuenta		= (!empty($_GET['numeroCuenta']))? $_GET['numeroCuenta'] : '';
	$fecha			= (!empty($_GET['fecha']))? $_GET['fecha'] : '0000-00-00';
	$estatus		= (isset($_GET['estatus']))? $_GET['estatus'] : -1;

	$actual		= (!empty($_GET["iDisplayStart"]))? $_GET["iDisplayStart"] : 0;
	$cant		= (!empty($_GET["iDisplayLength"]))? $_GET["iDisplayLength"] : 10;
	$colsort	= (isset($_GET['iSortCol_0']) AND $_GET['iSortCol_0'] > -1)? $_GET['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_GET['sSortDir_0']))? $_GET['sSortDir_0'] : 0;
	$strToFind	= (!empty($_GET['sSearch']))? $_GET['sSearch'] : '';

	$query = "CALL `data_contable`.`SP_LOAD_REEMBOLSOS`($idCadena, $idSubCadena, $idCorresponsal, '$numCuenta', $colsort, '$ascdesc', '$strToFind', '$fecha', $estatus, $actual, $cant)";
	//var_dump($query);
	$sql = $RBD->query($query);

	if(!$RBD->error()){

		while($row = mysqli_fetch_assoc($sql)){

			$idCorte = $row['idCorte'];

			$array = array(
				acentos($row["nombreCadena"]),
				acentos($row["nombreSubCadena"]),
				acentos($row["nombreCorresponsal"]),
				$row["numCuenta"],$row["ctaContable"],
				"\$ ".number_format($row["importe"], 2),
				$row['fechaReembolso'],
				$row['detalle'],
				"<a href='#ModalEditarReembolso' data-toggle='modal' data-keyboard='false' onclick='verReembolso($idCorte);'>Ver</a>",
				acentos($row['descEstatus'])
			);

			//contabilidad coordinador
			/*if($esEscritura && $row['idEstatus'] != 3){
				if($idPerfil == 3 || $idPerfil == 1){
					//$array[] = "";
					$array[] = "<a href='#ModalEditarReembolso' data-toggle='modal' data-keyboard='false' onclick='editarReembolso($idCorte);'><img src='".$PATHRAIZ."/img/edit.png' title='Editar'></a>";
					$array[] = "<a href='#' onclick='eliminarReembolso($idCorte, event)'><img src='".$PATHRAIZ."/img/delete.png' title='Eliminar'></a>";
				}//contabilidad base
				elseif($idPerfil == 9){
					$array[] = "<a href='#ModalEditarReembolso' data-toggle='modal' data-keyboard='false' onclick='editarReembolso($idCorte);'><img src='".$PATHRAIZ."/img/edit.png' title='Editar'></a>";
				}
			}
			else{
				$array[] = "";
				$array[] = "";
			}*/
			
			if($esEscritura && $row['idEstatus'] != 3){
				if($idPerfil == 3 || $idPerfil == 1){
					//$array[] = "";
					//$array[] = "<a href='#ModalEditarReembolso' data-toggle='modal' data-keyboard='false' onclick='editarReembolso($idCorte);'><img src='".$PATHRAIZ."/img/edit.png' title='Editar'></a>";
					//$array[] = "";
					$array[] = "<a href='#' onclick='eliminarReembolso($idCorte, event)'><img src='".$PATHRAIZ."/img/delete.png' title='Eliminar'></a>";
				}//contabilidad base
				elseif($idPerfil == 9){
					//$array[] = "<a href='#ModalEditarReembolso' data-toggle='modal' data-keyboard='false' onclick='editarReembolso($idCorte);'><img src='".$PATHRAIZ."/img/edit.png' title='Editar'></a>";
					$array[] = "";
				}
			}
			else{
				$array[] = "";
				$array[] = "";
			}			

			$data[] = $array;
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
		echo $RBD->error();
	}

?>