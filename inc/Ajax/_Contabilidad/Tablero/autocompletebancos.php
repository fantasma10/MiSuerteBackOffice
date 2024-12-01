<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$str = !empty($_POST['query'])? $_POST['query'] : '';

	$nIdBanco 	= 0;
	$strBancos	= '';

	if(is_numeric($str)){
		$nIdBanco = $str;
	}
	else{
		$strBancos = $str;
	}

	$oBanco = new Banco();
	$oBanco->setRBD($RBD);
	$oBanco->setNIdBanco($nIdBanco);
	$oBanco->setStrBancos(utf8_decode($strBancos));

	$arrBancos = $oBanco->getListaBancos2();

	$arrBancos['suggestions'] = $arrBancos['data'];
	echo json_encode($arrBancos);
?>