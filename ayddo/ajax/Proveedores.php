<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$data=array();

if ($_POST){
	/* tipo:
1:Buscar de proveedores
*/
$tipo=$_POST['itipo'];
		if ($tipo==1){
			/*$array_params = array(
			array(
				'name'	=> 'p_nIdIntegrador',
				'type'	=> 'i',
				'value'	=> 0
			)
			);*/
			$oRDPN->setSDatabase('paycash_one');
			$oRDPN->setSStoredProcedure('sp_select_proveedores_ajax');
			$oRDPN->setParams(null);
			$result = $oRDPN->execute();
			
			$data = $oRDPN->fetchAll();
			$data =utf8ize($data);
		}

}
echo json_encode($data );