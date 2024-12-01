<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCadena.php");

$cargos = (isset($_POST['cargos'])) ? $_POST['cargos'] : '';
$generales = (isset($_POST['generales'])) ? $_POST['generales'] : '';
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : '';
$contactos = (isset($_POST['contactos'])) ? $_POST['contactos'] : '';
$ejecutivos = (isset($_POST['ejecutivos'])) ? $_POST['ejecutivos'] : '';

$oCadena = new XMLPreCadena($RBD,$WBD);
$oCadena->load($_SESSION['idPreCadena']);

if($cargos == "1")
    $oCadena->setPreRevisadoCargos(true);
else
    $oCadena->setPreRevisadoCargos(false);

if($generales == "1")
    $oCadena->setPreRevisadoGenerales(true);
else
    $oCadena->setPreRevisadoGenerales(false);
	
if($direccion == "1")
    $oCadena->setPreRevisadoDireccion(true);
else
    $oCadena->setPreRevisadoDireccion(false);
	
if($contactos == "1")
    $oCadena->setPreRevisadoContactos(true);
else
    $oCadena->setPreRevisadoContactos(false);
	
if($ejecutivos == "1")
    $oCadena->setPreRevisadoEjecutivos(true);
else
    $oCadena->setPreRevisadoEjecutivos(false);

if($oCadena->GuardarXML())
    echo "0|Se pre-revisaron las secciones";
else
    echo "1|No se pudieron pre-revisar las secciones";
    
?>