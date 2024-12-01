<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");
	
	
	$fechaIni = !empty($_POST['fechaIni_excel']) ? $_POST['fechaIni_excel']: '' ;
	$fechaFin = !empty($_POST['fechaFin_excel']) ? $_POST['fechaFin_excel']: '' ;
	$nIdProveedor = !empty($_POST["nIdProveedor_excel"]) ? $_POST["nIdProveedor_excel"]: 0 ;
	
	if ($nIdProveedor > 0) {
		$Emisor = 'POR PROVEEDOR';
	}
	elseif ($nIdEmpresa > 0) {
		$Emisor = 'POR EMPRESA';		
	}
	else{
		$Emisor = 'GENERAL';
	}

	header("Content-type=application/x-msdownload; charset=UTF-8");
	header("Content-disposition:attachment;filename=ReporteVetaCFDI.xls");
	header("Pragma:no-cache");
	header("Expires:0");
	echo "\xEF\xBB\xBF";
	echo $out;

	if ( !empty($fechaIni) && !empty($fechaFin) ) {
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
	    	$c = "<table >";
	    	$c .= "<thead>";
	    	$c .= "<tr><th colspan='12'>RED EFECTIVA, S.A. DE C.V</th></tr>";
	    	$c .= "<tr><th colspan='12'>Reporte del Sistema: PayNau</th></tr>";
	    	$c .= "<tr><th colspan='12'>REPORTE DE OPERACIONES POR VENTA DE FOLIOS ($Emisor)</th></tr>";
	    	$c .= "<tr><th colspan='12'>PERIODO DE: $fechaIni AL $fechaFin</th></tr>";
	    	$c .= "<tr><th></th></tr>";
	    	$c .= "<tr>";
	    	$c .= "<th>Fecha Compra</th>";
            $c .= "<th>Razon Social</th>";
            $c .= "<th>RFC</th>";
            $c .= "<th>Cantidad CFDI´s</th> ";
            $c .= "<th>Precio U. Compra</th>";
            $c .= "<th>Costo de Proveedor CFDI</th>";
            $c .= "<th>Precio U. Venta</th>";
            $c .= "<th>Total CFDI´s </th>";
			$c .= "<th>Sub CFDI´s</th>";
			$c .= "<th>IVA CFDI´s</th>";
            $c .= "<th>Medio de Pago</th>";
            $c .= "<th>Comisión Método P(costo)</th>";
            $c .= "<th>Comisión Método P(ingreso)</th>";
            $c .= "<th>Margen de utilidad</th>";
	    	$c .= "</tr>";
	    	$c .= "</thead>";
	    	$c .= "<tbody>";

	    	$data = $oRDPN->fetchAll();
			for($i=0;$i<count($data);$i++){
                               
                
                $nCostoFolios = (float)$data[$i]['nCostoFolios'];
                $nCostoMetodo = (float)$data[$i]['nCostoMetodo'];
                $nCostoMetodoPago = $nCostoMetodo;

				$d .= "<tr>";
				$d .= "<td>".$data[$i]['dFechaCompra']."</td>";
				$d .= "<td>".$data[$i]['sRazonSocial']."</td>";
				$d .= "<td>".$data[$i]['sRFC']."</td>";
				$d .= "<td align='center'>".$data[$i]['nCantidadFolios']."</td>";
				$d .= "<td align='center'>".number_format($data[$i]['nPrecioCompra'],2)."</td>";
				$d .= "<td align='center'>".number_format($data[$i]['costoProveedorCFDI'],2)."</td>";
				$d .= "<td align='center'>".number_format($data[$i]['nPrecioVenta'],2)."</td>";
				$d .= "<td align='center'>".number_format($data[$i]['nCostoFolios'],2)."</td>";
				$d .= "<td align='center'>".number_format($data[$i]['su_cfdi'],2)."</td>";
				$d .= "<td align='center'>".$data[$i]['iva_cfdi']."</td>";
				$d .= "<td align='center'>".$data[$i]['sMetodoPago']."</td>";
                

                if($data[$i]['nIdMedioPago'] ==1){
                    $nCostoMetodoPago =  $nCostoFolios * $nCostoMetodo;
                }

				// $nCostoMetodoPago = 5.00;

				$d .= "<td align='center'>".$nCostoMetodoPago."</td>";
				$d .= "<td align='center'>".number_format($data[$i]['nComision'],2)."</td>";
				$margenUtilidad = number_format((($data[$i]['nCostoFolios'] - $data[$i]['costoProveedorCFDI']) + ($data[$i]['nComision'] - $data[$i]['nCostoMetodo'])),2);
				$d .= "<td align='center'>".$margenUtilidad."</td>";
		


				$d .= "</tr>";

				$sumaCantidadTotal += $data[$i]['nCantidadFolios'];
				$sumaCostoProveedor += $data[$i]['costoProveedorCFDI'];
				$sumcostoProveedorCFDI += $nCostoFolios;

				$summargenUtilidad += $margenUtilidad;
				$sumSubTotal += $data[$i]['su_cfdi'];
				$sumIVACFDI += $data[$i]['iva_cfdi'];
				$sumCostoComision += $nCostoMetodoPago;
				$sumIngresoComision += $data[$i]['nComision'];
			}
            $d .= '<tr style=" background-color: #b7b7d4; font-weight:bold">
			<td colspan="2"></td>
			<td align="left">Total</td>
			<td align="center">$'.$sumaCantidadTotal.'</td>
			<td align="center">  --</td>
			<td align="center">$'.$sumaCostoProveedor.'</td>
			<td align="center">  --</td>
			<td align="center">$'.number_format($sumcostoProveedorCFDI,2).'</td>
			<td align="center">$'.$sumSubTotal.'</td>
			<td align="center">$'.$sumIVACFDI.'</td>
			
			<td align="center">  --</td>
			
			<td align="center">$'.$sumCostoComision.'</td>
			<td align="center">$'.$sumIngresoComision.'</td>
			
			<td align="center">$'.number_format($summargenUtilidad,2).'</td>';
			$d .= "</tbody>";
			$d .= "</table>";
			echo $c;
			echo utf8_encode($d);

			$oRDPN->closeStmt();
			$totalDatos = $oRDPN->foundRows();
			$oRDPN->closeStmt();
	    }else{
	    	echo "Lo sentimos, no se han encontrado registros para su consulta";
	    }		
	}	
?>
