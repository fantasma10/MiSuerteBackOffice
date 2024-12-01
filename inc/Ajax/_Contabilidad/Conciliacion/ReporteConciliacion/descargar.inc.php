<?php

	$nIdTipo				= !empty($_POST['nIdTipo'])										? $_POST['nIdTipo']					: 0;
	$nIdCorte				= !empty($_POST['nIdCorte'])									? $_POST['nIdCorte']				: 0;
	$nIdArchivo				= !empty($_POST['nIdArchivo'])									? $_POST['nIdArchivo']				: 0;
	$nIdNivelConciliacion	= !empty($_POST['nIdNivelConciliacion'])						? $_POST['nIdNivelConciliacion']	: 0;
	$start					= (!empty($_POST["iDisplayStart"]))								? $_POST["iDisplayStart"]			: 0;
	$limit					= (!empty($_POST["iDisplayLength"]))							? $_POST["iDisplayLength"]			: 20;
	$sortCol				= (isset($_POST['iSortCol_0']) AND $_POST['iSortCol_0'] > -1)	? $_POST['iSortCol_0']				: 0;
	$sortDir				= (!empty($_POST['sSortDir_0']))								? $_POST['sSortDir_0']				: 0;

	$oConciliacionDiferencia = new ConciliacionDiferencia();
	$oConciliacionDiferencia->setORdb($oRdb);
	$oConciliacionDiferencia->setNIdTipo($nIdTipo);
	$oConciliacionDiferencia->setNIdNivelConciliacion($nIdNivelConciliacion);
	$oConciliacionDiferencia->setNIdCorte($nIdCorte);
	$oConciliacionDiferencia->setNIdArchivo($nIdArchivo);
	
	$resultado = $oConciliacionDiferencia->obtener_detalle(0, -1);

	$iTotal = 0;
	$aaData = array();
	$errmsg	= '';

	$dFechaExport = '';

	if($resultado['bExito'] == true){
		$aaData				= $resultado['data'];
		$array_resultado	= array();

		$nMontoTotal	= 0;
		$nComisionTotal = 0;

		$dFechaExport = $aaData[0]['dFecha'];
		foreach($aaData as $key => $array){
			$array_resultado[] = array(
				'Cadena'							=> $array['nombreCadena'],
				'Tipo'								=> $array['sIdTipo'],
				'Folio'								=> $array['nIdFolio'],
				utf8_decode('Fecha de operación')	=> $array['dFechaOperacion'],
				'IdEmisor'							=> $array['nIdEmisor'],
				'Emisor'							=> $array['sNombreEmisor'],
				'Referencia'						=> $array['sReferencia'],
				'Monto'								=> $array['nImporte'],
				'Fecha Conciliada'					=> (isset($array['dFecConciliacion']) && $array['dFecConciliacion'] != "") ? date("Y-m-d", strtotime($array['dFecConciliacion'])) : '',
				utf8_decode('Estatus Conciliación') => $array['sEstatus']
			);

			$nMontoTotal += str_replace(",", "", $array['nImporte']);
		}

		$array_resultado[] = array(
			'Cadena'							=> '',
			'Tipo'								=> '',
			'Folio'								=> '',
			utf8_decode('Fecha de operación')	=> '',
			'IdEmisor'							=> '',
			'Emisor'							=> '',
			'Referencia'						=> '',
			'Monto'								=> number_format($nMontoTotal, 2),
			'Fecha Conciliada'          		=> '',
			utf8_decode('Estatus Conciliación') => ''
		);

		$array_resultado = utf8ize($array_resultado);
	}
	else{
		$errmsg = $oReporte->GetErrorCode.' : '.$oReporte->GetErrorMsg();
	}

	if(isset($_POST['ExportarAExcel']) && $_POST['ExportarAExcel'] == 1){
		ExportQueryToCsv('DetalleDiferencias_'.$dFechaExport.'_', $array_resultado);
	}

?>