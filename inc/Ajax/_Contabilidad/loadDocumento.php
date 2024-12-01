<?php

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	$idDocumento		= (!empty($_POST['idDocumento']))? $_POST['idDocumento'] : 0;
	$idTipoProveedor	= (isset($_POST['idTipoProveedor']) && $_POST['idTipoProveedor'] >= 0)? $_POST['idTipoProveedor'] : 0;

	if($idTipoProveedor == 0){
		$sQ	= "CALL data_contable.SP_FACTURAS_LOAD(-1,'-1','-1','0000-00-00', '0000-00-00','0000-00-00', -1, 0, 1, 0, 'ASC', '', -1, $idDocumento, -1, 0)";
	}
	else if($idTipoProveedor == 1){
		$sQ	= "CALL data_contable.SP_FACTURAS_ACREEDOR_LOAD(-1,'-1','-1','0000-00-00', '0000-00-00','0000-00-00', -1, 0, 1, 0, 'ASC', '', -1, $idDocumento, -1, 0)";
	}

	$sql = $RBD->query($sQ);

	if(!$RBD->error($sql)){
		$res = mysqli_fetch_assoc($sql);
		$data = array();

		$data['txtTipoDcto']		= $res['tipoDocumento'];
		$data['ddlProveedor']		= $res['idProveedor'];
		$data['txtFechaFactura']	= $res['fechaFactura'];
		$data['txtFechaFin']		= $res['fechaFin'];
		$data['txtFechaIni']		= $res['fechaInicio'];
		$data['txtNumFactura']		= $res['noFactura'];
		$data['txtSubtotal']		= "\$".number_format($res['subtotal'], 2);
		$data['txtIVA']				= "\$".number_format($res['iva'], 2);
		$data['txtTotal']			= "\$".number_format($res['total'], 2);
		$data['txtDetalle']			= $res['detalle'];
		$data['idFactura']			= $res['idFactura'];
		$data['txtRFC']				= $res['RFC'];
		$data['txtNumCta']			= $res['numCuenta'];

		$response = array(
			'data'		=> $data,
			'errmsg'	=> '',
			'showMsg'	=> 0
		);
	}
	else{
		$response = array(
			'data'		=> array(),
			'errmsg'	=> $RBD->error(),
			'showMsg'	=> 1,
			'msg'		=> 'Ha ocurrido un Error'
		);
	}

	echo json_encode($response)
?>