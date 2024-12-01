<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");

$cuenta = (isset($_POST['cuenta'])) ? $_POST['cuenta'] : '';
$forelo = (isset($_POST['forelo'])) ? $_POST['forelo'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$referencia = (isset($_POST['referencia'])) ? $_POST['referencia'] : '';


$oSubCadena = new XMLPreSubCad($RBD,$WBD);
$oSubCadena->load($_SESSION['idPreSubCadena']);

if($cuenta == "1"){
    $oSubCadena->setRevisadoCuenta(true);
    $oSubCadena->setRevisadoForelo(true);
}
else{
    $oSubCadena->setRevisadoCuenta(false);
    $oSubCadena->setRevisadoForelo(false);
}
if($forelo != '')
    $oSubCadena->setFCantidad($forelo);
if($descripcion != '')
    $oSubCadena->setFDescripcion($descripcion);  
if($referencia != '')
    $oSubCadena->setFReferencia($referencia);    
    
if($oSubCadena->GuardarXML())
    echo "0|Se reviso la seccion";
else
    echo "1|No se pudo revisar las seccion";
    
?>