<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	include("../../inc/config.inc.php");

	$idTipoEjecutivo	= (!empty($_POST["idTipoEjecutivo"]))? $_POST["idTipoEjecutivo"] : 0;
	$texto				= (!empty($_POST["texto"]))? $_POST["texto"] : "";

	$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_EJECUTIVOS`($idTipoEjecutivo, '$texto')");

	$data = array();
	if(!$RBD->error()){
		if(mysqli_num_rows($sql) >= 1){
			while($row = mysqli_fetch_assoc($sql)){
				foreach($row AS $k => $r){
					$row[$k] = utf8_encode($r);
				}
				$data[] = $row;
			}
		}
	}
	else{
		echo $RBD->error();
	}

	echo json_encode($data);
?>