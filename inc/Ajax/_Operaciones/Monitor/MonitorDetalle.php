<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$hoy = date("Y-m-d");

	$fechaInicial	= (!empty($_POST['fechaInicial']))? $_POST['fechaInicial'] : date("Y-m-d");
	$fechaFinal		= (!empty($_POST['fechaFinal']))? $_POST['fechaFinal'] : date("Y-m-d");	
	$hidCad			= (!empty($_POST['idCadena']))? $_POST['idCadena'] : -2;

	$AND = "";
	if($hidCad > -1){
		$AND = " AND idCadena = ".$hidCad;
	}
	
	/* Busca Operaciones Exitosas */
	$sql = "SELECT COUNT(`idsOperacion`) AS NOP, HOUR(`fecAplicacionOperacion`) AS hora
			FROM `redefectiva`.`ops_operacion`
			WHERE `fecAltaOperacion` BETWEEN '$fechaInicial' AND '$fechaFinal'
			AND `respuestaOperacion` = 0
			$AND
			GROUP BY hora;";

	/* BuscaOperaciones Fallidas */
	$sql_fallidas = "SELECT COUNT(`idsOperacion`) AS NOP, HOUR(`fecAplicacionOperacion`) AS hora
					 FROM `redefectiva`.`ops_operacion`
					 WHERE `fecAltaOperacion` BETWEEN '$fechaInicial' AND '$fechaFinal'
					 AND `respuestaOperacion` > 0
					 $AND
					 GROUP BY hora;";
					 
	$datos = array();

	$datos[0] = array(
		"name"	=> "hora",
		"data"	=> array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23)
	);

	$datos[1] = array(
		"name"	=> "Operaciones Exitosas",
		"data"	=> array(),
		"total" => 0
	);

	$datos[2] = array(
		"name"	=> "Operaciones Fallidas",
		"data"	=> array(),
		"total" => 0
	);


	/* buscar Operaciones Exitosas */
	$sql = $RBD->query($sql);
	$fillDataResult = fillData($sql);
	$datos[1]["data"] = $fillDataResult["operaciones"];
	$datos[1]["total"] = $fillDataResult["total"];

	/* buscar Operaciones Fallidas */
	$sqlFallidas = $RBD->query($sql_fallidas);
	$fillDataResult = fillData($sqlFallidas);
	$datos[2]["data"] = $fillDataResult["operaciones"];
	$datos[2]["total"] = $fillDataResult["total"];

	function fillData($sql){
		$data = array(
			"operaciones" => array(),
			"total" => 0
		);
		$cont = 0;
		$ultimaHoraUsada = -1;
		$totalOperaciones = 0;

		while($row = mysqli_fetch_assoc($sql)){
			if($row["hora"] > 0){
				while($cont < $row["hora"]){
					if($cont != $ultimaHoraUsada){
						$data["operaciones"][] = 0;
					}
					$cont++;
				}
			}

			$data["operaciones"][] = $row["NOP"];
			$totalOperaciones += $row["NOP"];
			$ultimaHoraUsada = $row["hora"];
		}

		if($ultimaHoraUsada < 23){
			while($ultimaHoraUsada <= 23){
				$data["operaciones"][] = 0;
				$ultimaHoraUsada++;
			}
		}
		
		$data["total"] = $totalOperaciones;

		return $data;
	}

	print json_encode($datos, JSON_NUMERIC_CHECK);
?>