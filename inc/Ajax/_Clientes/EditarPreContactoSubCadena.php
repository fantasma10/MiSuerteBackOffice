<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");

$id = (isset($_POST['id']))? trim($_POST['id']) : -1;
$nombre = (isset($_POST['nombre']))? trim($_POST['nombre']) : '';
$paterno = (isset($_POST['paterno']))? trim($_POST['paterno']) : '';
$materno = (isset($_POST['materno']))? trim($_POST['materno']) : '';
$telefono = (isset($_POST['telefono']))? trim($_POST['telefono']) : '';
$exttel = (isset($_POST['ext']))? trim($_POST['ext']) : '';
$correo = (isset($_POST['correo']))? trim($_POST['correo']) : '';
$tipocontacto = (isset($_POST['tipocontacto']))? trim($_POST['tipocontacto']) : -1;

if($id > -1){
    $oSubcadena = new XMLPreSubCad($RBD,$WBD);
    $oSubcadena->load($_SESSION['idPreSubCadena']);
    $oSubcadena->setContacto(new Contacto($RBD,$WBD));
	$nombre = utf8_decode($nombre);
	$paterno = utf8_decode($paterno);
	$materno = utf8_decode($materno);
    $oSubcadena->CONTACTO->load($id);
    $oSubcadena->CONTACTO->setNombre($nombre);
    $oSubcadena->CONTACTO->setPaterno($paterno);
    $oSubcadena->CONTACTO->setMaterno($materno);
    $oSubcadena->CONTACTO->setTelefono($telefono);
    $oSubcadena->CONTACTO->setExtTel($exttel);
    $oSubcadena->CONTACTO->setCorreo($correo);
    $oSubcadena->CONTACTO->setTipoContacto($tipocontacto);

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

    if($oSubcadena->ActualizarContacto($id)){
        $oSubcadena->CalcularPorcentaje();
        echo utf8_encode("0|Se actualizó la información del contacto".$oSubcadena->getError());
    }else{
        echo utf8_encode("1|No se pudo actualizar la información del contacto ".$oSubcadena->getMsg());
    }
}

?>