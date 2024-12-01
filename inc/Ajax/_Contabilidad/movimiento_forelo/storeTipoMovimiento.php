<?php

	include("../../../config.inc.php");
	include("../../../customFunctions.php");

	$oTipoMovimiento = new TipoMovimiento();
	$oTipoMovimiento->setORdb($oRdb);
	$oTipoMovimiento->setOWdb($oWdb);

	$arrResult = $oTipoMovimiento->getLista();

	if($arrResult['bExito'] == false || $arrResult['nCodigo'] != 0){
		echo json_encode($arrResult);
		exit();
	}

	$data = utf8ize($arrResult['data']);

	$arrResult['data'] = $data;

	echo json_encode($arrResult);
?>
