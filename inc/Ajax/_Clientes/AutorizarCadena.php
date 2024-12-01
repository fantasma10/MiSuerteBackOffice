<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCadena.php");

$id = isset($_POST['id']) ? $_POST['id'] : -1;

if($id > -1){
    $oCadena = new XMLPreCadena($RBD,$WBD);
    $oCadena->load($id);
    if($oCadena->Autorizar()){
        echo utf8_encode("0|Se creó la cadena".$oCadena->getError());
    }
    else{
        echo "1|".$oCadena->getError();
    }
}
?>