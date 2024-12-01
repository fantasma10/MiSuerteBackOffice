<?php

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	$idCorte = (!empty($_POST['idCorte']))? $_POST['idCorte'] : 0;

	$sQ = "CALL `data_contable`.`SP_REEMBOLSO_LOAD`($idCorte)";
	$sql = $RBD->query($sQ);


	$data = array();
	if(!$RBD->error()){
		$res = mysqli_fetch_assoc($sql);

		$data['idReembolso']		= $res['idCorte'];
		$data['ddlCad']				= $res['idCadena'];
		$data['ddlSubCad']			= $res['idSubCadena'];
		$data['ddlCorresponsal']	= $res['idCorresponsal'];
		$data['txtimporte']			= "\$".number_format($res['monto'],2);
		$data['txtfecha']			= $res['fechaPago'];
		$data['txtdescripcion']		= (!preg_match('!!u', $res['detalle']))? utf8_encode($res['detalle']) : $res['detalle'];
		$data['numCuenta']			= $res['numCuenta'];
		$data['lblNumCuenta']			= $res['numCuenta'];
		$data['saldoCuenta']		= "\$".number_format($res['saldoCuenta'], 2);
		$data['lblCadena']			= acentos($res['nombreCadena']);
		$data['lblSubCadena']		= acentos($res['nombreSubCadena']);
		$data['lblCorresponsal']	= acentos($res['nombreCorresponsal']);

		$msg		= '';
		$error		= '';
		$showMsg	= 0;
	}
	else{
		$showMsg	= 1;
		$msg		= 'No se pudo cargar el Reembolso';
		$error		= $RBD->error();
	}

	echo json_encode(array(
		'showMsg'	=> $showMsg,
		'data'		=> $data,
		'msg'		=> $msg,
		'errmsg'	=> $error
	));


	function acentos($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}
?>