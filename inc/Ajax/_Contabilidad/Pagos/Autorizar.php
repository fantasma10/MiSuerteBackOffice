<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$idDocumento		= (!empty($_POST['iddocumento'])) ? $_POST['iddocumento'] : 0;
	$origenDocumento	= (!empty($_POST['origendocumento'])) ? $_POST['origendocumento'] : 0;
	$tipoCorte			= (!empty($_POST['tipocorte'])) ? $_POST['tipocorte'] : 0;
	$opcion				= (!empty($_POST['opcion'])) ? $_POST['opcion'] : 0;
	$idAutorizacion		= (!empty($_POST['idautorizacion'])) ? $_POST['idautorizacion'] : 0;
	$detalle			= (!empty($_POST['detalle'])) ? $_POST['detalle'] : 0;

	$detalle = utf8_decode($detalle);

	$arrIds = explode(",", $idDocumento);

	$seguir = true;

	$idUsuario = $_SESSION['idU'];

	if($opcion > 1 || $opcion < 0){
		$msg = "las opciones validas son 0 y 1";
		$seguir = false;
	}

	if($idDocumento <= 0){
		$msg = "El id del Documento es invalido";
		$seguir = false;
	}

	if($tipoCorte > 5 || $tipoCorte < 1){
		$msg = "El corte debe ser entre 1 y 5";
		$seguir = false;
	}

	if($seguir){
		switch($tipoCorte){
			case '1': // proveedores
				$SQ = "CALL `data_contable`.`SP_PAGO_PROVEEDORES_AUTORIZAR`($idAutorizacion, $opcion, $origenDocumento, '$detalle', $idUsuario)";
			break;

			case '3': // corresponsales
				$SQ = "CALL `data_contable`.`SP_PAGO_AUTORIZAR`($tipoCorte, $idAutorizacion, $idDocumento, $opcion, '$detalle', $idUsuario)";
			break;

			default:
				$SQ = "CALL `data_contable`.`SP_PAGO_AUTORIZAR`($tipoCorte, $idAutorizacion, $idDocumento, $opcion, '$detalle', $idUsuario)";
			break;
		}


		$sql = $WBD->query($SQ);
		if(!$WBD->error()){
			$res = mysqli_fetch_assoc($sql);

			$response = array(
				'showMsg'	=> 0,
				'msg'		=> $res['msg'],
				'errmsg'	=> 0,
				'success'	=> true
			);
		}
		else{
			$response = array(
				'showMsg'	=> 1,
				'msg'		=> 'No fue posible realizar la Operación',
				'errmsg'	=> $WBD->error(),
				'success'	=> true
			);
		}
	}
	else{
		$response = array(
			'showMsg'	=> 1,
			'msg'		=> 'No fue posible realizar la Operación',
			'errmsg'	=> $msg,
			'success'	=> false
		);
	}

	
	echo json_encode($response);
?>