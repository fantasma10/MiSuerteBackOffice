<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$id = isset($_POST['id']) ? $_POST['id'] : -1;

if($id > -1){
    $oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
    $oCorresponsal->load($id);
    if($oCorresponsal->Autorizar()){
        echo "0|Se creo el corresponsal".$oCorresponsal->getError();
    }else{
        echo "1|".$oCorresponsal->getError();
    }
}
?>