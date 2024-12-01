<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
//include("../../obj/XMLPreSubCadena.php");

$id = (isset($_POST['id'])) ? $_POST['id'] : -1;
if($id > -1){
    $sql = "CALL `prealta`.`SP_UPDATE_PRESUBCADENAESTATUS`(3, $id);";
	$WBD->SP($sql);
    if($WBD->error() == ''){
        echo utf8_encode("0|Se dió de baja la Sub Cadena");
    }else{
        echo utf8_encode("1|No se pudo dar de baja la Sub Cadena");
    }
}

?>