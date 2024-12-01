<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$ejecutivos = (isset($_POST['ejecutivos'])) ? $_POST['ejecutivos'] : '';
$idecuenta = (isset($_POST['idecuenta'])) ? $_POST['idecuenta'] : -1;
$ideventa = (isset($_POST['ideventa'])) ? $_POST['ideventa'] : -1;

$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
$oCorresponsal->load($_SESSION['idPreCorresponsal']);

if($ejecutivos == "1")
    $oCorresponsal->setRevisadoEjecutivos(true);
else
    $oCorresponsal->setRevisadoEjecutivos(false);

if($idecuenta > -1){
    $oCorresponsal->setIdECuenta($idecuenta);
}
if($ideventa > -1){
    $oCorresponsal->setIdEVenta($ideventa);
}    
    
if($oCorresponsal->GuardarXML())
    echo "0|Se guardaron los cambios";
else
    echo "1|No se pudieron guardar los cambios";
    
?>