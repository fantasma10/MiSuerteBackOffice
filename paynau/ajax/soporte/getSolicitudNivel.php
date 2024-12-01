<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$data=array();
$nIdProveedor = !empty($_POST['nIdProveedor']) ? $_POST['nIdProveedor'] : 0;
$sMotivoRechazo = !empty($_POST['sMotivoRechazo']) ? $_POST['sMotivoRechazo'] : '';
$nNivel = !empty($_POST['nNivel']) ? $_POST['nNivel'] : 1;

$tipo=$_POST['itipo'];
		if($tipo == 2) {
			$array_params = array(
				array(
					'name'	=> 'PO_nIdProveedor',
					'type'	=> 'i',
					'value'	=> $nIdProveedor
				),
				array(
					'name'	=> 'PO_sRazonRechazo',
					'type'	=> 's',
					'value'	=> utf8_decode($sMotivoRechazo)
				),
				array(
					'name'	=> 'PO_nNivel',
					'type'	=> 'i',
					'value'	=> $nNivel
				)
			);	
		}else
		{
			$array_params = array(
				array(
					'name'	=> 'PO_nIdProveedor',
					'type'	=> 'i',
					'value'	=> $nIdProveedor
				)
			);
		}
		$reporte=array(1=>'sp_select_solicitud_cambio_nivel',2=>'sp_actualizar_nivel');
		if ($tipo ==2) {
			
			$oWDPN->setSDatabase('paycash_one');
			$oWDPN->setSStoredProcedure($reporte[$tipo]);
			$oWDPN->setParams($array_params);

			$result = $oWDPN->execute();

			$data = $oWDPN->fetchAll();
			$data = array('data' => $data);	
		}
		else{
			$oRDPN->setSDatabase('paycash_one');
			$oRDPN->setSStoredProcedure($reporte[$tipo]);
			$oRDPN->setParams($array_params);

			$result = $oRDPN->execute();

			$data = $oRDPN->fetchAll();
			$oRDPN->closeStmt();
		}
		$data =utf8ize($data);

echo json_encode($data);