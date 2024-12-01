<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$id = (isset($_POST['id'])) ? trim($_POST['id']) : -1;
$nombre = (isset($_POST['nombre'])) ? trim($_POST['nombre']) : '';
$paterno = (isset($_POST['paterno'])) ? trim($_POST['paterno']) : '';
$materno = (isset($_POST['materno'])) ? trim($_POST['materno']) : '';
$telefono = (isset($_POST['telefono'])) ? trim($_POST['telefono']) : '';
$exttel = (isset($_POST['ext'])) ? trim($_POST['ext']) : '';
$correo = (isset($_POST['correo'])) ? trim($_POST['correo']) : '';
$tipocontacto = (isset($_POST['tipocontacto'])) ? trim($_POST['tipocontacto']) : -1;


if($id > -1){
    $oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
    $oCorresponsal->load($_SESSION['idPreCorresponsal']);
    $oCorresponsal->setContacto(new Contacto($RBD,$WBD));
    //$oContacto = new Contacto($RBD,$WBD);
    $oCorresponsal->CONTACTO->load($id);
    $oCorresponsal->CONTACTO->setNombre($nombre);
    $oCorresponsal->CONTACTO->setPaterno($paterno);
    $oCorresponsal->CONTACTO->setMaterno($materno);
    $oCorresponsal->CONTACTO->setTelefono($telefono);
    $oCorresponsal->CONTACTO->setExtTel($exttel);
    $oCorresponsal->CONTACTO->setCorreo($correo);
    $oCorresponsal->CONTACTO->setTipoContacto($tipocontacto);

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

    if($oCorresponsal->ActualizarContacto($id)){
        $oCorresponsal->CalcularPorcentaje();
        echo "0|Se actualizo al informacion del contacto".$oCorresponsal->getError();
    }else{
        echo "1|No se pudo actualizar la informacion del contacto ".$oCorresponsal->getMsg();
    }
}

?>