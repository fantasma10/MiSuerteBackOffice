<?php

	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$comisiones		= (!empty($_POST['comisiones']))? $_POST['comisiones'] : 0;
	$reembolso		= (!empty($_POST['reembolso']))? $_POST['reembolso'] : 0;
	$CLABE			= (!empty($_POST['CLABE']))? $_POST['CLABE'] : 0;
	$idBanco		= (!empty($_POST['idBanco']))? $_POST['idBanco'] : 0;
	$txtBanco		= (!empty($_POST['txtBanco']))? $_POST['txtBanco'] : 0;
	$numCuenta		= (!empty($_POST['numCuenta']))? $_POST['numCuenta'] : 0;
	$beneficiario	= (!empty($_POST['beneficiario']))? urldecode($_POST['beneficiario']) : 0;
	$descripcion	= (!empty($_POST['descripcion']))? urldecode($_POST['descripcion']) : 0;
	$idCliente		= (!empty($_POST['idCliente']))? $_POST['idCliente'] : 0;
//exit();
	$oAf = new AfiliacionCliente($RBD, $WBD, $LOG);

	$oAf->load($idCliente);
	$respuesta = array();

	if($oAf->ERROR_CODE == 0){
	
		if($comisiones == 1 || $reembolso == 1){

			$CUENTA = new AfiliacionCuenta($RBD, $WBD, $LOG);

			if($oAf->IDCUENTA != 0){
				$CUENTA->IDCUENTA = $oAf->IDCUENTA;
			}

			$CUENTA->CLABE			= $CLABE;
			$CUENTA->IDBANCO		= $idBanco;
			$CUENTA->NUMCUENTA		= $numCuenta;
			$CUENTA->BENEFICIARIO	= trim(utf8_decode($beneficiario));
			$CUENTA->DESCRIPCION	= trim(utf8_decode($descripcion));

			$resp = $CUENTA->guardarCuenta();
		}
		else if($comisiones == 0 && $reembolso == 0){
			$CUENTA = new AfiliacionCuenta($RBD, $WBD, $LOG);
			$CUENTA->IDCUENTA = $oAf->IDCUENTA;
			$resp = $CUENTA->eliminarCuenta();
		}

		if($resp['success'] == true){
			$oAf->COMISIONES	= $comisiones;
			$oAf->REEMBOLSO		= $reembolso;

			$oAf->IDCUENTA		= $resp['data']['idCuenta'];

			$respuesta = $oAf->actualizarForelo();

			if($respuesta['success'] == true){
				$respuesta['msg'] = 'Operación Realizada Exitosamente';
			}
		}
		else{
			$respuesta = $resp;
			$respuesta['showMsg'] = 1;
			$respuesta['msg'] = 'No ha sido posible guardar los Datos de la Cuenta';
		}

	}
	else{
		$respuesta = array(
			'showMsg'	=> 1,
			'success'	=> false,
			'msg'		=> 'No ha sido posible Cargar los Datos de la Afiliación',
			'errmsg'	=> $oAf->ERROR_CODE." : ".$oAf->ERROR_MSG
		);
	}
	$oAf->prepararCliente();
	echo json_encode($respuesta);
?>