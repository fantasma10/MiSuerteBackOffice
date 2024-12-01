<?php
	/*error_reporting(e_all);
	ini_set('display_errors' 1);*/

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	global $RBD,$LOG;

	//$idPermiso 	= (isset($_SESSION['Permisos']['Tipo'][3]))?$_SESSION['Permisos']['Tipo'][3]:1;

	$idCadena	= (isset($_POST['cad']))?$_POST['cad'] : -2;
	$idSubCad	= (isset($_POST['subcad']))?$_POST['subcad'] : -2;
	$idCor		= (isset($_POST['corr']))?$_POST['corr'] : -2;
	$Fechai		= (isset($_POST['fechai']))?$_POST['fechai'] : strftime( "%Y-%m-%d", time() );
	$Fechaf		= (isset($_POST['fechaf']))?$_POST['fechaf'] : strftime( "%Y-%m-%d", time() );
	$Prov		= (isset($_POST['prov']))?$_POST['prov'] : -2;
	$Prod		= (isset($_POST['prod']))?$_POST['prod'] : -2;
	$Fam		= (isset($_POST['fam']))?$_POST['fam'] : -2;
	$SubF		= (isset($_POST['subfam']))?$_POST['subfam'] : -2;
	$Emisor		= (isset($_POST['emisor']))?$_POST['emisor'] : -2;
	$tipoBus	= (isset($_POST['tipoBus']))?$_POST['tipoBus'] : 1;


	$AND = "";
	if($idCadena > -1)
		$AND .= " AND MOPS.`idCadena` = ".$idCadena;
		
	if($idSubCad > -1)
		$AND .= " AND MOPS.`idSubCadena` = ".$idSubCad;
		
	if($idCor	> -1)
		$AND .= " AND MOPS.`idCorresponsal` = ".$idCor;
		
	if($Prov 	> -1)
		$AND .= " AND MOPS.`idProveedor` = ".$Prov;
		
	if($Prod	> -1)
		$AND .= " AND MOPS.`idProducto` = ".$Prod;
		
	if($Fam		> -1)
		$AND .= " AND MOPS.`idFamilia` = ".$Fam;

	if($SubF	> -1)
		$AND .= " AND MOPS.`idSubFamilia` = ".$SubF;
		
	if($Emisor	> -1)
		$AND .= " AND MOPS.`idEmisor` = ".$Emisor;

	$SELEC 	= '';
	$INER  	= '';
	$GROUP 	= '';
	$por	= '';
	
	switch($tipoBus){
		case 1: //Dias
			$SELEC = 'SELECT COUNT(`idsOperacion`) AS NOP, DAYOFWEEK(  `fecAltaOperacion` ) AS DIA ';
			$INER  = '';
			$GROUP = ' GROUP BY DIA ';
			$d =  "<table class='tablesorter2' border='0'  cellpadding='0' cellspacing='1'><thead><tr><th>DIA</th><th>N.- OP</th></tr></thead><tbody>";
			$por = "Días";
		break;

		case 2: //Producto
			$SELEC = 'SELECT COUNT( MOPS.`idProducto` ) AS IDPRO, PROD.`descProducto` ';
			$INER  = ' LEFT JOIN  `redefectiva`.`dat_producto` AS PROD
						USING (`idProducto`) ';
			$GROUP = ' GROUP BY MOPS.`idProducto` ';
			$d =  "<table class='tablesorter' border='0'  cellpadding='0' cellspacing='1'><thead><tr><th>Producto</th><th>N.- OP</th></tr></thead><tbody>";
			$por = "Productos";
		break;

		case 3: //Emisor
			//$SELEC = 'SELECT COUNT( MOPS.`idEmisor`) AS IDPRO, EMI.`descEmisor` ';
			$SELEC = 'SELECT COUNT( MOPS.`idEmisor`) AS IDPRO, EMI.`abrevNomEmivosr` ';
			$INER  = ' LEFT JOIN  `redefectiva`.`cat_emisor` AS EMI
						USING (`idEmisor`) ';
			$GROUP = ' GROUP BY MOPS.`idEmisor` ';
			$d =  "<table class='tablesorter' border='0'  cellpadding='0' cellspacing='1'><thead><tr><th>Emisor</th><th>N.- OP</th></tr></thead><tbody>";
			$por = "Emisor";
		break;
	}//switch

	$sql ="$SELEC
			FROM  `redefectiva`.`ops_operacion` as MOPS
			$INER
			WHERE `fecAltaOperacion` BETWEEN '$Fechai' AND '$Fechaf' 
			AND  `idEstatusOperacion` =0
			$AND
			$GROUP
			LIMIT 0 , 100;";
			//echo "<pre>"; echo var_dump($sql); echo "</pre>";
	
	$datos = array();
	//var_dump("sql: $sql");
	$sql = $RBD->query($sql);
	
	$datos[0] = array(
		"name"	=> "Descripcion",
		"data"	=> array()
	);

	$datos[1] = array(
		"name"	=> "Operaciones",
		"data"	=> array(),
		"total" => 0
	);

	if($tipoBus == 1){
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
		$arregloValor2 = array(0,0,0,0,0,0,0);


		$arrDias = array();
		$totalOperaciones = 0;
		while($row = mysqli_fetch_assoc($sql)){
			$arrDias[$row["DIA"]] = $row["NOP"];
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
	}else{
		$totalOperaciones = 0;
		while(list($id,$desc) = mysqli_fetch_array($sql)){
			$datos[0]["data"][] = codificarUTF8($desc);
			$datos[1]["data"][] = $id;
			$totalOperaciones += $id;
		}
		$datos[1]["total"] = $totalOperaciones;
	}

	print json_encode($datos, JSON_NUMERIC_CHECK);
?>