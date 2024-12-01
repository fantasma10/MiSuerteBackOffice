<?php
	ini_set('display_errors', 0);
	$dir = explode("/", trim($_SERVER['PHP_SELF'], "/"));
	$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT']."\\".$dir[0];
		
	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");
		
	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST']."/".$dir[0];
		
	$idC = (isset($_POST['idCorresponsal']))?$_POST['idCorresponsal']: -2;
	$idEquipo = (isset($_POST['idEquipo']))?$_POST['idEquipo']: -2;
	$idUsuario = $_SESSION['idUsuario'];
	
	$idOpcion = 96;
	$tipoDePagina = "Mixto";
	$esEscritura = false;

	if ( esLecturayEscrituraOpcion($idOpcion) ) {
		$esEscritura = true;
	}
	
	global $WBD;
	global $RBD;
	
	$start	= (!empty($_GET["iDisplayStart"]))? $_GET["iDisplayStart"] : 0;
	$cant	= (!empty($_GET["iDisplayLength"]))? $_GET["iDisplayLength"] : 20;

	$colsort	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$strToFind	= (!empty($_REQUEST['sSearch']))? $_REQUEST['sSearch'] : '';	
		
	if ($idC != -1){	
		$res = $WBD->query("CALL `nautilus`.`SP_EQUIPO_ACTIVAR`($idEquipo, $idC)");			
		if($WBD->error() == ''){
			$output = array(
				'codigo' => 0,
				'mensaje' => 'Activacion exitosa.'
			);
			echo json_encode($output);		
		} else {
			$output = array(
				'codigo' => 1000,
				'mensaje' => 'Activacion no exitosa.'
			);
			echo json_encode($output);
		}
	}
?>