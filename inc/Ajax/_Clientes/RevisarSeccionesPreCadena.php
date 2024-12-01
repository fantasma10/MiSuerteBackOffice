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
    $oCadena->setRevisadoCargos(true);
else
    $oCadena->setRevisadoCargos(false);

if($generales == "1")
    $oCadena->setRevisadoGenerales(true);
else
    $oCadena->setRevisadoGenerales(false);
	
if($direccion == "1")
    $oCadena->setRevisadoDireccion(true);
else
    $oCadena->setRevisadoDireccion(false);
	
if($contactos == "1")
    $oCadena->setRevisadoContactos(true);
else
    $oCadena->setRevisadoContactos(false);
	
if($ejecutivos == "1")
    $oCadena->setRevisadoEjecutivos(true);
else
    $oCadena->setRevisadoEjecutivos(false);

if($oCadena->GuardarXML())
	echo "0|Se validaron las secciones";
else
	echo "1|No se pudieron validar las secciones";	
    
?>