<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");

$ejecutivos = (isset($_POST['ejecutivos'])) ? $_POST['ejecutivos'] : '';
$idecuenta = (isset($_POST['idecuenta'])) ? $_POST['idecuenta'] : -1;
$ideventa = (isset($_POST['ideventa'])) ? $_POST['ideventa'] : -1;

$oSubCadena = new XMLPreSubCad($RBD,$WBD);
$oSubCadena->load($_SESSION['idPreSubCadena']);

if($ejecutivos == "1")
    $oSubCadena->setRevisadoEjecutivos(true);
else
    $oSubCadena->setRevisadoEjecutivos(false);

if($idecuenta > -1){
    $oSubCadena->setIdECuenta($idecuenta);
}
if($ideventa > -1){
    $oSubCadena->setIdEVenta($ideventa);
}    
    
if($oSubCadena->GuardarXML())
    echo "0|Se guardaron los cambios";
else
    echo "1|No se pudieron guardar los cambios";
    
?>
