<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	function numeroplano($n){
		return str_replace(array("\$", ","), '', $n);
	}

	$idProveedor		= (!empty($_POST['idProveedor']))? numeroplano($_POST['idProveedor']) : 0;
	$idConfiguracion	= (!empty($_POST['idConfiguracion']))? numeroplano($_POST['idConfiguracion']) : 0;
	$fechaInicio		= (!empty($_POST['fecha1']))? numeroplano($_POST['fecha1']) : '0000-00-00';
	$fechaFin			= (!empty($_POST['fecha2']))? numeroplano($_POST['fecha2']) : '0000-00-00';
	$fechaPago			= (!empty($_POST['fecha11']))? numeroplano($_POST['fecha11']) : '0000-00-00';
	$comisioncliente	= (!empty($_POST['comisioncliente']))? numeroplano($_POST['comisioncliente']) : 0;
	$comisionganada		= (!empty($_POST['comisionganada']))? numeroplano($_POST['comisionganada']) : 0;
	$importe			= (!empty($_POST['importe']))? numeroplano($_POST['importe']) : 0;
	$importeneto		= (!empty($_POST['importeneto']))? numeroplano($_POST['importeneto']) : 0;
	$importetotal		= (!empty($_POST['importetotal']))? numeroplano($_POST['importetotal']) : 0;
	//$iva				= (!empty($_POST['iva']))? numeroplano($_POST['iva']) : 0;
	$subtotal			= (!empty($_POST['subtotal']))? numeroplano($_POST['subtotal']) : 0;
	$totalOp			= (!empty($_POST['total']))? numeroplano($_POST['total']) : 0; //total de operaciones, es la primera columna del reporte

	$idusuario = $_SESSION['idU'];

	$sql = $RBD->query("SELECT `iva` FROM `redefectiva`.`cat_iva` WHERE `idIva` = 2");
	$res = mysqli_fetch_assoc($sql);
	$iva = (!empty($res['iva']))? $res['iva'] : 0.16;

	$subtotal = $importetotal / (1+$iva);
	$importeIva = $importetotal - $subtotal;

	$SQ = "CALL `data_contable`.`SP_CORTES_PROVEEDOR_CREATE`($idProveedor, $idConfiguracion, '$fechaInicio', '$fechaFin', $subtotal, $importeIva, $importetotal, $importeneto, $totalOp, $idusuario, '$fechaPago')";

	$sql = $WBD->query($SQ);

	if(!$WBD->error()){

		$res = mysqli_fetch_assoc($sql);

		if($res['codigo'] == 0){
			$response = array(
				'success'	=> true,
				'showMsg'	=> 1,
				'msg'		=> 'Corte creado Correctamente',
				'errmsg'	=> ''
			);
		}
		else{
			$response = array(
				'success'	=> false,
				'showMsg'	=> 1,
				'msg'		=> acentos($res['msg']),
				'errmsg'	=> $WBD->error()
			);
		}
	}
	else{
		$response = array(
			'success'	=> false,
			'showMsg'	=> 1,
			'msg'		=> 'No ha sido posible crear el Corte',
			'errmsg'	=> $WBD->error()
		);
	}

	echo json_encode($response);
?>