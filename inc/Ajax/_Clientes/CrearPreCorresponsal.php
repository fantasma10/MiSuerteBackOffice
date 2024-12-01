<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

include("../../obj/XMLPreCorresponsal.php");
$_SESSION['idPreCorresponsal'] = "";
$_SESSION['nombrePreCorresponsal'] = "";
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';

if ( $nombre != '' ) {
    $oCorresponal = new XMLPreCorresponsal($RBD,$WBD);
    $oCorresponal->setNombre(utf8_decode($nombre));
    if ( $oCorresponal->CrearXML() ) {
        $_SESSION['idPreCorresponsal'] = $oCorresponal->getId();
        $_SESSION['nombrePreCorresponsal'] = $nombre;
        echo utf8_encode("0|Se creó el Corresponsal ".$nombre);
    } else {
        echo "1|No se pudo crear el Corresponsal -".$oCorresponal->CrearXML();
	}
    
} else {
	echo utf8_encode("2|No se encontró nombre");
}
	
?>
