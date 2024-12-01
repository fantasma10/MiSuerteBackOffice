<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$cargos = (isset($_POST['cargos'])) ? $_POST['cargos'] : '';
$generales = (isset($_POST['generales'])) ? $_POST['generales'] : '';
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : '';
$horario = (isset($_POST['horario'])) ? $_POST['horario'] : '';
$contactos = (isset($_POST['contactos'])) ? $_POST['contactos'] : '';
$contrato = (isset($_POST['contrato'])) ? $_POST['contrato'] : '';
$version = (isset($_POST['version'])) ? $_POST['version'] : '';
$cuenta = (isset($_POST['cuenta'])) ? $_POST['cuenta'] : '';
$documentacion = (isset($_POST['documentacion'])) ? $_POST['documentacion'] : '';
$bancos = (isset($_POST['bancos'])) ? $_POST['bancos'] : '';

$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
$oCorresponsal->load($_SESSION['idPreCorresponsal']);

$fechaActual = date("Y-m-d");
$errorReferenciaBancaria = false;

$query = "CALL `prealta`.`SP_COUNT_PREREFERENCIASBANCARIAS`('$fechaActual');";
$result = $RBD->SP($query);

$tipoFORELO = $oCorresponsal->getTipoFORELO();
if ( $tipoFORELO == 2 ) {
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
				$oCorresponsal->setReferenciaBancaria($referenciaBancaria);
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
}

if($cargos == "1"){
	$oCorresponsal->setRevisadoCargos(true);
}else{
    $oCorresponsal->setRevisadoCargos(false);
}

if($bancos == "1"){
	$oCorresponsal->setRevisadoBancos(true);
}else{
    $oCorresponsal->setRevisadoBancos(false);
}

if($generales == "1")
    $oCorresponsal->setRevisadoGenerales(true);
else
    $oCorresponsal->setRevisadoGenerales(false);
	
if($direccion == "1")
    $oCorresponsal->setRevisadoDireccion(true);
else
    $oCorresponsal->setRevisadoDireccion(false);
	
if($contactos == "1")
    $oCorresponsal->setRevisadoContactos(true);
else
    $oCorresponsal->setRevisadoContactos(false);	

if($version == "1")
    $oCorresponsal->setRevisadoVersion(true);
else
    $oCorresponsal->setRevisadoVersion(false);

if($cuenta == "1")
    $oCorresponsal->setRevisadoCuenta(true);
else
    $oCorresponsal->setRevisadoCuenta(false);
	
if($documentacion == "1"){
    $oCorresponsal->setRevisadoDocumentacion(true);
}else{
    $oCorresponsal->setRevisadoDocumentacion(false);
}

if ( !$errorReferenciaBancaria ) {
	if($oCorresponsal->GuardarXML())
		echo "0|Se pre-revisaron las secciones";
	else
		echo "1|No se pudieron pre-revisar las secciones";
}
    
?>