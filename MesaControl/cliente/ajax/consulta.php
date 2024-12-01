<?php
ini_set("soap.wsdl_cache_enabled", "0");
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 

// Consulta de cliente si es webpos (sp_select_cliente_webpos)
	$array_params_config = array(
		array(
			'name' => 'ck_idCliente', 
			'value' => 0, 
			'type' =>'i'
		)
	);
	
	$oRdb->setSDatabase('redefectiva');
	$oRdb->setSStoredProcedure('sp_select_cliente_webpos');
	$oRdb->setParams($array_params_config);

	$resultCfg = $oRdb->execute();

	$dataCfg = null;
	if($resultCfg['nCodigo'] == 0){
		$dataCfg = $oRdb->fetchAll();
	}
	$oRdb->closeStmt();
// ********************************



// Consulta de mapeo de cliente en Aquimispagos
	// $array_params_mapeo = array(
	// 	array(
	// 		'name' => 'ck_nIdSubCadena', 
	// 		'value' => 0, 
	// 		'type' =>'i'
	// 	)
	// );
	// $oRAMP->setSDatabase('aquimispagos');
	// $oRAMP->setSStoredProcedure('sp_select_mapeoCliente_RE');
	// $oRAMP->setParams($array_params_mapeo);

	// $resultMap = $oRAMP->execute();

	// $dataMap = null;
	// if($resultMap['nCodigo'] == 0){
	// 	$dataMap = $oRAMP->fetchAll();
	// }
	// $oRAMP->closeStmt();


	// *** WS ***
	$array_params_mapeo= array(
		'IdSubCadena' => 0 
	);

	$respuesta = null;
	if( $client != '' ){
		$respuesta =(array)$client->ObtenerClientesMapeados($array_params_mapeo); // OK
	}

	if($respuesta != null ){
		if($respuesta['ObtenerClientesMapeadosResult']->ErrorCode == 0){
			$dataMap = null;
			if( isset($respuesta['ObtenerClientesMapeadosResult']->Model->anyType->enc_value) ){
				$dataMap[] = $respuesta['ObtenerClientesMapeadosResult']->Model->anyType->enc_value;
			}
			else{
				for( $i=0; $i<count($respuesta['ObtenerClientesMapeadosResult']->Model->anyType); $i++ )
				{
					$dataMap[] = $respuesta['ObtenerClientesMapeadosResult']->Model->anyType[$i]->enc_value;
				}
			}
		}else{ // error
			$dataMap = 0;
		}
	}// *** *** ***
// *** *** ***


$estatus  = (!empty($_POST["idEstatus"]))? $_POST["idEstatus"] : -1;
if (!empty($_POST["prealta"])) {
    $estatus = $_POST["prealta"] == 1 ? 1 : $estatus;
}

$array_params = array(array('name' => 'CknEstatus', 'value' => $estatus, 'type' =>'i'));
$oRdb->setSDatabase('redefectiva');
$oRdb->setSStoredProcedure('sp_select_cliente_por_estatus');
$oRdb->setParams($array_params);

$result = $oRdb->execute();

if ( $result['nCodigo'] == 0 ) {
	$data = $oRdb->fetchAll();

	$oRdb->closeStmt();

	$datos = array();
	$index = 0;
	$idMigracion = 0;
	
	for($i=0;$i<count($data);$i++){
		$numCuenta = 0;
		for($a=0; $a<count($dataCfg); $a++){
			if( $data[$i]["idCliente"] == $dataCfg[$a]['idCliente'] ){
				$idMigracion = 1;
				$numCuenta = $dataCfg[$a]['numCuenta'];
				break;
			}else{ 
				$idMigracion = 0; 
			}
		}

		if( is_array($dataMap) ){
			for($a=0; $a<count($dataMap); $a++){
				if($dataMap[$a]->IdSubCadenaRE == $data[$i]["idSubCadena"]){
					$idMigracion = 2; // Ya se encuentra mapeado. 
					break;
				}else{
					$idMigracion = 1; // No esta mapeado.
				}
			}
		}

		$datos[$index]["idCliente"] = $data[$i]["idCliente"];
		$datos[$index]["RFC"] = $data[$i]["RFC"];
		$datos[$index]["razonSocial"] = utf8_encode($data[$i]["RazonSocial"]);
		$datos[$index]["nombreCliente"] = utf8_encode($data[$i]["NombreCliente"]);
		$datos[$index]["idEstatus"] = $data[$i]["idEstatus"];							
		$datos[$index]["idSubCadena"] = $data[$i]["idSubCadena"];	
		$datos[$index]["idCadena"] = $data[$i]["idCadena"];	
		$datos[$index]['idMigracion'] = $idMigracion;
		$datos[$index]['numCuenta'] = $numCuenta;
		$index++;
	}
	$oRdb->closeStmt();
	$totalDatos = $oRdb->foundRows();
	$oRdb->closeStmt();
} else {
	$datos = 0;
	$totalDatos = 0;
}

$resultado = array(
	"iTotalRecords"     => $totalDatos,
	"iTotalDisplayRecords"  => $totalDatos,
	"aaData"        => $datos,
);

echo json_encode($resultado);

?>