<?php

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	//id de la factura
	$idDocumento = (!empty($_POST['idDocumento']))? $_POST['idDocumento'] : 0;

	$sQ = "CALL data_contable.SP_FACTURAS_GRUPOS_LOAD(-1,-1,-1,'0000-00-00', '0000-00-00','0000-00-00', -1, 0, 1, 0, 'ASC', '', -1, $idDocumento, -1, -1, '')";
	$sql	= $RBD->query($sQ);

	if(!$RBD->error($sql)){
		$res = mysqli_fetch_assoc($sql);
		$data = array();

		$data['txtTipoDcto']			= $res['tipoDocumento'];
		$data['txtFechaFactura']		= $res['fechaFactura'];
		$data['txtFechaFin']			= $res['fechaFin'];
		$data['txtFechaIni']			= $res['fechaInicio'];
		$data['txtNumFactura']			= $res['noFactura'];
		$data['txtSubtotal']			= "\$".number_format($res['subtotal'], 2);
		$data['txtIVA']					= "\$".number_format($res['iva'], 2);
		$data['txtTotal']				= "\$".number_format($res['total'], 2);
		$data['txtDetalle']				= acentos($res['detalle']);
		$data['idFactura']				= $res['idFactura'];
		$data['txtRFC']					= $res['rfc'];
		$data['txtNumCta']				= $res['numeroCuenta'];
		$data['txtMoneda']				= $res['moneda'];
		$data['txtTipoCambio']			= $res['tipoCambio'];
		$data['txtNombreCadena']		= acentos($res['nombreCadena']);
		$data['txtNombreSubCadena']		= acentos($res['nombreSubCadena']);
		$data['txtNombreCorresponsal']	= acentos($res['nombreCorresponsal']);
		$data['txtRazonSocial']			= acentos($res['razonSocial']);
		$data['txtCalle']				= acentos($res['calle']);
		$data['txtNoExterior']			= $res['noExterior'];
		$data['txtNoInterior']			= $res['noInterior'];
		$data['txtColonia']				= acentos($res['colonia']);
		$data['txtMunicipio']			= acentos($res['municipio']);
		$data['txtEstado']				= acentos($res['estado']);
		$data['txtCodigoPostal']		= acentos($res['codigoPostal']);
		$data['txtPais']				= acentos($res['pais']);
		$data['txtSerie']				= $res['serie'];
		$data['txtFolio']				= $res['folio'];
		$data['txtMoneda']				= $res['moneda'];
		$data['txtTipoCambio']			= $res['tipoCambio'];
		$data['ddlCad']					= $res['idCadena'];
		$data['ddlSubCad']				= $res['idSubCadena'];
		$data['ddlCorresponsal']		= $res['idCorresponsal'];		
		$data['txtnombreGrupo']			= acentos($res['nombreGrupo']);
		$data['idGrupo']				= $res['idGrupo'];
		$data['txtUUID']				= $res['UUID'];
		
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

	echo json_encode($response);

	function acentos($txt){
		return !preg_match('!!u', $txt) ? utf8_encode($txt) : $txt;
	}
?>