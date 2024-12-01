<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/inc/lib/dompdf/dompdf_config.inc.php");
	
	$fechaIni = !empty($_POST['fechaIni_pdf']) ? $_POST['fechaIni_pdf']: '' ;
	$fechaFin = !empty($_POST['fechaFin_pdf']) ? $_POST['fechaFin_pdf']: '' ;
	$nIdProveedor = !empty($_POST["nIdProveedor_pdf"]) ? $_POST["nIdProveedor_pdf"]: 0 ;
	
	if ($nIdProveedor > 0) {
		$Emisor = 'POR PROVEEDOR';
	}
	elseif ($nIdEmpresa > 0) {
		$Emisor = 'POR EMPRESA';		
	}
	else{
		$Emisor = 'GENERAL';
	}


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
	    	$c = "<table width='100%'  cellpadding='0' cellspacing='0' align='center'>";
	    	$c .= "<thead>";
	    	$c .= "<tr><th colspan='12'>RED EFECTIVA, S.A. DE C.V</th></tr>";
	    	$c .= "<tr><th colspan='12'>Reporte del Sistema: PayNau</th></tr>";
	    	$c .= "<tr><th colspan='12'>REPORTE DE OPERACIONES POR VENTA DE FOLIOS (".$Emisor.")</th></tr>";
	    	$c .= "<tr><th colspan='12'>PERIODO DE: $fechaIni AL $fechaFin</th></tr>";
	    	$c .= "<tr><th></th></tr>";
	    	$c .= "<tr style='background-color: #b7b7d4;'>";
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
                               
                if (0 == $i % 2) {
                	$colors = "background-color:#ffffff;";
            	}else{
                	$colors = "background-color:#d6e1ff;";
            	}

                $nCostoFolios = (float)$data[$i]['nCostoFolios'];
                $nCostoMetodo = (float)$data[$i]['nCostoMetodo'];
                $nCostoMetodoPago = $nCostoMetodo;

				$d .= "<tr style='".$colors."'>";
				$d .= "<td>".$data[$i]['dFechaCompra']."</td>";
				$d .= "<td>".utf8_encode($data[$i]['sRazonSocial'])."</td>";
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
			// echo $c;
			// echo utf8_encode($d);

			$oRDPN->closeStmt();
			$totalDatos = $oRDPN->foundRows();
			$oRDPN->closeStmt();
			
			$reporte = utf8_decode($c.$d);
			$dompdf = new DOMPDF();
					$dompdf->load_html($reporte);
					$dompdf->set_paper('A4', 'landscape');

					$dompdf->render();

					$canvas = $dompdf->get_canvas(); 
					$font = Font_Metrics::get_font("helvetica", "bold"); 
					$canvas->page_text(734, 18, date('Y-m-d'), $font, 10, array(0,0,0)); 

					$canvas->page_text(50, 560, "_____________________________________________________________________________________________________________________________________", $font, 10, array(0,0,0)); 
					$canvas->page_text(750, 580, "Pág. {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0)); 
					$canvas->page_text(50, 580, "Copyright © 2017 - Red Efectiva", $font, 10, array(0,0,0)); //footer
					$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
	    }else{
	    	echo "Lo sentimos, no se han encontrado registros para su consulta";
	    }		
	}	
?>
