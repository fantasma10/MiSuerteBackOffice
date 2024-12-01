<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$idcorresponsalbanco = (isset($_POST['idCorresponsalBanco'])) ? $_POST['idCorresponsalBanco'] : -1;

if($idcorresponsalbanco >-1){
    //$sql = "UPDATE `redefectiva`.`inf_corresponsalbanco` SET `idEstatus` = 3 WHERE `idCorresponsalBanco` = $idcorresponsalbanco;";
    $sql = "CALL `redefectiva`.`SP_ELIMINA_CORRESPONSALIA`($idcorresponsalbanco)";
    $WBD->query($sql);
    if($WBD->error() == ''){
        echo "0|Se elimino la corresponsalia bancaria";
    }else{
        echo "1|Error al agregar la corresponsal&iacute;a bancaria";
    }
    
}
?>