
<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$data=array();
$nIdProveedor = !empty($_POST['nIdProveedor']) ? $_POST['nIdProveedor'] : 0;

		$array_params = array(
			array(
				'name'	=> 'PO_nIdProveedor',
				'type'	=> 'i',
				'value'	=> $nIdProveedor
			)
		);

		
		
		$oRDPN->setSDatabase('paycash_one');
		$oRDPN->setSStoredProcedure('sp_select_direccion');
		$oRDPN->setParams($array_params);
		$result = $oRDPN->execute();
		$data = $oRDPN->fetchAll();
		$dataDireccion =utf8ize($data);
		
		$oWDPN->setSDatabase('paycash_one');
		$oWDPN->setSStoredProcedure('sp_select_cuentaproveedor');
		$oWDPN->setParams($array_params);
		$result        = $oWDPN->execute();
		$data          = $oWDPN->fetchAll();
		$dataCuenta =utf8ize($data);


$Result = array(
			'oDireccion' => $dataDireccion,
			'oCuenta' => $dataCuenta
		);
echo json_encode($Result);