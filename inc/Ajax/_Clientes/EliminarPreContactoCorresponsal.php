<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

error_reporting(E_ALL);
ini_set("display_errors", 1);

$id = (isset($_POST['id'])) ? $_POST['id'] : '';

if($id > -1){
    $oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
    $oCorresponsal->load($_SESSION['idPreCorresponsal']);
    $oCorresponsal->setID($_SESSION['idPreCorresponsal']);

    $oCorresponsal->setPreRevisadoCargos(false);
    $oCorresponsal->setPreRevisadoBancos(false);
    $oCorresponsal->setPreRevisadoVersion(false);
    $oCorresponsal->setPreRevisadoDocumentacion(false);
    $oCorresponsal->setPreRevisadoGenerales(false);
    $oCorresponsal->setPreRevisadoDireccion(false);
    $oCorresponsal->setPreRevisadoContactos(false);
    $oCorresponsal->setPreRevisadoCuenta(false);
    $oCorresponsal->setRevisadoCargos(false);
    $oCorresponsal->setRevisadoBancos(false);
    $oCorresponsal->setRevisadoVersion(false);
    $oCorresponsal->setRevisadoDocumentacion(false);
    $oCorresponsal->setRevisadoGenerales(false);
    $oCorresponsal->setRevisadoDireccion(false);
    $oCorresponsal->setRevisadoContactos(false);
    $oCorresponsal->setRevisadoEjecutivos(false);
    $oCorresponsal->setRevisadoCuenta(false);
    $oCorresponsal->setRevisadoContrato(false);
    $oCorresponsal->setRevisadoForelo(false);

    if($oCorresponsal->EliminarContacto($id)){
        echo "0|Se elimino el contacto";
    }else{
        echo "1|No se pudo eliminar el contacto";
    }
}

?>