<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");

$idcadena = (isset($_POST['idcadena'])) ? trim($_POST['idcadena']) : -1;
$giro = (isset($_POST['idgiro'])) ? trim($_POST['idgiro']) : -1;
$grupo = (isset($_POST['idgrupo'])) ? trim($_POST['idgrupo']) : -1;
$referencia = (isset($_POST['idref'])) ? trim($_POST['idref']) : -1;
$tel1 = (isset($_POST['tel1'])) ? trim($_POST['tel1']) : '';
$mail = (isset($_POST['mail'])) ? trim($_POST['mail']) : '';

if ( $idcadena > -1 ) {
    $oSubcadena = new XMLPreSubCad($RBD,$WBD);
    $oSubcadena->load($_SESSION['idPreSubCadena']);
    $oSubcadena->setID($_SESSION['idPreSubCadena']);
    $oSubcadena->setIdCadena($idcadena);
    $oSubcadena->setIdGiro($giro);
    $oSubcadena->setIdGrupo($grupo);
    $oSubcadena->setIdReferencia($referencia);
    $oSubcadena->setTel1($tel1);
    $oSubcadena->setCorreo($mail);

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

    if ( $oSubcadena->GuardarXML() ) {
        if ( $oSubcadena->AsociarPreSubCadenaConCadena() ) {
			echo utf8_encode("0|Se guardó la información");
		}
    } else {
        echo utf8_encode("1|No se pudo guardar la información");
    }
}


?>