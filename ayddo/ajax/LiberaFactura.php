<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$data=array();

if ($_POST){
	
		$array_params = array(
			array(
				'name'	=> 'p_nId',
				'type'	=> 'i',
				'value'	=> $_POST['corte']
			)
			);
			
			$oRDPN->setSDatabase('paycash_one');
			$oRDPN->setSStoredProcedure('sp_update_factura');
			$oRDPN->setParams($array_params);

			$result = $oRDPN->execute();

			$data = $oRDPN->fetchAll();
			$data =utf8ize($data);
}
echo json_encode($data);