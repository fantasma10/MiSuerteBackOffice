<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCadena.php");

$idecuenta = (isset($_POST['idecuenta'])) ? trim($_POST['idecuenta']) : NULL;
$ideventa = (isset($_POST['ideventa'])) ? trim($_POST['ideventa']) : NULL;

if($idecuenta != NULL || $ideventa != NULL){
    
    $oCadena = new XMLPreCadena($RBD,$WBD);
    $oCadena->load($_SESSION['idPreCadena']);
	
	if ($idecuenta == -500){
		$oCadena->setIdECuenta('');
	} else if($idecuenta != NULL){
        $oCadena->setIdECuenta($idecuenta);
    }
	if ($ideventa == -500){
		$oCadena->setIdEVenta('');
	} else if($ideventa != NULL){
        $oCadena->setIdEVenta($ideventa);
    }
    
    $oCadena->setPreRevisadoCargos(false);
    $oCadena->setPreRevisadoGenerales(false);
    $oCadena->setPreRevisadoDireccion(false);
    $oCadena->setPreRevisadoContactos(false);
    $oCadena->setPreRevisadoEjecutivos(false);
    $oCadena->setRevisadoCargos(false);
    $oCadena->setRevisadoGenerales(false);
    $oCadena->setRevisadoDireccion(false);
    $oCadena->setRevisadoContactos(false);
    $oCadena->setRevisadoEjecutivos(false);

    
    if($oCadena->GuardarXML()){
        $oCadena->CalcularPorcentaje();
        echo utf8_encode("0|Se actualizó la información"); 
    }else{
        echo utf8_encode("1|No se pudo actualizar la información");
    } 
}


?>