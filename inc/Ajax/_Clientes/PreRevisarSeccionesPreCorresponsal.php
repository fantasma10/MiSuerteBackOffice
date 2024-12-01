<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$cargos = (isset($_POST['cargos'])) ? $_POST['cargos'] : '';
$generales = (isset($_POST['generales'])) ? $_POST['generales'] : '';
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : '';
$horario = (isset($_POST['horario'])) ? $_POST['horario'] : '';
$contactos = (isset($_POST['contactos'])) ? $_POST['contactos'] : '';
$contrato = (isset($_POST['contrato'])) ? $_POST['contrato'] : '';
$version = (isset($_POST['version'])) ? $_POST['version'] : '';
$cuenta = (isset($_POST['cuenta'])) ? $_POST['cuenta'] : '';
$documentacion = (isset($_POST['documentacion'])) ? $_POST['documentacion'] : '';
$bancos = (isset($_POST['bancos'])) ? $_POST['bancos'] : 1;

$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
$oCorresponsal->load($_SESSION['idPreCorresponsal']);

if($cargos == "1"){
	$oCorresponsal->setPreRevisadoCargos(true);
}else{
    $oCorresponsal->setPreRevisadoCargos(false);
}

if($bancos == "1"){
	$oCorresponsal->setPreRevisadoBancos(true);
}else{
    $oCorresponsal->setPreRevisadoBancos(false);
}

if($generales == "1")
    $oCorresponsal->setPreRevisadoGenerales(true);
else
    $oCorresponsal->setPreRevisadoGenerales(false);
	
if($direccion == "1")
    $oCorresponsal->setPreRevisadoDireccion(true);
else
    $oCorresponsal->setPreRevisadoDireccion(false);
	
if($contactos == "1")
    $oCorresponsal->setPreRevisadoContactos(true);
else
    $oCorresponsal->setPreRevisadoContactos(false);	

if($version == "1")
    $oCorresponsal->setPreRevisadoVersion(true);
else
    $oCorresponsal->setPreRevisadoVersion(false);

if($cuenta == "1")
    $oCorresponsal->setPreRevisadoCuenta(true);
else
    $oCorresponsal->setPreRevisadoCuenta(false);
	
if($documentacion == "1"){
    $oCorresponsal->setPreRevisadoDocumentacion(true);
}else{
    $oCorresponsal->setPreRevisadoDocumentacion(false);
}

if($oCorresponsal->GuardarXML())
    echo "0|Se pre-revisaron las secciones";
else
    echo "1|No se pudieron pre-revisar las secciones";
    
?>