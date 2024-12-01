<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");

$idbanco = (isset($_POST['idbanco'])) ? trim($_POST['idbanco']) : -1;
$clabe = (isset($_POST['clabe'])) ? trim($_POST['clabe']) : '';
$beneficiario = (isset($_POST['beneficiario'])) ? trim($_POST['beneficiario']) : '';
$cuenta = (isset($_POST['cuenta'])) ? trim($_POST['cuenta']) : '';
$descripcion = (isset($_POST['descripcion'])) ? trim($_POST['descripcion']) : '';

//if($idbanco > -1 && $clabe != '' && $beneficiario != ''){
    $beneficiario = utf8_decode($beneficiario);
	$descripcion = utf8_decode($descripcion);
	$oSubcadena = new XMLPreSubCad($RBD,$WBD);
    $oSubcadena->load($_SESSION['idPreSubCadena']);
    $oSubcadena->setID($_SESSION['idPreSubCadena']);
    $oSubcadena->setIdBanco($idbanco);
    $oSubcadena->setNumCuenta($cuenta);
    $oSubcadena->setClabe($clabe);
    $oSubcadena->setBeneficiario($beneficiario);
    $oSubcadena->setDescripcion($descripcion);

    $oSubcadena->setPreRevisadoVersion(false);
    $oSubcadena->setPreRevisadoCargos(false);
    $oSubcadena->setPreRevisadoGenerales(false);
    $oSubcadena->setPreRevisadoDireccion(false);
    $oSubcadena->setPreRevisadoContactos(false);
    $oSubcadena->setPreRevisadoEjecutivos(false);
    $oSubcadena->setPreRevisadoDocumentacion(false);
    $oSubcadena->setPreRevisadoCuenta(false);
    $oSubcadena->setPreRevisadoContrato(false);
    $oSubcadena->setRevisadoCargos(false);
    $oSubcadena->setRevisadoDocumentacion(false);
    $oSubcadena->setRevisadoGenerales(false);
    $oSubcadena->setRevisadoDireccion(false);
    $oSubcadena->setRevisadoContactos(false);
    $oSubcadena->setRevisadoEjecutivos(false);
    $oSubcadena->setRevisadoCuenta(false);
    $oSubcadena->setRevisadoVersion(false);
    $oSubcadena->setRevisadoContrato(false);
    $oSubcadena->setRevisadoForelo(false);
    if($oSubcadena->GuardarCuentaBanco()){
		if ( $oSubcadena->GuardarXML() ) {
        	echo utf8_encode("0|Se guardó la cuenta de banco");
		} else {
			echo "1|No se pudo guardar la cuenta de banco";
		}
    } else {
        echo "1|No se pudo guardar la cuenta de banco";
	}    
//}




?>