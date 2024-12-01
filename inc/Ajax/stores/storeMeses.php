<?php

	$meses = array(
		array('idMes' => 1, 'descMes' => 'Enero'),
		array('idMes' => 2, 'descMes' => 'Febrero'),
		array('idMes' => 3, 'descMes' => 'Marzo'),
		array('idMes' => 4, 'descMes' => 'Abril'),
		array('idMes' => 5, 'descMes' => 'Mayo'),
		array('idMes' => 6, 'descMes' => 'Junio'),
		array('idMes' => 7, 'descMes' => 'Julio'),
		array('idMes' => 8, 'descMes' => 'Agosto'),
		array('idMes' => 9, 'descMes' => 'Septiembre'),
		array('idMes' => 10, 'descMes' => 'Octubre'),
		array('idMes' => 11, 'descMes' => 'Noviembre'),
		array('idMes' => 12, 'descMes' => 'Diciembre')
	);

	echo json_encode(array(
		'data'	=> $meses,
		'total'	=> count($meses)
	));

?>