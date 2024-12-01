
<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$data=array();

$nIdOrden = (!empty($_POST['nIdOrden'])) ? $_POST['nIdOrden']   : 0;

$tipo = $_POST['tipo'];


		$array_params = array(
	      array(
	        'name'    => 'nIdOrden',
	        'value'   => $nIdOrden,
	        'type'    => 'i'
	      )
	    );
		
		$oRDPN->setSDatabase('paycash_one');
		$oRDPN->setSStoredProcedure('sp_select_detalles_orden_cobro');
		$oRDPN->setParams($array_params);

		$result = $oRDPN->execute();

		$data = $oRDPN->fetchAll();
		$data =utf8ize($data);
		$oRDPN->closeStmt();
echo json_encode($data);