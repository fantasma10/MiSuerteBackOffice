<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCadena.php");

$_SESSION['idPreCadena'] = "";
$_SESSION['nombrePreCadena'] = "";

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';

if($nombre != ''){
    $nombre = utf8_decode($nombre);
	$oCadena = new XMLPreCadena($RBD,$WBD);
    $oCadena->setNombre($nombre);
    if($oCadena->CrearXML()){
        $_SESSION['idPreCadena'] = $oCadena->getId();
        $_SESSION['nombrePreCadena'] = $nombre;
        echo utf8_encode("0|Se creó la cadena");
    }
    else
        echo "1|No se pudo crear la cadena";
}
?>
