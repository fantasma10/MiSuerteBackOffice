<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$nIdProveedor = !empty($_POST['nIdProveedor']) ? $_POST['nIdProveedor']: 0 ;
$nIdEmpresa = !empty($_POST['nIdEmpresa']) ? $_POST['nIdEmpresa']: 0 ;
$fechaIni = !empty($_POST["fechaIni"]) ? $_POST["fechaIni"]: '' ;
$fechaFin = !empty($_POST["fechaFin"]) ? $_POST["fechaFin"]: '' ;


// $nIdProveedor = 0;
// $nIdEmpresa=0;
// $fechaIni = '2020-06-25';
// $fechaFin = '2020-06-25';

$nStart		= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"]   : 0;
$nLimit 	= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 10;

	

    $array_params = array(
            array('name' => 'PO_nIdProveedor', 'value' => $nIdProveedor, 'type' =>'i'),
            array('name' => 'PO_nIdEmpresa', 'value' => $nIdEmpresa, 'type' =>'i'),
            array('name' => 'PO_dFechaInicial', 'value' => $fechaIni, 'type' =>'s'),
            array('name' => 'PO_dFechaFinal', 'value' => $fechaFin, 'type' =>'s')
        );
		
	$oRDPN->setSDatabase('paycash_one');
	$oRDPN->setSStoredProcedure('sp_select_facturas_back_office');
	$oRDPN->setParams($array_params);
	$result = $oRDPN->execute();
                
	if ( $result['nCodigo'] ==0){
        $datos = array();
        $index = 0;
		$data = $oRDPN->fetchAll();
        for($i=0;$i<count($data);$i++){	
            $datos[$index]['sRazonSocial']   =  utf8ize($data[$i]['sRazonSocial']);
            $datos[$index]['sRFC']            = utf8ize($data[$i]['sRFC']);
            $datos[$index]['strSerie']        = utf8ize($data[$i]['strSerie']);
            $datos[$index]['dPeticion']       = utf8ize($data[$i]['dPeticion']);
            $datos[$index]['totTotal']        = utf8ize($data[$i]['totTotal']);
            $datos[$index]['strRFC']          = utf8ize($data[$i]['strRFC']);
            $datos[$index]['strRazonSocial']  = utf8ize($data[$i]['strRazonSocial']);
            $datos[$index]['nCantidadFolios'] = utf8ize($data[$i]['nCantidadFolios']);
            $datos[$index]['dFechaVigencia']  = utf8ize($data[$i]['dFechaVigencia']);
             
            
            $index++;
        }
        $oRDPN->closeStmt();
        $totalDatos = $oRDPN->foundRows();
        $oRDPN->closeStmt();
    }
    else{
	    	$datos = 0;
	    	$totalDatos = 0;
	    }

	

$resultado = array(
    "iTotalRecords"     => $totalDatos,
    "iTotalDisplayRecords"  => $totalDatos,
    "aaData"        => $datos		    
);


echo json_encode($resultado);


?>