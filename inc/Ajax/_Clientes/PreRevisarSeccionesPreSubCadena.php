<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");

$cargos = (isset($_POST['cargos'])) ? $_POST['cargos'] : '';
$generales = (isset($_POST['generales'])) ? $_POST['generales'] : '';
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : '';
$contactos = (isset($_POST['contactos'])) ? $_POST['contactos'] : '';
$contrato = (isset($_POST['contrato'])) ? $_POST['contrato'] : '';
$version = (isset($_POST['version'])) ? $_POST['version'] : '';
$cuenta = (isset($_POST['cuenta'])) ? $_POST['cuenta'] : '';
$documentacion = (isset($_POST['documentacion'])) ? $_POST['documentacion'] : '';

$oSubCadena = new XMLPreSubCad($RBD,$WBD);
$oSubCadena->load($_SESSION['idPreSubCadena']);

if($cargos == "1"){
	$oSubCadena->setPreRevisadoCargos(true);
}else{
    $oSubCadena->setPreRevisadoCargos(false);
}

if($generales == "1")
    $oSubCadena->setPreRevisadoGenerales(true);
else
    $oSubCadena->setPreRevisadoGenerales(false);
	
if($direccion == "1")
    $oSubCadena->setPreRevisadoDireccion(true);
else
    $oSubCadena->setPreRevisadoDireccion(false);
	
if($contactos == "1")
    $oSubCadena->setPreRevisadoContactos(true);
else
    $oSubCadena->setPreRevisadoContactos(false);
	
if($contrato == "1")
    $oSubCadena->setPreRevisadoContrato(true);
else
    $oSubCadena->setPreRevisadoContrato(false);	

if($version == "1")
    $oSubCadena->setPreRevisadoVersion(true);
else
    $oSubCadena->setPreRevisadoVersion(false);

if($cuenta == "1")
    $oSubCadena->setPreRevisadoCuenta(true);
else
    $oSubCadena->setPreRevisadoCuenta(false);
	
if($documentacion == "1")
    $oSubCadena->setPreRevisadoDocumentacion(true);
else
    $oSubCadena->setPreRevisadoDocumentacion(false);	

if($oSubCadena->GuardarXML())
    echo "0|Se pre-revisaron las secciones";
else
    echo "1|No se pudieron pre-revisar las secciones";
    
?>