<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	/*
		1	Comisión
		2	Grupo
		3	Proveedor
		4	Reembolso
		5	Comisión
		6	Grupo
		7	Proveedor
		8	Reembolso
	*/

	$tipoCorte = (!empty($_POST['tipoCorte']))? $_POST['tipoCorte'] : 0;

	$data = array();

	switch ($tipoCorte) {
		case '1':
			$sql = $RBD->query("SELECT DISTINCT(year) AS year FROM `data_contable`.`dat_corte_comision`");
			while($row = mysqli_fetch_assoc($sql)){
				$data[] = array("anio" => $row['year']);
			}
		break;

		case '2':
			$sql = $RBD->query("SELECT DISTINCT(year) AS year FROM `data_contable`.`dat_corte_grupo`");
			while($row = mysqli_fetch_assoc($sql)){
				$data[] = array("anio" => $row['year']);
			}
		break;

		case '3':
			$sql = $RBD->query("SELECT DISTINCT(year) AS year FROM `data_contable`.`dat_corte_proveedor`");
			while($row = mysqli_fetch_assoc($sql)){
				$data[] = array("anio" => $row['year']);
			}
		break;
		
		default:
			$data[] = array("anio" => date("Y"));
		break;
	}

	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));
?>