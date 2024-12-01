<?php
ini_set("soap.wsdl_cache_enabled", "0");
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;

switch ($tipo) {
	case 2:
		$estatus =$_POST["estatus"];
		$fechaIni =$_POST["fechaIni"];
		$fechaFin =$_POST["fechaFin"];
		$rfc = $_POST["rfc"];


		if($estatus==-1){
			$estatus="empty";
		}
		if(empty($rfc)){
			$rfc="empty";
		}

		$nStart		= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"]   : 0;
		$nLimit 	= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 10;
		$sBuscar    = !empty($_POST['sSearch']) ? trim($_POST['sSearch']) : '';
		$tipo=1;

		$array_params = array(
			array('name' => 'p_estatus',		'value' => $estatus,		'type' => 's'),
			array('name' => 'p_fechaIni',		'value' => $fechaIni,		'type' => 's'),
			array('name' => 'p_fechaFin',		'value' => $fechaFin,		'type' => 's'),
			array('name' => 'p_RFC',			'value' => $rfc,			'type' => 's'),
			array('name' => 'p_start',			'value' => $nStart,			'type' => 's'),
	      	array('name' => 'p_limit',			'value' => $nLimit,			'type' => 's'),
	      	array('name' => 'p_buscar',			'value' => $sBuscar,		'type' => 's'),
	      	array('name' => 'tipo',				'value' => $tipo,			'type' => 'i'),
		);


        $oRdb->setSDatabase('redefectiva');
	    $oRdb->setSStoredProcedure('sp_select_ordenes_pagos');
	    $oRdb->setParams($array_params);
	    $result = $oRdb->execute();


	   	
	   	if ( $result['nCodigo'] ==0){
	    	$data = $oRdb->fetchAll();
	    	$datos = array();
	    	$index = 0;
			for($i=0;$i<count($data);$i++){
				$datos[$index]["nIdOrdenPago"] = $data[$i]["nIdOrdenPago"];
				$datos[$index]["dFechaRegistro"] = $data[$i]["dFechaRegistro"];
				$datos[$index]["dFechaPago"] = $data[$i]["dFechaPago"];
				$datos[$index]["nIdTipoPago"] = $data[$i]["nIdTipoPago"];
				$datos[$index]["sCuentaOrigen"] = $data[$i]["sCuentaOrigen"];
				$datos[$index]["sCuentaBeneficiario"] = $data[$i]["sCuentaBeneficiario"];
				$datos[$index]["importe"] = $data[$i]["importe"];
				$datos[$index]["importe_transferencia"] = $data[$i]["importe_transferencia"];
				$datos[$index]["nTotal"] = $data[$i]["nTotal"];
				$datos[$index]["sBeneficiario"] = $data[$i]["sBeneficiario"];
				$datos[$index]["sCorreoDestino"] = $data[$i]["sCorreoDestino"];
				$index++;
			}
			$oRdb->closeStmt();
			$totalDatos = $oRdb->foundRows();
			$oRdb->closeStmt();
	    }else{
	    	$datos = 0;
	    	$totalDatos = 0;
	    }
		$resultado = array(
			"detalle_consulta"=> $result,
		    "iTotalRecords"     => $totalDatos,
		    "iTotalDisplayRecords"  => $totalDatos,
		    "aaData"        => $datos		    
		);
	    echo json_encode($resultado);
	break;

	default:
		# code...
		break;
}

?>