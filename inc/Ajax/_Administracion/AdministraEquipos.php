<?php
	
	
	ini_set('display_errors', 0);
	$dir = explode("/", trim($_SERVER['PHP_SELF'], "/"));
	$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT']."\\".$dir[0];
	
	
	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");
	
	
	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST']."/".$dir[0];
	
	$idAccionAEjecutar = (isset($_GET['idAccionAEjecutar']))?$_GET['idAccionAEjecutar']: -1;
	$idC = (isset($_GET['idCorresponsal']))?$_GET['idCorresponsal']: -2;
	$idUsuario = $_SESSION['idUsuario'];
	
	$idOpcion = 96; //Agregar esta linea a la nueva pagina tal y como esta aqui
	$tipoDePagina = "Mixto"; //Agregar esta linea a la nueva pagina tal y como esta aqui
	$esEscritura = false; //Agregar esta linea a la nueva pagina tal y como esta aqui

	if ( esLecturayEscrituraOpcion($idOpcion) ) { //Agregar esta linea a la nueva pagina tal y como esta aqui
		$esEscritura = true; //Agregar esta linea a la nueva pagina tal y como esta aqui
	} //Agr
	
	global $WBD;
	global $RBD;
	
	$start	= (!empty($_GET["iDisplayStart"]))? $_GET["iDisplayStart"] : 0;
	$cant	= (!empty($_GET["iDisplayLength"]))? $_GET["iDisplayLength"] : 20;

	$colsort	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$strToFind	= (!empty($_REQUEST['sSearch']))? $_REQUEST['sSearch'] : '';
	
	/*$strToFind = $RBD->real_escape_string($strToFind);
	$strToFind = utf8_decode($strToFind);*/
		
	
	if($idAccionAEjecutar == 1){
		
		if ($idC != -1){
		
			
			$res =  $RBD->query("CALL `nautilus`.`SP_CARGA_EQUIPOS`($idC)");
			
				if($RBD->error() == ''){
									$i = 1;
									
									$html = "";
									
									
									
									
									while($row = mysqli_fetch_assoc($res)){
										
										$idEquipo = $row['idEquipo'];
										$idEquipoCorresponsal = $row['idEquipoCorresponsal'];
										
										if ( ($row['idStatus'] == 1 || $row['idEquipoStatus'] == 1) && $esEscritura){
											$html = "<button type='button' onclick='cambiaEstatus($idEquipo, $idEquipoCorresponsal);'>Activar</button>";
										}else{
											$html = "";
										}
										
										$estatus = "";
										if ($row['idStatus'] == 0){
											$estatus = "Activo";
										}else{
											$estatus = "Inactivo";
										}
										
										$equipoStatus = "";
										switch($row['idEquipoStatus']){
											case 0: $equipoStatus = "Activo"; break;
											case 1: $equipoStatus = "Inactivo"; break;
											case 2: $equipoStatus = "Suspendido"; break;
											case 3: $equipoStatus = "Baja"; break;
											case 4: $equipoStatus = "Bloqueado"; break;
										}
										
										$data[] = array(
										
											$i,
											$row['idEquipo'],
											$row['equipoName'],
											$row['codActivacion'],
											$equipoStatus,
											$estatus,
											$row['fechaAccesoUlt'],
											$html
										);
										$i++;
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
									
								} else {
									$output = array(
									"sEcho"					=> intval($_GET['sEcho']),
									"iTotalRecords"			=> 0,
									"iTotalDisplayRecords"	=> 0,
									"aaData"				=> array($RBD->error())
									);
									echo json_encode($output);
								
								}
								
			}
		}
					
	


?>