<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$contrato = (isset($_POST['contrato'])) ? $_POST['contrato'] : '';

$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
$oCorresponsal->load($_SESSION['idPreCorresponsal']);

if($contrato == "1")
    $oCorresponsal->setRevisadoContrato(true);
else
    $oCorresponsal->setRevisadoContrato(false);

if($oCorresponsal->GuardarXML())
    echo "0|Se reviso la seccion";
else
    echo "1|No se pudo revisar las seccion";
    
?>