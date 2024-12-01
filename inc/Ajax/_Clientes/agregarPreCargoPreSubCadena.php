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
$subcadenaID = (isset($_POST['subcadenaID'])) ? $_POST['subcadenaID'] : '';

$observaciones = utf8_decode($observaciones);

if ( isset($fechaInicio) && $fechaInicio != '' ) {
	$fechaInicio = date("Y-m-d", strtotime($fechaInicio));
}

$oCargoCadena = new Cargo($LOG, $WBD, $RBD, NULL, $tipoConcepto, $cadenaID, -1, -1, $importe, $fechaInicio, $observaciones, "", 0, "", 0, $configuracion, $_SESSION['idU']);
$debeCrearsePreCargo = false;

if ( $tipoConcepto == 99 ) {
	$afiliacionesCadena = $oCargoCadena->cargarAfiliaciones();
	if ( $afiliacionesCadena['totalAfiliaciones'] == 0 ) {
		$debeCrearsePreCargo = true;
	} else {
		$debeCrearsePreCargo = false;
	}
} else {
	$cuotasCadena = $oCargoCadena->cargarCuotas();
	if ( $cuotasCadena['totalCuotas'] == 0 ) {
		$debeCrearsePreCargo = true;
	} else {
		$debeCrearsePreCargo = false;
	}
}

if ( $debeCrearsePreCargo ) {
	$oPreCargoSubCadena = new PreCargo($LOG, $WBD, $RBD, NULL, $tipoConcepto, $cadenaID, $subcadenaID, -1, $importe, $fechaInicio, $observaciones, "", 0, "", 0, $configuracion, $_SESSION['idU']);
	$preCargoSubCadena = $oPreCargoSubCadena->crearCargo();
	if ( !$preCargoSubCadena["error"] ) {
		echo "0|Cargo creado";
	} else {
		echo "1|".$preCargoSubCadena["msg"];
	}	
} else {
	echo utf8_encode("1|La Cadena ya pagó un cargo de este tipo");
}


?>