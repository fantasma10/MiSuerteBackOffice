<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");

$id = isset($_POST['id']) ? $_POST['id'] : -1;

if($id > -1){
    $oSubcadena = new XMLPreSubCad($RBD,$WBD);
    $oSubcadena->load($id);
    if($oSubcadena->Autorizar()){
        echo "0|Se creo la subcadena";
    }else{
        echo "1|".$oSubcadena->getError();
    }
}
?>