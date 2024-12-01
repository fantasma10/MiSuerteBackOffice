<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");
$_SESSION['idPreSubCadena'] = "";
$_SESSION['nombrePreSubCadena'] = "";
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';

if ( $nombre != '' ) {
    $oSubcadena = new XMLPreSubCad($RBD,$WBD);
    $nombre = utf8_decode($nombre);
    $oSubcadena->setNombre($nombre);
    if ( $oSubcadena->CrearXML() ) {
        $_SESSION['idPreSubCadena'] = $oSubcadena->getId();
        $_SESSION['nombrePreSubCadena'] = $nombre;
        echo utf8_encode("0|Se creó la SubCadena");
    } else {
        echo "1|No se pudo crear la subcadena";
	}
    
}
?>