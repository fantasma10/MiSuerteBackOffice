<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");

$idecuenta = (isset($_POST['idecuenta'])) ? $_POST['idecuenta'] : -1;
$ideventa = (isset($_POST['ideventa'])) ? $_POST['ideventa'] : -1;

if($idecuenta > -1 || $ideventa > -1){
    
    $oSubCadena = new XMLPreSubCad($RBD,$WBD);
    $oSubCadena->load($_SESSION['idPreSubCadena']);
    
    if($idecuenta > -1){
        $oSubCadena->setIdECuenta($idecuenta);
    }
    if($ideventa > -1){
        $oSubCadena->setIdEVenta($ideventa);
    }
    
    if($oSubCadena->GuardarXML()){
        echo "0|Se actualizo la informacion"; 
    }else{
        echo "1|No se pudo actualizar la informacion";
    }
}
?>