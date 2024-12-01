<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");

$nombre = (isset($_POST['nombre'])) ? trim($_POST['nombre']) : '';
$paterno = (isset($_POST['paterno'])) ? trim($_POST['paterno']) : '';
$materno = (isset($_POST['materno'])) ? trim($_POST['materno']) : '';
$telefono = (isset($_POST['telefono'])) ? trim($_POST['telefono']) : '';
$exttel = (isset($_POST['ext'])) ? trim($_POST['ext']) : '';
$correo = (isset($_POST['correo'])) ? trim($_POST['correo']) : '';
$tipocontacto = (isset($_POST['tipocontacto'])) ? trim($_POST['tipocontacto']) : -1;

if($nombre != '' && $paterno != '' && $materno != '' && $telefono != '' && $correo != '' && $tipocontacto != ''){
	$nombre = utf8_decode($nombre);
	$paterno = utf8_decode($paterno);
	$materno = utf8_decode($materno);	
	$oSubcadena = new XMLPreSubCad($RBD,$WBD);
    $oSubcadena->load($_SESSION['idPreSubCadena']);
    $oSubcadena->setID($_SESSION['idPreSubCadena']);
    $oSubcadena->setContacto(new Contacto($RBD,$WBD));
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

    if($oSubcadena->AgregarContacto()){
        $oSubcadena->CalcularPorcentaje();
        echo utf8_encode("0|Se agregó el contacto");
    }else{
        $msg = "1|No se pudo agregar el contacto porque ".$oSubcadena->getMsg();

        echo (!preg_match('!!u', $msg))? utf8_encode($msg) : $msg;
    }
    
}


?>