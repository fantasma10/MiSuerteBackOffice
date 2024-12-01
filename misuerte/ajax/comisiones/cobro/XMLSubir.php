<?php

	include $_SERVER['DOCUMENT_ROOT'].'/inc/config.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/session2.ajax.inc.php';
	include $_SERVER['DOCUMENT_ROOT'].'/inc/customFunctions.php';

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$sFILE			= !empty($_FILES['sFileFactura'])? $_FILES['sFileFactura'] : '';
	$nIdProveedor	= !empty($_POST['nIdProveedor'])? $_POST['nIdProveedor'] : 0;
	$array_cortes	= !empty($_POST['nIdCorte'])? $_POST['nIdCorte'] : 0;

	if(empty($_FILES['sFileFactura']['tmp_name']) || $_FILES['sFileFactura']['tmp_name'] == 'none') {
		$error = 'No file was uploaded..';
	}

	$xmls		= simplexml_load_file($sFILE['tmp_name']);
	$namespaces = $xmls->getNamespaces(true);

	$xmls->registerXPathNamespace('cfdi', 'http://www.sat.gob.mx/cfd/3');
	$nodosEncabezado = $xmls->xpath('//cfdi:Comprobante');

	foreach($nodosEncabezado as $tagEncabezado){
		$arrTag = array();
		foreach ($tagEncabezado->attributes() as $attrName => $xmlValue){
			$arrTag[$attrName] = $xmlValue->__toString();
		}
	}

	$nodosEmisor = $xmls->xpath('//cfdi:Emisor');

	foreach($nodosEmisor as $tagEmisor){
		$arrTagEmisor = array();
		foreach($tagEmisor->attributes() as $attrName => $xmlValue){
			$arrTagEmisor[$attrName] = $xmlValue->__toString();
		}
	}

	$sSerie			= $arrTag['serie'];
	$nFolio			= $arrTag['folio'];
	$nTotal 		= $arrTag['total'];
	$sRFC			= $arrTagEmisor['rfc'];
	$sFolio			= $sSerie.$nFolio;
	$sListaCortes	= implode(',', $array_cortes);

	$oCorteComision = new CorteComision();
	$oCorteComision->setORdb($MRDB);
	$oCorteComision->setOWdb($MWDB);

	$resultado = $oCorteComision->asignarFactura($sRFC, $nTotal, $sFolio, $sListaCortes);

	if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		echo json_encode($resultado);
		exit();
	}

	$data		= $resultado['data'][0];
	$nCodigo	= $data['nCodigo'];
	$sMensaje	= $data['sMensaje'];

	echo json_encode(array(
		'bExito'	=> ($nCodigo == 0)? true : false,
		'nCodigo'	=> $nCodigo,
		'sMensaje'	=> $sMensaje
	));

	#echo '<pre>'; var_dump($xmls); echo '</pre>';
?>