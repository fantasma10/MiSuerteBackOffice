<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$data=array();

if ($_POST){
	
		$array_params = array(
			array(
				'name'	=> 'p_dFecha',
				'type'	=> 's',
				'value'	=> $_POST['fecha']
			),
			array(
				'name'	=> 'p_nId',
				'type'	=> 'i',
				'value'	=> $_POST['proveedor']
			),
		);
			
		$reporte=array(1=>'sp_select_detalle_corte_metodo_pago',2=>'sp_select_detalle_corte_proveedor');
		$t=$_POST['tipoReporte'];
		$oRDPN->setSDatabase('paycash_one');
		$oRDPN->setSStoredProcedure($reporte[$t]);
		$oRDPN->setParams($array_params);

		$result = $oRDPN->execute();

		$data = $oRDPN->fetchAll();
		$data =utf8ize($data);
}
echo json_encode($data);