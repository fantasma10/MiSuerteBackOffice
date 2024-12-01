<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$data=array();
$nIdProveedor = !empty($_POST['nIdProveedor']) ? $_POST['nIdProveedor'] : 0;
$nIdStatus = !empty($_POST['nIdStatus']) ? $_POST['nIdStatus'] : 0;

		
		$array_params = array(
			array(
				'name'	=> 'PO_nIdProveedor',
				'type'	=> 'i',
				'value'	=> $nIdProveedor
			),
			array(
				'name'	=> 'PO_nIdStatus',
				'type'	=> 'i',
				'value'	=> $nIdStatus
			)
		);
		
		$oWDPN->setSDatabase('paycash_one');
		$oWDPN->setSStoredProcedure('sp_update_estado_proveedor');
		$oWDPN->setParams($array_params);

		$result = $oWDPN->execute();

		$data = $oWDPN->fetchAll();
		$data =utf8ize($data);

echo json_encode($data);