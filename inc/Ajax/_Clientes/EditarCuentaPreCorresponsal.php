<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$tipoFORELO = (isset($_POST['tipoforelo'])) ? trim($_POST['tipoforelo']) : -1;
$idbanco = (isset($_POST['idbanco'])) ? trim($_POST['idbanco']) : -1;
$clabe = (isset($_POST['clabe'])) ? trim($_POST['clabe']) : '';
$beneficiario = (isset($_POST['beneficiario'])) ? trim($_POST['beneficiario']) : '';
$cuenta = (isset($_POST['cuenta'])) ? trim($_POST['cuenta']) : '';
$descripcion = (isset($_POST['descripcion'])) ? trim($_POST['descripcion']) : '';

$beneficiario = utf8_decode($beneficiario);
$descripcion = utf8_decode($descripcion);

$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
$oCorresponsal->load($_SESSION['idPreCorresponsal']);
$oCorresponsal->setID($_SESSION['idPreCorresponsal']);

$oCorresponsal->setIdBanco($idbanco);
$oCorresponsal->setNumCuenta($cuenta);
$oCorresponsal->setClabe($clabe);
$oCorresponsal->setBeneficiario($beneficiario);
$oCorresponsal->setDescripcion($descripcion);
$oCorresponsal->setTipoFORELO($tipoFORELO);

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

if ( $tipoFORELO == 2 ) {
	if($oCorresponsal->GuardarCuentaBanco()) {
		if ( $oCorresponsal->GuardarXML() ) {
			echo utf8_encode("0|Se guardó la cuenta de banco");
		} else {
			echo utf8_encode("1|No se pudo guardar la cuenta de banco");
		}
	} else {
		echo utf8_encode("1|No se pudo guardar la cuenta de banco");
	}
} else if ( $tipoFORELO == 1 ) {
	$oCorresponsal->setReferenciaBancaria("");
	if ( $oCorresponsal->GuardarXML() ) {
		echo utf8_encode("0|Se guardó la cuenta de banco");
	} else {
		echo utf8_encode("1|No se pudo guardar la cuenta de banco");
	}
}
?>