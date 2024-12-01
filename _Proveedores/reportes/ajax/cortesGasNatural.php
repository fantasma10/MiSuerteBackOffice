<?php
ini_set("soap.wsdl_cache_enabled", "0");
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

//VARIABLES PARA GAS NATURAL
$METROGAS = 119;
$GASNATURAL=27;


/*
case 1: obtiene reporte de corte para gas natural
*/
$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;
switch ($tipo) {
    case 1:
		$proveedor =$_POST["proveedor"];
		$fechaIni =$_POST["fechaIni"];
		$fechaFin =$_POST["fechaFin"];
		$nfechaTipo =$_POST["fechaTipo"];
        
        $totOpe=0;
        $totMonto=0;
        $totCom=0;
        $totPago=0;
        
		$nStart		= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"]   : 0;
		$nLimit 	= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 10;
		$sBuscar    = !empty($_POST['sSearch']) ? trim($_POST['sSearch']) : '';
		$array_params = array(
			array('name' => 'p_idProveedor',	'value' => $proveedor,		'type' => 'i'),
			array('name' => 'p_fechaIni',		'value' => $fechaIni,		'type' => 's'),
			array('name' => 'p_fechaFin',		'value' => $fechaFin,		'type' => 's'),
			array('name' => 'p_start',			'value' => $nStart,			'type' => 'i'),
	      	array('name' => 'p_limit',			'value' => $nLimit,			'type' => 'i'),
	      	array('name' => 'p_buscar',			'value' => $sBuscar,		'type' => 's'),
	      	array('name' => 'p_fechaTipo',		'value' => $nfechaTipo,		'type' => 'i')
		);

        $oRdb->setSDatabase('redefectiva');
	    $oRdb->setSStoredProcedure('sp_select_corte_proveedor_GN');
		//echo $array_params;
	    $oRdb->setParams($array_params);
	    $result = $oRdb->execute();
	    $data = $oRdb->fetchAll();
	   	if ( $result['nCodigo'] ==0){
	    	$datos = array();
	    	$index = 0;
			for($i=0;$i<count($data);$i++){
                $datos[$index]["nIdProveedor"] = $data[$i]["nIdProveedor"];
                $datos[$index]["nZona"] = $data[$i]["nZona"];
                $datos[$index]["sNombreZona"] =  utf8_encode($data[$i]["sNombreZona"]);   
                $datos[$index]["nIdProducto"] = $data[$i]["nIdProducto"];
                if($data[$i]["nIdProducto"]>0 && $data[$i]["nIdProveedor"]==$GASNATURAL){
                	$datos[$index]["sNombreProducto"] =  utf8_encode($data[$i]["sNombreProducto"]);
                }else{
                	if($data[$i]["nIdProducto"]==0 && $data[$i]["nIdProveedor"]==$GASNATURAL){
                		$datos[$index]["sNombreProducto"] =  "Online";
                	}else{
                		$datos[$index]["sNombreProducto"] =  "";
                	}                	
                }
				$datos[$index]["dFecha"] = $nfechaTipo == 1 ? $data[$i]["dFecha"]: "";
				$datos[$index]["dFechaPago"] = $data[$i]["dFechaPago"];
				$datos[$index]["nombreProveedor"] = utf8_encode($data[$i]["nombreProveedor"]);
                $datos[$index]["sClabe"] = $data[$i]["sClabe"];
				$datos[$index]["nTotalOperaciones"] = $data[$i]["nTotalOperaciones"];
				$datos[$index]["nTotalMonto"] = "$".number_format($data[$i]["nTotalMonto"],2,'.',',');
                $datos[$index]["nTotalMonto2"] = $data[$i]["nTotalMonto"];
				$datos[$index]["nTotalComision"] = "$".number_format($data[$i]["nTotalComision"],2,'.',',');
                $datos[$index]["nTotalComision2"] = $data[$i]["nTotalComision"];
				$datos[$index]["nTotalPago"] = "$".number_format($data[$i]["nTotalPago"],2,'.',',');
                $datos[$index]["nTotalPago2"] = $data[$i]["nTotalPago"];
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