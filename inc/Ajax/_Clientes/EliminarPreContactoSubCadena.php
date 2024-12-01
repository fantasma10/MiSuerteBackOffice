<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");


$id = (isset($_POST['id'])) ? $_POST['id'] : '';

if($id > -1){
    $oSubcadena = new XMLPreSubCad($RBD,$WBD);
    $oSubcadena->load($_SESSION['idPreSubCadena']);
    $oSubcadena->setID($_SESSION['idPreSubCadena']);
    $oSubcadena->setPreRevisadoVersion(false);
    $oSubcadena->setPreRevisadoCargos(false);
    $oSubcadena->setPreRevisadoGenerales(false);
    $oSubcadena->setPreRevisadoDireccion(false);
    $oSubcadena->setPreRevisadoContactos(false);
    $oSubcadena->setPreRevisadoEjecutivos(false);
    $oSubcadena->setPreRevisadoDocumentacion(false);
    $oSubcadena->setPreRevisadoCuenta(false);
    $oSubcadena->setPreRevisadoContrato(false);
    $oSubcadena->setRevisadoCargos(false);
    $oSubcadena->setRevisadoDocumentacion(false);
    $oSubcadena->setRevisadoGenerales(false);
    $oSubcadena->setRevisadoDireccion(false);
    $oSubcadena->setRevisadoContactos(false);
    $oSubcadena->setRevisadoEjecutivos(false);
    $oSubcadena->setRevisadoCuenta(false);
    $oSubcadena->setRevisadoVersion(false);
    $oSubcadena->setRevisadoContrato(false);
    $oSubcadena->setRevisadoForelo(false);

    if($oSubcadena->EliminarContacto($id)){
        echo utf8_encode("0|Se eliminó el contacto");
    }else{
        echo "1|No se pudo eliminar el contacto";
    }
}

?>