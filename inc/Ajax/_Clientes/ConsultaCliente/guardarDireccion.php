<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$idCliente			= (!empty($_POST['idCliente']))				? $_POST['idCliente']	 						: 0;
	$idDireccion		= (!empty($_POST['idDireccion']))			? $_POST['idDireccion'] 						: 0;
	$idPais				= (!empty($_POST['dirfIdPais']))			? $_POST['dirfIdPais'] 							: "";
	$calle				= (!empty($_POST['dirfCalle']))				? trim(urldecode($_POST['dirfCalle'])) 			: "";
	$numeroInt			= (!empty($_POST['dirfNumerointerior']))	? trim(urldecode($_POST['dirfNumerointerior']))	: "";
	$numeroExt			= (!empty($_POST['dirfNumeroexterior']))	? trim(urldecode($_POST['dirfNumeroexterior']))	: "";
	$cpDireccion		= (!empty($_POST['dirfCodigo_postal']))		? $_POST['dirfCodigo_postal'] 					: "";
	$idColonia			= (!empty($_POST['dirfIdColonia']))			? $_POST['dirfIdColonia'] 						: -1;
	$idEntidad			= (!empty($_POST['dirfIdEstado']))			? $_POST['dirfIdEstado'] 						: -1;
	$idMunicipio		= (!empty($_POST['dirfIdMunicipio']))		? $_POST['dirfIdMunicipio'] 					: -1;

	if($idCliente > 0){

		$C = new Cliente($RBD, $WBD, $LOG);
		$C->load($idCliente);

		$C->ID_DIRECCION		= $idDireccion;
		$C->DIRF_ID_COLONIA		= $idColonia;
		$C->DIRF_ID_MUNICIPIO	= $idMunicipio;
		$C->DIRF_ID_ESTADO		= $idEntidad;
		$C->DIRF_ID_PAIS		= $idPais;

		$C->DIRF_CALLE			= utf8_decode($calle);
		$C->DIRF_NUMEROINTERIOR	= $numeroInt;
		$C->DIRF_NUMEROEXTERIOR	= $numeroExt;
		$C->DIRF_CODIGO_POSTAL	= $cpDireccion;
		
		/*if($C->ID_DIRECCION == 0){
			$res = $C->guardarDireccion();
		}
		else{
			$res = $C->guardarDatosGenerales();
		}*/
		//var_dump("ID_DIRECCION: ".$C->ID_DIRECCION);
		
		$res = $C->guardarDireccion();

		if($res['success'] == true){
			$idDirFiscal = $res['idDireccion'];
			$C->ID_DIRECCION = $idDirFiscal;
			$res = $C->guardarDatosGenerales();
			if ( $res['success'] == true ) {
				$res['showMsg'] = 0;
				$res['msg']		= 'Operación Exitosa';
				$res['idDireccion'] = $idDirFirscal;
			}
		}
		else{
			$res['showMsg'] = 1;
			$res['msg']		= 'No ha sido posible guardar la Dirección';	
		}
	}
	else{
		$res = array(
			'success'	=> false,
			'showMsg'	=> 1,
			'msg'		=> 'Id de Cliente inválido'
		);
	}

	echo json_encode($res);
?>