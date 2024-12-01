<?php

include("../../config.inc.php");
include("../../session.ajax.inc.php");

if ( estaBloqueadoOpcion(1) || noTienePermisoAsignado(1) ) {
	header("Location: ../../../error.php");
    exit();
}

$idcad		= (isset($_REQUEST['idCadena']))?$_REQUEST['idCadena']: -2;
$status		= (isset($_REQUEST['status']))?$_REQUEST['status']:0;

$actual = (!empty($_REQUEST["iDisplayStart"]))? $_REQUEST["iDisplayStart"] : 0;
$cant = (!empty($_REQUEST["iDisplayLength"]))? $_REQUEST["iDisplayLength"] : 20;

$colsort	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
$strToFind	= (!empty($_REQUEST['sSearch']))? $_REQUEST['sSearch'] : '';

if($idcad >= 0){

global $RBD;


$SQL= "CALL `redefectiva`.`SP_GET_SUBCADENAS`($idcad, $actual, $cant, $colsort, '$ascdesc', '$strToFind')";
$Result = $RBD->query($SQL);
if($RBD->error() == ''){
	$sqlcount = "SELECT FOUND_ROWS()";

	if(mysqli_num_rows($Result) > 0 ){
		$data = array();

		while($row = mysqli_fetch_assoc($Result)){
			$data[] = array($row["idSubCadena"], $row["nombreGrupo"], $row["descGiro"], utf8_encode($row["nombreSubCadena"]), '<a href="#" onclick="GoSubCadena('.$idcad.', '.$row["idSubCadena"].')">Ver</a>');
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
		
		echo json_encode( $output );
	}
	else{
        $output = array(
			"sEcho"					=> intval($_GET['sEcho']),
			"iTotalRecords"			=> 0,
			"iTotalDisplayRecords"	=> 0,
			"aaData"				=> array()
		);
        echo json_encode($output);
		}?>
    
<?php }else{ ?>
    <label>Ocurrio un error: <?php echo $RBD->error(); ?></label>
<?php }?>      
    

<?php }?>