<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");

$cadenaID = (isset($_POST['cadenaID'])) ? $_POST['cadenaID'] : '';
$subcadenaID = (isset($_POST['subcadenaID'])) ? $_POST['subcadenaID'] : '';
$precargoID = (isset($_POST['idPreCargo'])) ? $_POST['idPreCargo'] : '';

$oPreCargo = new PreCargo($LOG, $WBD, $RBD, $precargoID, 0, $cadenaID, $subcadenaID, 0, $importe, $fechaInicio, $observaciones, "", 1, "", 0, $configuracion, $_SESSION['idU']);
$preCargo = $oPreCargo->deleteCargo();

if ( !$preCargo["error"] ) {
	echo utf8_encode("0|Se eliminó el PreCargo");
} else {
	echo utf8_encode("1|No se pudo eliminar el PreCargo");
}

?>
