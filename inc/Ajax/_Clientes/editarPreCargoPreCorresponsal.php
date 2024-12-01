<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$tipoConcepto = (isset($_POST['tipoConcepto'])) ? $_POST['tipoConcepto'] : '';
$importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';
$fechaInicio = (isset($_POST['fechaInicio'])) ? $_POST['fechaInicio'] : '';
$observaciones = (isset($_POST['observaciones'])) ? trim($_POST['observaciones']) : '';
$configuracion = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$cadenaID = (isset($_POST['cadenaID'])) ? $_POST['cadenaID'] : '';
$subcadenaID = (isset($_POST['subcadenaID'])) ? $_POST['subcadenaID'] : '';
$corresponsalID = (isset($_POST['corresponsalID'])) ? $_POST['corresponsalID'] : '';
$idPreCargo = (isset($_POST['idPreCargo'])) ? $_POST['idPreCargo'] : '';

$observaciones = utf8_decode($observaciones);

if ( isset($fechaInicio) && $fechaInicio != '' ) {
	$fechaInicio = date("Y-m-d", strtotime($fechaInicio));
}

$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
$oCorresponsal->load($corresponsalID);

$oCargoCadena = new Cargo($LOG, $WBD, $RBD, NULL, -1, $cadenaID, -1, -1, $importe, $fechaInicio, $observaciones, "", 0, "", 0, $configuracion, $_SESSION['idU']);
$tipoSubCadena = $oCorresponsal->getTipoSubCadena();
$afiliacionesCadena = $oCargoCadena->cargarAfiliaciones();
$cuotasCadena = $oCargoCadena->cargarCuotas();
$debeCrearsePreAfiliacion = false;
$debeCrearsePreCuota = false;
/**
* Si esta variable vale 0 quiere decir que la Cadena ya pago Afiliacion
* Si esta variable vale 1 quiere decir que la Sub Cadena ya pago Afiliacion
**/
$quienHaPagadoAfiliacion = -500;
/**
* Si esta variable vale 0 quiere decir que la Cadena ya pago Cuota
* Si esta variable vale 1 quiere decir que la Sub Cadena ya pago Cuota
**/
$quienHaPagadoCuota = -500;										

if ( $afiliacionesCadena['totalAfiliaciones'] == 0 ) {
	if ( $tipoSubCadena == 0 ) { //SubCadena Real
		$oCargoSubCadena = new Cargo($LOG, $WBD, $RBD, NULL, -1, $cadenaID, $subcadenaID, -1, $importe, $fechaInicio, $observaciones, "", 0, "", 0, $configuracion, $_SESSION['idU']);													
	} else if ( $tipoSubCadena == 1 ) { //SubCadena PRE
		$oCargoSubCadena = new PreCargo($LOG, $WBD, $RBD, NULL, NULL, $cadenaID, $subcadenaID, -1, 0, NULL, "", "", 0, "", 0, 0, $_SESSION['idU']);										
	}
	$afiliacionesSubCadena = $oCargoSubCadena->cargarAfiliaciones();
	if ( $afiliacionesSubCadena['totalAfiliaciones'] == 0 ) {
		$debeCrearsePreAfiliacion = true;
	} else {
		$debeCrearsePreAfiliacion = false;
		$quienHaPagadoAfiliacion = 1;
	}								
} else {
	$debeCrearsePreAfiliacion = false;
	$quienHaPagadoAfiliacion = 0;
}

if ( $cuotasCadena['totalCuotas'] == 0 ) {
	if ( $tipoSubCadena == 0 ) { //SubCadena Real
		$oCargoSubCadena = new Cargo($LOG, $WBD, $RBD, NULL, -1, $cadenaID, $subcadenaID, -1, $importe, $fechaInicio, $observaciones, "", 0, "", 0, $configuracion, $_SESSION['idU']);													
	} else if ( $tipoSubCadena == 1 ) { //SubCadena PRE
		$oCargoSubCadena = new PreCargo($LOG, $WBD, $RBD, NULL, NULL, $cadenaID, $subcadenaID, -1, 0, NULL, "", "", 0, "", 0, 0, $_SESSION['idU']);										
	}
	$cuotasSubCadena = $oCargoSubCadena->cargarCuotas();
	if ( $cuotasSubCadena['totalCuotas'] == 0 ) {
		$debeCrearsePreCuota = true;
	} else {
		$debeCrearsePreCuota = false;
		$quienHaPagadoCuota = 1;
	}																
} else {
	$debeCrearsePreCuota = false;
	$quienHaPagadoCuota = 0;
}

/*if ( !$debeCrearsePreAfiliacion || !$debeCrearsePreCuota ) {
	$oCargoCadena = new Cargo($LOG, $WBD, $RBD, NULL, $tipoConcepto, $cadenaID, $subcadenaID, $corresponsalID, $importe, $fechaInicio, $observaciones, "", 0, "", 0, $configuracion, $_SESSION['idU']);
	$debeCrearsePreCargo = false;
	
	if ( $tipoConcepto == 999 ) {
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
}*/

/*
if ( $debeCrearsePreCargo ) {
	$oPreCargoSubCadena = new PreCargo($LOG, $WBD, $RBD, NULL, $tipoConcepto, $cadenaID, $subcadenaID, $corresponsalID, $importe, $fechaInicio, $observaciones, "", 0, "", 0, $configuracion, $_SESSION['idU']);
	$preCargoSubCadena = $oPreCargoSubCadena->crearCargo();
	if ( !$preCargoSubCadena["error"] ) {
		echo "0|Cargo creado";
	} else {
		echo "1|".$preCargoSubCadena["msg"];
	}	
} else {
	echo utf8_encode("1|La Cadena ya pagó un cargo de este tipo");
}*/

if ( $debeCrearsePreAfiliacion || $debeCrearsePreCuota ) {
	$oPreCargoSubCadena = new PreCargo($LOG, $WBD, $RBD, $idPreCargo, $tipoConcepto, $cadenaID, $subcadenaID, $corresponsalID, $importe, $fechaInicio, $observaciones, "", 0, "", 0, $configuracion, $_SESSION['idU']);
	$preCargoSubCadena = $oPreCargoSubCadena->actualizarCargo();
	if ( !$preCargoSubCadena["error"] ) {
		echo "0|Cargo creado";
	} else {
		echo "1|".$preCargoSubCadena["msg"];
	}
} else {
	if ( $tipoConcepto == 99 ) {
		if ( !$debeCrearsePreAfiliacion ) {
			if ( $quienHaPagadoAfiliacion == 0 ) {
				echo utf8_encode("1|La Cadena asociada a este Corresponsal ya tiene cargada la Afiliación");
			} else if ( $quienHaPagadoAfiliacion == 1 ) {
				echo utf8_encode("1|La Sub Cadena asociada a este Corresponsal ya tiene cargada la Afiliación");
			}
		}
	} else {
		if ( !$debeCrearsePreCuota ) {
			if ( $quienHaPagadoCuota == 0 ) {
				echo utf8_encode("1|La Cadena asociada a este Corresponsal ya tiene cargada la Cuota");
			} else if ( $quienHaPagadoCuota == 1 ) {
				echo utf8_encode("1|La Sub Cadena asociada a este Corresponsal ya tiene cargada la Cuota");
			}
		}	
	}
	//echo utf8_encode("1|La Cadena ya pagó un cargo de este tipo");
}
?>