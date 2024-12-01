<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCadena.php");

$tipoConcepto = (isset($_POST['tipoConcepto'])) ? $_POST['tipoConcepto'] : '';
$importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';
$fechaInicio = (isset($_POST['fechaInicio'])) ? $_POST['fechaInicio'] : '';
$observaciones = (isset($_POST['observaciones'])) ? trim($_POST['observaciones']) : '';
$configuracion = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$cadenaID = (isset($_POST['cadenaID'])) ? $_POST['cadenaID'] : '';

$observaciones = utf8_decode($observaciones);

if ( isset($fechaInicio) && $fechaInicio != '' ) {
	$fechaInicio = date("Y-m-d", strtotime($fechaInicio));
}

$oPreCargo = new PreCargo($LOG, $WBD, $RBD, NULL, $tipoConcepto, $cadenaID, -1, -1, $importe, $fechaInicio, $observaciones, "", 0, "", 0, $configuracion, $_SESSION['idU']);
$preCargo = $oPreCargo->crearCargo();

$oCadena = new XMLPreCadena($RBD,$WBD);
$oCadena->load($_SESSION['idPreCadena']);

if ( !$preCargo["error"] ) {
	echo "0|Cargo creado";
} else {
	echo "1|".$preCargo["msg"];
}    
?>