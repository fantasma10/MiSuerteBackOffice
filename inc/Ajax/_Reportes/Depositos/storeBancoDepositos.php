<?php

	include("../../../config.inc.php");
	include("../../../session.ajax.inc.php");

	$oBanco = new Banco();
	$oBanco->setRBD($oRdb);
	$oBanco->setWBD($oWdb);

	$resultado = $oBanco->getListaBancosDeposito();

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0 || $resultado['num_rows'] == 0){
		$aaData = array();
		$iTotal = 0;
	}
	else{
		$aaData = $resultado['data'];
		$iTotal = $resultado['num_rows'];
	}

	echo json_encode(array(
		'bExito'	=> true,
		'nCodigo'	=> 0,
		'data'		=> $aaData,
		'nTotal'	=> $iTotal
	));

?>