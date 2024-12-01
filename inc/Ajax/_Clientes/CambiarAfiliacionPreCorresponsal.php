<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$afiliacion = (isset($_POST['afiliacion'])) ? trim($_POST['afiliacion']) : '';
$tipo = (isset($_POST['tipo'])) ? trim($_POST['tipo']) : '';

if($afiliacion != ''){
    $oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
    $oCorresponsal->load($_SESSION['idPreCorresponsal']);
    $oCorresponsal->setAfiliacion($afiliacion);
    $oCorresponsal->setTipoAfiliacion($tipo);
    if($oCorresponsal->GuardarXML()){
        echo "0|Se actualizo la informacion";
    }else{
        echo "1|No se pudo actualizar la informacion";
    }
}
?>