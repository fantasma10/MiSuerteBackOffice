<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");


$data=array();

if ($_POST){

$tipo=$_POST['itipo'];
		if ($tipo==1){

			$oRDPN->setSDatabase('paycash_one');
			$oRDPN->setSStoredProcedure('sp_select_metodos_pago');
			$oRDPN->setParams(null);
			$result = $oRDPN->execute();
			
			$data = $oRDPN->fetchAll();
			$data =utf8ize($data);
		}

}
echo json_encode($data );