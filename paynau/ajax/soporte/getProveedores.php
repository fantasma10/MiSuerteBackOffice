<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$data=array();
$nIdProveedor = !empty($_POST['nIdProveedor']) ? $_POST['nIdProveedor'] : 0;
$nIdEmpresa   = !empty($_POST['nIdEmpresa']) ? $_POST['nIdEmpresa'] : 0;

$tipo=$_POST['itipo'];

	
		if ($tipo == 3) {
			$array_params = array(
				array(
					'name'	=> 'PO_nIdProveedor',
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
		else{
			$array_params = array(
				array(
					'name'	=> 'PO_nIdProveedor',
					'type'	=> 'i',
					'value'	=> $nIdProveedor
				)
			);
		}
		$reporte=array(1=>'sp_select_proveedores',2=>'sp_select_proveedor',3=>'sp_select_empresas');
		$oRDPN->setSDatabase('paycash_one');
		$oRDPN->setSStoredProcedure($reporte[$tipo]);
		$oRDPN->setParams($array_params);

		$result = $oRDPN->execute();

		$data = $oRDPN->fetchAll();
		$oRDPN->closeStmt();
		$data =utf8ize($data);

echo json_encode($data);