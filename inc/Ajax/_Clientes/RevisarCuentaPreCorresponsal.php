<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$cuenta = (isset($_POST['cuenta'])) ? trim($_POST['cuenta']) : '';
$forelo = (isset($_POST['forelo'])) ? trim($_POST['forelo']) : '';
$descripcion = (isset($_POST['descripcion'])) ? trim($_POST['descripcion']) : '';
$referencia = (isset($_POST['referencia'])) ? trim($_POST['referencia']) : '';


$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
$oCorresponsal->load($_SESSION['idPreCorresponsal']);

if($cuenta == "1"){
    $oCorresponsal->setRevisadoCuenta(true);
    $oCorresponsal->setRevisadoForelo(true);
}
else{
    $oCorresponsal->setRevisadoCuenta(false);
    $oCorresponsal->setRevisadoForelo(false);
}
if($forelo != '')
    $oCorresponsal->setFCantidad($forelo);
if($descripcion != '')
    $oCorresponsal->setFDescripcion($descripcion);  
if($referencia != '')
    $oCorresponsal->setFReferencia($referencia);    
    
if($oCorresponsal->GuardarXML())
    echo "0|Se reviso la seccion";
else
    echo "1|No se pudo revisar las seccion";
    
?>