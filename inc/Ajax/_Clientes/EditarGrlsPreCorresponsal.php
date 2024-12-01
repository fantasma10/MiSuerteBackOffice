<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$idcadena		= (isset($_POST['idcadena'])) ? trim($_POST['idcadena']) : -1;
$idsubcadena	= (isset($_POST['idsubcadena'])) ? trim($_POST['idsubcadena']) : -1;
$tiposubcadena  = (isset($_POST['tiposubcadena'])) ? trim($_POST['tiposubcadena']) : -1;
$nomsubcadena	= (isset($_POST['nomsubcadena'])) ? trim($_POST['nomsubcadena']) : -1;

$giro 			= (isset($_POST['idgiro'])) ? trim($_POST['idgiro']) : -1;
$grupo 			= (isset($_POST['idgrupo'])) ? trim($_POST['idgrupo']) : -1;
$referencia 	= (isset($_POST['idref'])) ? trim($_POST['idref']) : -1;
$tel1 			= (isset($_POST['tel1'])) ? trim($_POST['tel1']) : '';
$mail 			= (isset($_POST['mail'])) ? trim($_POST['mail']) : '';

$numSucursal	= (isset($_POST['numSucursal'])) ? trim($_POST['numSucursal']) : '';
$nomSucursal	= (isset($_POST['nomSucursal'])) ? trim($_POST['nomSucursal']) : '';
$iva			= (isset($_POST['iva'])) ? trim($_POST['iva']) : '';
$versionID		= (isset($_POST['versionid'])) ? trim($_POST['versionid']) : '';

if($idcadena > -1){
    $oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
    $oCorresponsal->load($_SESSION['idPreCorresponsal']);
    $oCorresponsal->setID($_SESSION['idPreCorresponsal']);
    
	$oCorresponsal->setIdCadena($idcadena);
    $oCorresponsal->setIdSubCadena($idsubcadena);
	$oCorresponsal->setTipoSubCadena($tiposubcadena);
	$oCorresponsal->setNomSubCadena($nomsubcadena);
	if ( $giro > -1 ) {
		$oCorresponsal->setIdGiro($giro);
	} else {
		$oCorresponsal->setIdGiro('');
	}
    $oCorresponsal->setIdGrupo($grupo);
	if ( $referencia > 0 ) {
    	$oCorresponsal->setIdReferencia($referencia);
	} else {
		$oCorresponsal->setIdReferencia('');
	}
    $oCorresponsal->setTel1($tel1);
    $oCorresponsal->setTel2($tel2);
    $oCorresponsal->setFax($fax);
    $oCorresponsal->setCorreo($mail);
	$oCorresponsal->setVersion($versionID);
	
	$oCorresponsal->setNumSucu($numSucursal);
    $oCorresponsal->setNomSucu($nomSucursal);
	$oCorresponsal->setIva($iva);

    $oCorresponsal->setPreRevisadoCargos(false);
    $oCorresponsal->setPreRevisadoBancos(false);
    $oCorresponsal->setPreRevisadoVersion(false);
    $oCorresponsal->setPreRevisadoDocumentacion(false);
    $oCorresponsal->setPreRevisadoGenerales(false);
    $oCorresponsal->setPreRevisadoDireccion(false);
    $oCorresponsal->setPreRevisadoContactos(false);
    $oCorresponsal->setPreRevisadoCuenta(false);
    $oCorresponsal->setRevisadoCargos(false);
    $oCorresponsal->setRevisadoBancos(false);
    $oCorresponsal->setRevisadoVersion(false);
    $oCorresponsal->setRevisadoDocumentacion(false);
    $oCorresponsal->setRevisadoGenerales(false);
    $oCorresponsal->setRevisadoDireccion(false);
    $oCorresponsal->setRevisadoContactos(false);
    $oCorresponsal->setRevisadoEjecutivos(false);
    $oCorresponsal->setRevisadoCuenta(false);
    $oCorresponsal->setRevisadoContrato(false);
    $oCorresponsal->setRevisadoForelo(false);

    if($oCorresponsal->GuardarXML())
        echo utf8_encode("0|Se guardó la información");
    else
        echo utf8_encode("1|No se pudo guardar la información");
    
}


?>