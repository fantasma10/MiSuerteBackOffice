<?php

	include("../../../config.inc.php");
	include("../../../customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdCadena 			= (isset($_POST["nIdCadena"]) AND $_POST["nIdCadena"] != "")? $_POST["nIdCadena"] : -1;
	$nIdSubCadena		= (isset($_POST["nIdSubCadena"]) AND $_POST["nIdSubCadena"] != "")? $_POST["nIdSubCadena"] : -1;
	$nIdCorresponsal	= (isset($_POST["nIdCorresponsal"]) AND $_POST["nIdCorresponsal"] != "")? $_POST["nIdCorresponsal"] : -1;


	$oCuentaForelo = new CuentaForelo();
	$oCuentaForelo->setORdb($oRdb);
	$oCuentaForelo->setOWdb($oWdb);
	$oCuentaForelo->setIdCadena($nIdCadena);
	$oCuentaForelo->setIdSubCadena($nIdSubCadena);
	$oCuentaForelo->setIdCorresponsal($nIdCorresponsal);

	$arrResult = $oCuentaForelo->getLista();

	if($arrResult['bExito'] == false || $arrResult['nCodigo'] != 0){
		echo json_encode($arrResult);
		exit();
	}

	echo json_encode($arrResult);
?>