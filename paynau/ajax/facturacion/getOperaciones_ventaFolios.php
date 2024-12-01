<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");


$nIdProveedor = !empty($_POST['nIdProveedor']) ? $_POST['nIdProveedor']: 0 ;
$fechaIni = !empty($_POST["fechaIni"]) ? $_POST["fechaIni"]: DATE('Y-m-d') ;
$fechaFin = !empty($_POST["fechaFin"]) ? $_POST["fechaFin"]: DATE('Y-m-d') ;


$nStart		= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"]   : 0;
$nLimit 	= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 10;

	$array_params = array(
            array('name' => 'PO_nIdProveedor', 'value' => $nIdProveedor, 'type' =>'i'),
            array('name' => 'PO_dFechaInicial', 'value' => $fechaIni, 'type' =>'s'),
            array('name' => 'PO_dFechaFinal', 'value' => $fechaFin, 'type' =>'s')
        );
		
	$oRDPN->setSDatabase('paycash_one');
	$oRDPN->setSStoredProcedure('sp_select_operciones_venta_folios');
	$oRDPN->setParams($array_params);
	$result = $oRDPN->execute();

	if ( $result['nCodigo'] ==0){
        $datos = array();
        $index = 0;
		$data = $oRDPN->fetchAll();
        for($i=0;$i<count($data);$i++){	
            
            $dFechaCompra    = $data[$i]['dFechaCompra'];
            $sRazonSocial    = utf8_encode($data[$i]['sRazonSocial']);
            $sRFC            = $data[$i]['sRFC'];
            $nCantidadFolios = $data[$i]['nCantidadFolios'];
            $nPrecioCompra   = number_format($data[$i]['nPrecioCompra'],2);
            $nPrecioVenta    = number_format($data[$i]['nPrecioVenta'],2);
            $nCostoFolios    = number_format($data[$i]['nCostoFolios'],2);
            $iva_cfdi        = $data[$i]['iva_cfdi'];
            $sMetodoPago     = $data[$i]['sMetodoPago'];
            $nCostoMetodo    = number_format($data[$i]['nCostoMetodo'],2);
            if (($data[$i]['nIdMedioPago'] == 1)) {
                $nComision = number_format(($data[$i]['nComision'] * $data[$i]['nCantidadFolios']),2);
            }else{
                $nComision       = number_format($data[$i]['nComision'],2);
            }
            
            $sTotIVAComision = number_format($data[$i]['sTotIVAComision'],2);

            $nTotalCobrado   =  number_format(($data[$i]['nCostoFolios'] + $nComision),2);
            
            $nUtilidad       =  number_format((($data[$i]['nCostoFolios'] - $data[$i]['costoProveedorCFDI']) + ($data[$i]['nComision'] - $data[$i]['nCostoMetodo'])),2);
            $costoProveedorCFDI = number_format($data[$i]['costoProveedorCFDI'],2);

            
            $datos[$index]['dFechaCompra']    = $dFechaCompra;
            $datos[$index]['sRazonSocial']    = $sRazonSocial;
            $datos[$index]['sRFC']            = $sRFC;
            $datos[$index]['nCantidadFolios'] = $nCantidadFolios;
            $datos[$index]['nPrecioCompra']   = '$'.$nPrecioCompra;
            $datos[$index]['nPrecioVenta']    = '$'.$nPrecioVenta;
            $datos[$index]['nCostoFolios']    = '$'.$nCostoFolios;
            $datos[$index]['iva_cfdi']        = '$'.$iva_cfdi;
            $datos[$index]['sMetodoPago']     = '$'.$sMetodoPago;
            $datos[$index]['nCostoMetodo']    = '$'.$nCostoMetodo;
            $datos[$index]['nComision']       = '$'.$nComision;
            $datos[$index]['sTotIVAComision'] = '$'.$sTotIVAComision;
            $datos[$index]['nTotalCobrado']   = '$'.$nTotalCobrado;
            $datos[$index]['nUtilidad']       = '$'.$nUtilidad;
            $datos[$index]['costoProveedorCFDI']       = '$'.$costoProveedorCFDI;

            // $nCostoFolios    = (float)$data[$i]['nCostoFolios'];
            // $sTotalIvaFolios = (float)$data[$i]['sTotIVAFolios'];
            // $nCostoMetodo    = (float)$data[$i]['nCostoMetodo'];
            
            // $nPrecioCompra   = (float)$data[$i]['nPrecioCompra'];
            // $nPrecioVenta    = (float)$data[$i]['nPrecioVenta'];
            // $nPrecioCompra   = $data[$i]['nPrecioCompra'];
            // $nCantidadFolios = $data[$i]['nCantidadFolios'];

            // $nCostoProveedorCFDI = (float) $data[$i]['costoProveedorCFDI'];
            // $datos[$index]['dFechaCompra']    = $data[$i]['dFechaCompra'];
            // $datos[$index]['sRazonSocial']    = utf8_encode($data[$i]['sRazonSocial']);
            // $datos[$index]['sRFC']            = $data[$i]['sRFC'];
            // $datos[$index]['nCantidadFolios'] = $nCantidadFolios;
            // $datos[$index]['nPrecioCompra']   = $nPrecioCompra;
            // $datos[$index]['nPrecioVenta']    = $nPrecioVenta;
            // $datos[$index]['nCostoFolios']    = $nCostoFolios - $sTotalIvaFolios;
            // $datos[$index]['sTotIVAFolios']   = $sTotalIvaFolios;
            // $datos[$index]['sMetodoPago']     = $data[$i]['sMetodoPago'];
            // $datos[$index]['iva_cfdi']     = (float)$data[$i]['iva_cfdi'];
            // $datos[$index]['costoProveedorCFDI']     = $nCostoProveedorCFDI;
            
            // if($data[$i]['nIdMedioPago']   ==1){
            //     $nComision = $nCostoFolios  * $nCostoMetodo;
            // }
            // else{
            //      $nComision = $nCostoFolios  + $nCostoMetodo;
            // }
            
            // (float) $datos[$index]['nCostoMetodo'] = $nComision;
            
            // $datos[$index]['nComision']    = (float) $data[$i]['nComision'];
            
            // $precioVenta = ($nPrecioVenta * $nCantidadFolios); //Lo que me pagaron por los folios SIN IVA
            // $precioCompra = ($nPrecioCompra * $nCantidadFolios); //Lo que costo el total de los CFDI
            
            // $costoMetodoVenta = floatval($data[$i]['nComision']); // Lo que cobre por el metodo de pago SIN IVA
            // $costoMetodoCompra = $data[$i]['nCostoMetodo']; // Lo que pague por el metodo
            // $utilidadFolios = ($precioVenta - $precioCompra);
            // $utilidadMetodo = ($costoMetodoVenta - $costoMetodoCompra);
            
            // $data[$i]['nUtilidad'] =  $utilidadFolios + $utilidadMetodo;

            // $datos[$index]['sTotIVAComision']     = (float)$data[$i]['sTotIVAComision'];
            // $datos[$index]['nTotalCobrado'] = $nCostoFolios + $nComision;
            // $datos[$index]['nUtilidad']     = (float) number_format((($data[$i]['nCostoFolios'] - $data[$i]['costoProveedorCFDI']) + ($data[$i]['nComision'] - $data[$i]['nCostoMetodo'])),2);
            // $datos[$index]['nUtilidades']   = (float) number_format((((float)$data[$i]['nCostoFolios'] - (float) $data[$i]['costoProveedorCFDI']) + (float)($data[$i]['nComision'] - $data[$i]['nCostoMetodo'])),2);

           
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
// var_dump($resultado);
echo json_encode($resultado);


?>