<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$idProveedor	= (!empty($_POST['idProveedor']))? str_replace('txt', '', $_POST['idProveedor']) : '';
	$RFC			= (!empty($_POST['RFC']))? str_replace('txt', '', $_POST['RFC']) : '';
	$idFactura		= (!empty($_POST['idFactura']))? str_replace('txt', '', $_POST['idFactura']) : '';

	$campo = (!empty($_POST['campo']))? str_replace('txt', '', $_POST['campo']) : '';
	$valor = (!empty($_POST['valor']))? str_replace('txt', '', $_POST['valor']) : '';
	
	$res = array();
	if(!empty($campo) /*&& !empty($valor)*/){
		if(!empty($idProveedor)){
			if ( $campo == "NumFactura" || $campo == "noFactura" ) {
				$SQ = "SELECT COUNT(*) AS cuenta , `idFactura` FROM `data_contable`.`dat_facturas` WHERE `noFactura` = '".$valor."' AND `rfc` = '$RFC' AND `idEstatus` != 3" ;
			} else {
				$SQ = "SELECT COUNT(*) AS cuenta , `idFactura` FROM `data_contable`.`dat_facturas` WHERE `UUID` = '".$valor."' AND `rfc` = '$RFC' AND `idEstatus` != 3" ;
			}
			$sql = $RBD->query($SQ);

			$res = mysqli_fetch_assoc($sql);

			if($res['cuenta'] > 0 && $idFactura != $res['idFactura']){
				$res = array(
					'showMsg'	=> 1,
					'msg'		=> 'Ya existe una Factura/Recibo con esa Información',
					'success'	=> false
				);
			}
			else{
				$res = array(
					'showMsg'	=> 0,
					'msg'		=> 'Todo ok',
					'success'	=> true
				);
			}
		}
		else{
			$SQ = "SELECT COUNT(*) AS cuenta FROM `redefectiva`.`dat_proveedor` WHERE `".$campo."` = '".$valor."'";
			$sql = $RBD->query($SQ);

			$res = mysqli_fetch_assoc($sql);

			if($res['cuenta'] > 0){
				$res = array(
					'showMsg'	=> 1,
					'msg'		=> 'Ya existe un Proveedor con esa Información',
					'success'	=> false
				);
			}
			else{
				$res = array(
					'showMsg'	=> 0,
					'msg'		=> 'Todo ok',
					'success'	=> true
				);
			}
		}
	}

	echo json_encode($res);
?>