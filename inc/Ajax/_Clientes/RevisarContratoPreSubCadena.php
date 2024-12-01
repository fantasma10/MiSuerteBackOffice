<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");

$contrato = (isset($_POST['contrato'])) ? $_POST['contrato'] : '';

$oSubCadena = new XMLPreSubCad($RBD,$WBD);
$oSubCadena->load($_SESSION['idPreSubCadena']);

if($contrato == "1")
    $oSubCadena->setRevisadoContrato(true);
else
    $oSubCadena->setRevisadoContrato(false);

if($oSubCadena->GuardarXML())
    echo "0|Se reviso la seccion";
else
    echo "1|No se pudo revisar las seccion";
    
?>