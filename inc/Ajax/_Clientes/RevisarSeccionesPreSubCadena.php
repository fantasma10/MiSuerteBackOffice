<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");

$cargos = (isset($_POST['cargos'])) ? $_POST['cargos'] : '1';
$generales = (isset($_POST['generales'])) ? $_POST['generales'] : '';
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : '';
$contactos = (isset($_POST['contactos'])) ? $_POST['contactos'] : '';
$contrato = (isset($_POST['contrato'])) ? $_POST['contrato'] : '';
$version = (isset($_POST['version'])) ? $_POST['version'] : '';
$cuenta = (isset($_POST['cuenta'])) ? $_POST['cuenta'] : '';
$documentacion = (isset($_POST['documentacion'])) ? $_POST['documentacion'] : '';

$oSubCadena = new XMLPreSubCad($RBD,$WBD);
$oSubCadena->load($_SESSION['idPreSubCadena']);

$fechaActual = date("Y-m-d");
$errorReferenciaBancaria = false;

$query = "CALL `prealta`.`SP_COUNT_PREREFERENCIASBANCARIAS`('$fechaActual');";
$result = $RBD->SP($query);

if ( $RBD->error() == "" ) {
	$row = mysqli_fetch_array($result);
	$numeroConsecutivo = $row[0];
	$numeroConsecutivo += 1;
	$numeroConsecutivo = str_pad( $numeroConsecutivo, 3, '0', STR_PAD_LEFT );
	$anoActual = date("Y");
	$mesActual = date("m");
	$diaActual = date("d");
	$numeroCuenta = '1'.$anoActual.$mesActual.$diaActual.$numeroConsecutivo.'A';
	$query = "CALL `data_contable`.`SP_ALG_REFBNMX`('$numeroCuenta', @refBancaria);";
	$result = $RBD->SP($query);
	if ( $RBD->error() == "" ) {
		$row = mysqli_fetch_assoc($result);
		$referenciaBancaria = $row['@REFERENCIA'];
		$query = "CALL `prealta`.`SP_INSERT_PREREFERENCIABANCARIA`('$referenciaBancaria');";
		$result = $RBD->SP($query);
		if ( $RBD->error() == "" ) {
			$oSubCadena->setReferenciaBancaria($referenciaBancaria);
		} else{
			echo "5|No pudo insertarse la Referencia Bancaria";
			$errorReferenciaBancaria = true;
		}
	} else {
		echo "4|No pudo generarse la Referencia Bancaria";
		$errorReferenciaBancaria = true;
	}
} else {
	echo "3|No pudo obtenerse el total de Referencias Bancarias";
	$errorReferenciaBancaria = true;
}

if($cargos == "1"){
	$oSubCadena->setRevisadoCargos(true);
}else{
    $oSubCadena->setRevisadoCargos(false);
}

if($generales == "1")
    $oSubCadena->setRevisadoGenerales(true);
else
    $oSubCadena->setRevisadoGenerales(false);
	
if($direccion == "1")
    $oSubCadena->setRevisadoDireccion(true);
else
    $oSubCadena->setRevisadoDireccion(false);
	
if($contactos == "1")
    $oSubCadena->setRevisadoContactos(true);
else
    $oSubCadena->setRevisadoContactos(false);
	
if($contrato == "1")
    $oSubCadena->setRevisadoContrato(true);
else
    $oSubCadena->setRevisadoContrato(false);	

if($version == "1")
    $oSubCadena->setRevisadoVersion(true);
else
    $oSubCadena->setRevisadoVersion(false);

if($cuenta == "1"){
    $oSubCadena->setRevisadoCuenta(true);
}else{
    $oSubCadena->setRevisadoCuenta(false);
}
	
if($documentacion == "1")
    $oSubCadena->setRevisadoDocumentacion(true);
else
    $oSubCadena->setRevisadoDocumentacion(false);

if ( !$errorReferenciaBancaria ) {
	if($oSubCadena->GuardarXML())
		echo "0|Se pre-revisaron las secciones";
	else
		echo "1|No se pudieron pre-revisar las secciones";
}
    
?>