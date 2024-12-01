<?php
	include '../../../config.inc.php';
	include '../../../session.ajax.inc.php';
	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/

	$nIdSubCadena		= (!empty($_POST['nIdSubCadena']))? $_POST['nIdSubCadena'] : 0;
	$nIdVersion			= (!empty($_POST['nIdVersion']))? $_POST['nIdVersion'] : 0;
	$nIdRegimen			= (!empty($_POST['nIdRegimen']))? $_POST['nIdRegimen'] : 0;
	$nNumCuentaForelo	= (!empty($_POST['nNumCuentaForelo']))? trim($_POST['nNumCuentaForelo']) : 0;
	$sRFC				= (!empty($_POST['sRFC']))? trim($_POST['sRFC']) : 0;
	$sRazonSocial		= (!empty($_POST['sRazonSocial']))? trim($_POST['sRazonSocial']) : 0;
	$sTelefono			= (!empty($_POST['sTelefono']))? trim($_POST['sTelefono']) : 0;
	$sEmail				= (!empty($_POST['sEmail']))? trim($_POST['sEmail']) : 0;
	$sNombre			= (!empty($_POST['sNombre']))? trim($_POST['sNombre']) : 0;
	$sPaterno			= (!empty($_POST['sPaterno']))? trim($_POST['sPaterno']) : 0;
	$sMaterno			= (!empty($_POST['sMaterno']))? trim($_POST['sMaterno']) : 0;

	$nClabe							= (!empty($_POST['nClabe']))												? $_POST['nClabe']						: '';
	$nIdBanco						= (!empty($_POST['nIdBanco']))												? $_POST['nIdBanco']					: '0';
	$nIdTipoComision				= (!empty($_POST['nIdTipoComision']))										? $_POST['nIdTipoComision']				: '';
	$nIdTipoLiquidacionComision		= (!empty($_POST['nIdTipoLiquidacionComision']))							? $_POST['nIdTipoLiquidacionComision']	: '';
	$nIdTipoLiquidacionReembolso	= (!empty($_POST['nIdTipoLiquidacionReembolso']))							? $_POST['nIdTipoLiquidacionReembolso']	: '';
	$nIdTipoReembolso				= (!empty($_POST['nIdTipoReembolso']))										? $_POST['nIdTipoReembolso']			: '';
	$sCorreoBen						= (!empty($_POST['sCorreoBen']))											? $_POST['sCorreoBen']					: '';
	$sNombreBeneficiario			= (!empty($_POST['sNombreBeneficiario']))									? $_POST['sNombreBeneficiario']			: '';
	$sRfcBen						= (!empty($_POST['sRfcBen']))												? $_POST['sRfcBen']						: '';
	$nIdTipoMovimiento				= (isset($_POST['nIdTipoMovimiento']) && $_POST['nIdTipoMovimiento'] >= 0)	? $_POST['nIdTipoMovimiento']			: 0;
	$nIdTipoInstruccion				= (!empty($_POST['nIdTipoInstruccion']))									? $_POST['nIdTipoInstruccion']			: -1;
	$nIdDestino						= (!empty($_POST['nIdDestino']))											? $_POST['nIdDestino']					: -1;
	$nIdUsuario						= $_SESSION['idU'];

	$QUERY	= "call `redefectiva`.`SP_PATCH_INSERT_CLIENTE`(".$nIdSubCadena.",".$nIdVersion.",".$nIdRegimen.",".$nNumCuentaForelo.",'".$sRFC."', '".utf8_decode($sRazonSocial)."', '".utf8_decode($sNombre)."', '".utf8_decode($sPaterno)."','".utf8_decode($sMaterno)."', '".$sTelefono."','".$sEmail."','".$nClabe."','".$nIdBanco."',".$nIdTipoComision.",".$nIdTipoLiquidacionComision.",".$nIdTipoLiquidacionReembolso.",".$nIdTipoReembolso.",'".$sCorreoBen."','".utf8_decode($sNombreBeneficiario)."','".$sRfcBen."', ".$nIdUsuario.", ".$nIdTipoMovimiento.",".$nIdTipoInstruccion.",".$nIdDestino.")";
	$SQL	= $WBD->SP($QUERY);
	$data	= array();

	if(!$WBD->error()){
		$row = mysqli_fetch_assoc($SQL);

		$bExito	= ($row['CodigoRespuesta'] == 0)? true : false;
		$data	= array();

		if($row['CodigoRespuesta'] == 0){
			$data['idCliente'] = $row['idCliente'];
		}
		echo json_encode(array(
			'bExito'	=> $bExito,
			'nCodigo'	=> $row['CodigoRespuesta'],
			'sMensaje'	=> $row['MsgRespuesta'],
			'data'		=> $data
		));
	}
	else{
		echo json_encode(array(
			'bExito'			=> false,
			'nCodigo'			=> 100,
			'sMensaje'			=> 'Ha ocurrido un Error, contacte al administrador del sistema.',
			'sMensajeDetallado'	=> $WBD->error()
		));
	}


?>