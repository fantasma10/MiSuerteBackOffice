<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
//include("../../obj/XMLPreSubCadena.php");

$id = (isset($_POST['id'])) ? $_POST['id'] : -1;
if($id > -1){
    $sql = "CALL `prealta`.`SP_UPDATE_PRECORRESPONSALESTATUS`(3, $id);";
    $WBD->query($sql);
    if($WBD->error() == ''){
        echo "0|Se dio de baja el corresponsal";
    }else{
        echo "1|No se pudo dar de baja el corresponsal";
    }
}

?>