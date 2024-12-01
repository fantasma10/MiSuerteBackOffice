<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$ver = (isset($_POST['ver'])) ? trim($_POST['ver']) : '';

if($ver != "" || $ver > -1){
    $oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
    $oCorresponsal->load($_SESSION['idPreCorresponsal']);
    $oCorresponsal->setID($_SESSION['idPreCorresponsal']);
    //$oCorresponsal->setNombre($_SESSION['nombrePreCorresponsal']);
    /*
	$oCorresponsal->setIdCadena($idcadena);
    $oCorresponsal->setIdSubCadena($idsubcadena);
	$oCorresponsal->setTipoSubCadena($idtiposub);
	$oCorresponsal->setNomSubCadena($nomsubcadena);
	*/
    $oCorresponsal->setVersion($ver);
    if($oCorresponsal->GuardarXML())
        echo "0|Se guardo la informacion";
    else
        echo "1|No se pudo guardar la informacion";
    
}


?>