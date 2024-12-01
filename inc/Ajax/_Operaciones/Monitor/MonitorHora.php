<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$hoy = date("Y-m-d");
	
	$sql_hora = "SELECT COUNT(`idsOperacion`) AS NOP, HOUR(`fecAplicacionOperacion`) AS hora
				 FROM `redefectiva`.`ops_operacion`
				 WHERE `fecAltaOperacion` = '".$hoy."'
				 AND `idEstatusOperacion` = 0
				 GROUP BY hora;";
	
	$datos = array();

	$sql = $RBD->query($sql_hora);

	$datos[0] = array(
		"name"	=> "hora",
		"data"	=> array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23)
	);

	$datos[1] = array(
		"name"	=> "Operaciones",
		"data"	=> array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
		"total" => 0
	);
	
	$totalOperaciones = 0;
	while($row = mysqli_fetch_assoc($sql)){
		$datos[1]["data"][$row["hora"]] = $row["NOP"];
		$totalOperaciones += $row["NOP"];
	}
	$datos[1]["total"] = $totalOperaciones;

	print json_encode($datos, JSON_NUMERIC_CHECK);
?>