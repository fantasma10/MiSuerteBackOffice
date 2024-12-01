<?php

    $nIdCadena				= $_POST['nIdCadena'] != "-1"       ? $_POST['nIdCadena']		: 0;
	$nEstatusConciliacion 	= $_POST['nEstatusConciliacion'];
	$nPorAutorizar			= $_POST['nPorAutorizar'];
    $dFechaInicial			= !empty($_POST['dFechaInicial'])	? $_POST['dFechaInicial']	: $nuevafecha;
    $dFechaFinal			= !empty($_POST['dFechaFinal'])		? $_POST['dFechaFinal']		: $nuevafecha;
    $start					= (!empty($_POST["iDisplayStart"]))								? $_POST["iDisplayStart"]	: 0;
    $limit					= (!empty($_POST["iDisplayLength"]))							? $_POST["iDisplayLength"]	: -1;
    $sortCol				= (isset($_POST['iSortCol_0']) AND $_POST['iSortCol_0'] > -1)	? $_POST['iSortCol_0']		: 0;
    $sortDir				= (!empty($_POST['sSortDir_0']))								? $_POST['sSortDir_0']		: 0;

    $oConciliacionDiferencia = new ConciliacionDiferencia();
    $oConciliacionDiferencia->setNIdCadena($nIdCadena);
    $oConciliacionDiferencia->setORdb($oRdb);

    $resultado = $oConciliacionDiferencia->obtener_detalle_general($start, $limit, $nEstatusConciliacion, $dFechaInicial, $dFechaFinal, $nPorAutorizar);

    if($resultado['bExito'] == true){
		$aaData				= $resultado['data'];
		$array_resultado	= array();

		$nMontoTotal	= 0;
		$nComisionTotal = 0;

		foreach($aaData as $key => $array){

			$sEstatus = "Disponible";
			if ($array['nIdEstatus'] == 1) {
				$sEstatus = "Concluido conciliado";
			} else if ($array['nIdEstatus'] == 2) {
				$sEstatus = "Concluido no conciliado";
			}
 
			$array_resultado[] = array(
				'Cadena'					        => $array['sCadena'],
				'Tipo'						        => $array['sTipo'],
				'Folio'						        => $array['nIdFolio'],
				utf8_decode('Fecha de operación')	=> $array['dFechaOperacion'],
				'IdEmisor'					        => $array['nIdEmisor'],
				'Emisor'					        => $array['sNombreEmisor'],
				'Referencia'				        => $array['sReferencia'],
				'Monto'						        => $array['nImporte'],
				'Fecha Conciliada'			        => (isset($array['dFecConciliacion']) && $array['dFecConciliacion'] != "")? date("Y-m-d", strtotime($array['dFecConciliacion'])) : '',
				utf8_decode('Estatus Conciliación') => $array['sEstatus'],
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
		ExportQueryToCsv('ReporteDiferencias_', $array_resultado);
	}
?>