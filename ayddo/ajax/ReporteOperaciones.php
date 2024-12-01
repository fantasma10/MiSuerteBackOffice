<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$data=array();

if ($_POST){
	
	$tipo=$_POST['itipo'];
	if ($tipo==1){
		$array_params = array(
			array(
				'name'	=> 'p_nId',
				'type'	=> 'i',
				'value'	=> $_POST['p_nId']
			),
			array(
				'name'	=> 'p_dFechaInicio',
				'type'	=> 's',
				'value'	=> $_POST['p_dFechaInicio']
			),
			array(
				'name'	=> 'p_dFechaFin',
				'type'	=> 's',
				'value'	=> $_POST['p_dFechaFin']
			)
			);
			$reporte=array(1=>'sp_select_metodo_pago_operaciones',2=>'sp_select_proveedor_operaciones');
			$t=$_POST['tipoReporte'];
			
			$oRDPN->setSDatabase('paycash_one');
			$oRDPN->setSStoredProcedure($reporte[$t]);
			$oRDPN->setParams($array_params);

			$result = $oRDPN->execute();

			$data = $oRDPN->fetchAll();
			$data =utf8ize($data);
	}
}
echo json_encode($data );