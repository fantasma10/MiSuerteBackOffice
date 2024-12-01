<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$nIdUnidadNegocio = !empty($_POST['nIdUnidadNegocio']) ? $_POST['nIdUnidadNegocio']: 0 ;
$nIdEmpresa = !empty($_POST['nIdEmpresa']) ? $_POST['nIdEmpresa']: 0 ;
$fechaIni = !empty($_POST["fechaIni"]) ? $_POST["fechaIni"]: '' ;
$fechaFin = !empty($_POST["fechaFin"]) ? $_POST["fechaFin"]: '' ;


// $nIdUnidadNegocio = 75;
// $nIdEmpresa=0;
// $fechaIni = '2020-07-01';
// $fechaFin = '2020-08-06';

$nStart		= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"]   : 0;
$nLimit 	= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 10;

	

    $array_params = array(
            array('name' => 'PO_nIdUnidadNegocio', 'value' => $nIdUnidadNegocio, 'type' =>'i'),
            array('name' => 'PO_nIdEmpresa', 'value' => $nIdEmpresa, 'type' =>'i'),
            array('name' => 'PO_dFechaInicial', 'value' => $fechaIni, 'type' =>'s'),
            array('name' => 'PO_dFechaFinal', 'value' => $fechaFin, 'type' =>'s')
        );
		
	$oRDPN->setSDatabase('facturacion');
	$oRDPN->setSStoredProcedure('sp_select_facturas_back_office');
	$oRDPN->setParams($array_params);
	$result = $oRDPN->execute();
                
	if ( $result['nCodigo'] ==0){
        $datos = array();
        $index = 0;
		$data = $oRDPN->fetchAll();
        for($i=0;$i<count($data);$i++){	
            $datos[$index]['sRazonSocialEmisor']   = utf8ize($data[$i]['RAZONSOCIAL']);
            $datos[$index]['sRFCEmisor']           = utf8ize($data[$i]['RFC']);
            $datos[$index]['sFolioFiscal']         = utf8ize($data[$i]['strFolioFiscal']);
            $datos[$index]['dFechaEmision']        = utf8ize($data[$i]['dPeticion']);
            $datos[$index]['nTotalFactura']        = '$'.utf8ize($data[$i]['totTotal']);
            $datos[$index]['sRazonSocialReceptor'] = utf8ize($data[$i]['strRazonSocial']);
            $datos[$index]['sRFCReceptor']         = utf8ize($data[$i]['strRFC']);
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
    "aaData"        => $datos,
    'data' => $array_params	    
);


echo json_encode($resultado);


?>