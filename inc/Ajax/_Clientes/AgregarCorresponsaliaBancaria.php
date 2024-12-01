<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$idcorresponsal = (!empty($_POST['idCorresponsal'])) ? $_POST['idCorresponsal'] : -1;
$idbanco        = (!empty($_POST['idBanco'])) ? $_POST['idBanco'] : -1;
/*$idactividad    = (isset($_POST['idActividad'])) ? $_POST['idActividad'] : -1;
$iddatgeo       = (isset($_POST['idDatGeo'])) ? $_POST['idDatGeo'] : -1;*/

/*if ( !is_int($iddatgeo) ) {
	$iddatgeo = 0;
}*/

if($idcorresponsal >-1 && $idbanco > -1 ){
    $sql = "CALL `redefectiva`.`SP_INSERT_CORRESPONSALIA`($idcorresponsal, $idbanco)";
    $WBD->query($sql);

    if(!$WBD->error()){
        echo "0|Se agrego la corresponsalia bancaria";
    }
    else{
        echo "1|Error al agregar la corresponsalia bancaria".$WBD->error();
    }
    
}

?>