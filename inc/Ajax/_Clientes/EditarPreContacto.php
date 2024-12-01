<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCadena.php");

$id = (isset($_POST['id'])) ? trim($_POST['id']) : -1;
$nombre = (isset($_POST['nombre'])) ? trim($_POST['nombre']) : '';
$paterno = (isset($_POST['paterno'])) ? trim($_POST['paterno']) : '';
$materno = (isset($_POST['materno'])) ? trim($_POST['materno']) : '';
$telefono = (isset($_POST['telefono'])) ? trim($_POST['telefono']) : '';
$exttel = (isset($_POST['ext'])) ? trim($_POST['ext']) : '';
$correo = (isset($_POST['correo'])) ? trim($_POST['correo']) : '';
$tipocontacto = (isset($_POST['tipocontacto'])) ? trim($_POST['tipocontacto']) : -1;


if($id > -1){
    $oCadena = new XMLPreCadena($RBD,$WBD);
    $oCadena->load($_SESSION['idPreCadena']);
    $oCadena->setContacto(new Contacto($RBD,$WBD));
    $oCadena->CONTACTO->load($id);
	$nombre = utf8_decode($nombre);
	$paterno = utf8_decode($paterno);
	$materno = utf8_decode($materno);	
    $oCadena->CONTACTO->setNombre($nombre);
    $oCadena->CONTACTO->setPaterno($paterno);
    $oCadena->CONTACTO->setMaterno($materno);
    $oCadena->CONTACTO->setTelefono($telefono);
    $oCadena->CONTACTO->setExtTel($exttel);
    $oCadena->CONTACTO->setCorreo($correo);
    $oCadena->CONTACTO->setTipoContacto($tipocontacto);

    $oCadena->setPreRevisadoCargos(false);
    $oCadena->setPreRevisadoGenerales(false);
    $oCadena->setPreRevisadoDireccion(false);
    $oCadena->setPreRevisadoContactos(false);
    $oCadena->setPreRevisadoEjecutivos(false);
    $oCadena->setRevisadoCargos(false);
    $oCadena->setRevisadoGenerales(false);
    $oCadena->setRevisadoDireccion(false);
    $oCadena->setRevisadoContactos(false);
    $oCadena->setRevisadoEjecutivos(false);

    if($oCadena->ActualizarContacto($id)){
        $oCadena->CalcularPorcentaje();
        echo utf8_encode("0|Se actualizó la información del contacto");
    }else{
        echo utf8_encode("1|No se pudo actualizar la información del contacto ".$oCadena->getMsg());
    }
}

?>