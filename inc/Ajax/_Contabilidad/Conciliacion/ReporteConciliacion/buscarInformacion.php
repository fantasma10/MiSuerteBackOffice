<?php

	$oReporte = new ConciliacionReporte();
	$oReporte->setORdb($oRdb);
	$oReporte->setNIdCadena($nIdCadena);
	$oReporte->setNIdSubCadena($nIdSubCadena);
	$oReporte->setNIdNivelConciliacion($nIdNivelConciliacion);
	$resultado = $oReporte->obtenerDatosReporte($dFechaInicial, $dFechaFinal);

	$array_encabezados = array(
		'cadenas'			=> array(),
		'subcadenas'		=> array(),
		'corresponsales'	=> array()
	);

	$_resultado = $resultado['data'];

	foreach($_resultado AS $result){
		#echo '<pre>'; var_dump($result); echo '</pre>';
		$array_encabezados['cadenas'][$result['nIdCadena']] = $result['sNombreCadena'];
	}

	#echo '<pre>'; var_dump($array_encabezados); echo '</pre>';
?>