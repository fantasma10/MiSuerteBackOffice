<?php
ini_set("soap.wsdl_cache_enabled", "0");
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$caso  = (!empty($_POST["caso"]))? $_POST["caso"] : 0;

switch ($caso) {
	case 1:
		$fechaIni =$_POST["fechaIni"];
		$fechaFin =$_POST["fechaFin"];
		$tipoReporte =$_POST["tipoReporte"];
		$familia = $_POST["familia"];
		$cadena = (!empty($_POST['cadena'])) ? $_POST['cadena'] : -1;
		$subcadena = (!empty($_POST['subcadena'])) ? $_POST['subcadena'] : -1; 
		$corresponsal = (!empty($_POST['corresponsal'])) ? $_POST['corresponsal'] : -1;

		if($familia==-1){
			$familia=0;
		}

		if($cadena==-1){
			$cadena = NULL;
			$subcadena = NULL;
			$corresponsal = NULL;
		}
		if($subcadena==-1){
			$subcadena = NULL;
		}
		if($corresponsal==-1){
			$corresponsal = NULL;
		}

		$nStart		= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"]   : 0;
		$nLimit 	= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 10;
		$sBuscar    = !empty($_POST['sSearch']) ? trim($_POST['sSearch']) : '';

		$array_params = array(
			array('name' => 'p_fechaIni',		'value' => $fechaIni,		'type' => 's'),
			array('name' => 'p_fechaFin',		'value' => $fechaFin,		'type' => 's'),
			array('name' => 'p_familia',		'value' => $familia,		'type' => 'i'),
			array('name' => 'p_start',			'value' => $nStart,			'type' => 'i'),
	      	array('name' => 'p_limit',			'value' => $nLimit,			'type' => 'i'),
	      	array('name' => 'p_buscar',			'value' => $sBuscar,		'type' => 's'),
	      	array('name' => 'ck_nIdCadena',		'value' => $cadena,			'type' => 'i'),
	      	array('name' => 'ck_nIdSubCadena',	'value' => $subcadena,		'type' => 'i'),
	      	array('name' => 'ck_nIdCorresponsal', 'value' => $corresponsal,	'type' => 'i')
		);
		
        $oRdb->setSDatabase('redefectiva');
	    $oRdb->setSStoredProcedure('sp_select_info_corte_ventas');
	    $oRdb->setParams($array_params);
	    $result = $oRdb->execute();



	   	if ( $result['nCodigo'] ==0){
	    	$data = $oRdb->fetchAll();
	    	$datos = array();
	    	$index = 0;
			for($i=0;$i<count($data);$i++){
				$datos[$index]["dFecAltaOperacion"] = utf8_decode($data[$i]["dFecAltaOperacion"]);
				$datos[$index]["nMesFecAltaOparacion"] = utf8_decode($data[$i]["nMesFecAltaOparacion"]);
				$datos[$index]["nIdCadena"] = utf8_decode($data[$i]["nIdCadena"]);
				$datos[$index]["sNombreCadena"] = utf8_decode($data[$i]["sNombreCadena"]);
				$datos[$index]["nIdSubCadena"] = utf8_decode($data[$i]["nIdSubCadena"]);
				$datos[$index]["sNombreSubCadena"] = utf8_decode($data[$i]["sNombreSubCadena"]);
				$datos[$index]["nIdCorresponsal"] = utf8_decode($data[$i]["nIdCorresponsal"]);
				$datos[$index]["sNombreCorresponsal"] = utf8_decode($data[$i]["sNombreCorresponsal"]);
				$datos[$index]["sRfcCliente"] = utf8_decode($data[$i]["sRfcCliente"]);
				$datos[$index]["nIdProveedor"] = utf8_decode($data[$i]["nIdProveedor"]);
				$datos[$index]["sNombreProveedor"] = utf8_decode($data[$i]["sNombreProveedor"]);
				$datos[$index]["sRfcProveedor"] = utf8_decode($data[$i]["sRfcProveedor"]);
				$datos[$index]["nIdFamilia"] = utf8_decode($data[$i]["nIdFamilia"]);
				$datos[$index]["sDescFamilia"] = utf8_decode($data[$i]["sDescFamilia"]);
				$datos[$index]["nIdEmisor"] = utf8_decode($data[$i]["nIdEmisor"]);
				$datos[$index]["sDescEmisor"] = utf8_decode($data[$i]["sDescEmisor"]);
				$datos[$index]["nIdProducto"] = utf8_decode($data[$i]["nIdProducto"]);
				$datos[$index]["sDescProducto"] = utf8_decode($data[$i]["sDescProducto"]);
				$datos[$index]["sNumCuenta"] = utf8_decode($data[$i]["sNumCuenta"]);
				$datos[$index]["sCtaContable"] = utf8_decode($data[$i]["sCtaContable"]);
				$datos[$index]["nVentas"] = ($data[$i]["nVentas"]);
				$datos[$index]["nImporte"] = ($data[$i]["nImporte"]);
				$datos[$index]["nRetiros"] = ($data[$i]["nRetiros"]);
				$datos[$index]["nComCorresponsales"] = ($data[$i]["nComCorresponsales"]);
				$datos[$index]["nClienteCxC"] = ($data[$i]["nClienteCxC"]);
				$datos[$index]["nComIntegradores"] = ($data[$i]["nComIntegradores"]);
				$datos[$index]["nComRecibo"] = ($data[$i]["nComRecibo"]);
				$datos[$index]["nIngreso"] = ($data[$i]["nIngreso"]);
				$datos[$index]["nCPS"] = ($data[$i]["nCPS"]);
				$datos[$index]["nComOperacion"] = ($data[$i]["nComOperacion"]);
				$datos[$index]["nProveedorCxP"] = ($data[$i]["nProveedorCxP"]);
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