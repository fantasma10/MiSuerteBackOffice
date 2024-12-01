<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$data=array();
$nIdProveedor = !empty($_POST['nIdProveedor']) ? $_POST['nIdProveedor'] : 0;
$nIdEmpresa = !empty($_POST['nIdEmpresa']) ? $_POST['nIdEmpresa'] : 0;
$tipo = $_POST['tipo'];


		if ($tipo == 2) {
			$array_params = array(
				array(
					'name'	=> 'PO_nIdEmpresa',
					'type'	=> 'i',
					'value'	=> $nIdEmpresa
				)
			);
		}else{
			$array_params = array(
				array(
					'name'	=> 'PO_IdProveedor',
					'type'	=> 'i',
					'value'	=> $nIdProveedor
				),
				array(
					'name'	=> 'PO_nIdEmpresa',
					'type'	=> 'i',
					'value'	=> $nIdEmpresa
				)
			);
		}
		$reporte=array(1=>'sp_select_empresas',2=>'sp_select_lineas_negocio');
		$oRDPN->setSDatabase('paycash_one');
		$oRDPN->setSStoredProcedure($reporte[$tipo]);
		$oRDPN->setParams($array_params);

		$result = $oRDPN->execute();

		$data = $oRDPN->fetchAll();
		$data =utf8ize($data);

echo json_encode($data);