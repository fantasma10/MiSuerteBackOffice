<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$idecuenta = (isset($_POST['idecuenta'])) ? $_POST['idecuenta'] : -1;
$ideventa = (isset($_POST['ideventa'])) ? $_POST['ideventa'] : -1;

if($idecuenta > -1 || $ideventa > -1){
    
    $oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
    $oCorresponsal->load($_SESSION['idPreCorresponsal']);
    
    if($idecuenta > -1){
        $oCorresponsal->setIdECuenta($idecuenta);
    }
    if($ideventa > -1){
        $oCorresponsal->setIdEVenta($ideventa);
    }
    
    if($oCorresponsal->GuardarXML()){
        echo "0|Se actualizo la informacion"; 
    }else{
        echo "1|No se pudo actualizar la informacion";
    }
}
?>