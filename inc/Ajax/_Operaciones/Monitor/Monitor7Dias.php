<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$hoy = date("Y-m-d");

	$sql_Semana = "SELECT DAYOFWEEK(`fecAplicacionOperacion`) AS dia, COUNT(`idsOperacion`) AS NOP#, `fecAplicacionOperacion` AS dia, 
				   FROM `redefectiva`.`ops_operacion`
				   WHERE `fecAltaOperacion` <= '".$hoy."'
				   AND `fecAltaOperacion` >= '".$hoy."' - INTERVAL 6 DAY
				   AND `idEstatusOperacion` = 0
				   GROUP BY DAYOFWEEK(`fecAplicacionOperacion`) ASC;";			   

	$datos = array();

	$dias_sem = array(1=>"Domingo", 2=>"Lunes", 3=>"Martes", 4=>"Miércoles", 5=>"Jueves", 6=>"Viernes", 7=>"Sábado");

	$hoy 	= date("Y-m-d",time());
		$arraydate 	= explode ("-", $hoy);
		$dateunix	= mktime(0,0,0,$arraydate[1],$arraydate[2],$arraydate[0]);
	$hoy 			= date("w", $dateunix)+1;

	$ayer 	= date("Y-m-d",time()-86400);
		$arraydate 	= explode ("-", $ayer);
		$dateunix	= mktime(0,0,0,$arraydate[1],$arraydate[2],$arraydate[0]);
	$ayer 			= date("w", $dateunix)+1;

	$ayerm1 = date("Y-m-d",time()-172800);
		$arraydate 	= explode ("-", $ayerm1);
		$dateunix	= mktime(0,0,0,$arraydate[1],$arraydate[2],$arraydate[0]);
	$ayerm1 		= date("w", $dateunix)+1;

	$ayerm2 = date("Y-m-d",time()-259200);
		$arraydate 	= explode ("-", $ayerm2);
		$dateunix	= mktime(0,0,0,$arraydate[1],$arraydate[2],$arraydate[0]);
	$ayerm2 		= date("w", $dateunix)+1;

	$ayerm3 = date("Y-m-d",time()-345600);
		$arraydate 	= explode ("-", $ayerm3);
		$dateunix	= mktime(0,0,0,$arraydate[1],$arraydate[2],$arraydate[0]);
	$ayerm3 		= date("w", $dateunix)+1;

	$ayerm4 = date("Y-m-d",time()-432000);
		$arraydate 	= explode ("-", $ayerm4);
		$dateunix	= mktime(0,0,0,$arraydate[1],$arraydate[2],$arraydate[0]);
	$ayerm4 		= date("w", $dateunix)+1;

	$ayerm5 = date("Y-m-d",time()-518400);
		$arraydate 	= explode ("-", $ayerm5);
		$dateunix	= mktime(0,0,0,$arraydate[1],$arraydate[2],$arraydate[0]);
	$ayerm5 		= date("w", $dateunix)+1;

	$arregloDias = array($ayerm5,$ayerm4,$ayerm3,$ayerm2,$ayerm1,$ayer,$hoy);

	$datos[0] = array(
		"name"	=> "dia",
		"data"	=> array()
	);

	$datos[1] = array(
		"name"	=> "Operaciones",
		"data"	=> array(),
		"total" => 0
	);

	$sql = $RBD->query($sql_Semana);
	
	$arrDias = array();
	$totalOperaciones = 0;
	while($row = mysqli_fetch_assoc($sql)){
		$arrDias[$row["dia"]] = $row["NOP"];
		$totalOperaciones += $row["NOP"];
	}

	$datos[1]["total"] = $totalOperaciones;
	foreach($arregloDias AS $nDia){
		$datos[0]["data"][] = $dias_sem[$nDia];
		$entro = 0;

		foreach ($arrDias as $dia => $op){
			if($nDia == $dia){
				$datos[1]["data"][] = $op;
				$entro = 1;
			}
		}

		if($entro == 0){
			$datos[1]["data"][] = 0;
			$entro = 0;
		}
	}

	print json_encode($datos, JSON_NUMERIC_CHECK);
?>