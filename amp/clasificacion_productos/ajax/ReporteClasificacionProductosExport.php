<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

       		$oRAMP->setSDatabase('aquimispagos');
       		$data=array();
       		$oRAMP->setSStoredProcedure('sp_select_clasificacion_producto');
       		$result2 = $oRAMP->execute();
       		$data['data'] = $oRAMP->fetchAll();
			$colors = '';
			$i = 0;
			$reporte='<table  width="100%"  cellpadding="0" id="reporte" cellspacing="0" align="center">
			<tr>
			<td colspan="12" align="center"><span style="font-weight:bold;">Reporte de </span><span id="nombreEmisor" style="font-weight:bold;">Clasificacion de Producto </span></td>
			</tr>
			<tr>
				<td rowspan="2" colspan="9" align="left"><span style="font-weight:bold;"></span></td>
				<td colspan="3" align="right"><span style="font-weight:bold;font-size:15px;">Red Efectiva S.A. de C.V.</span></td>
			</tr>
			<tr>
				<td colspan="3" align="right"><span style="font-size:13px;">Blvd. Antonio L. Rdz 3058 Suite 201-A</span></td>
			</tr>
			<tr>
				<td colspan="9" align="left" style=""><span style="font-weight:bold;">Reporte de Clasificacion del Producto</span></td>
				<td colspan="3" align="right"><span style="font-size:13px;">Colonia Santa Maria</span></td>
			</tr>
			<tr>
				<td colspan="9"></td>
				<td colspan="3" align="right"><span style="font-size:13px;">Monterrey, N.L. C.P. 64650</span></td>
			</tr>
			<tr>
				<td colspan="12"><span style="font-weight:bold;">Fecha: '.date('d/m/Y').'</td>
			</tr>
			<tr>
			<td colspan="12" align="left"><span style="font-weight:bold;">Datos</span></td>
			</tr>
			<tr style="background-color: #b7b7d4; ">
				<td align="center">Edo</td>
				<td align="center">Servicio/Producto</td>
				<td align="center">Comisión Cobrada al Emisor</td>
				<td align="center">Comisión Pagada al comisionista</td>
				<td align="center">Comisión Red Efectiva</td>
				<td align="center">Comisión Cobrada al cliente final</td>
				<td align="center">Clasifica</td>
			</tr>';
			foreach (utf8ize($data['data']) as $value) {
				if (0 == $i % 2) {
                	$colors = "background-color:#ffffff;";
            	}else{
                	$colors = "background-color:#d6e1ff;";
            	}
				$i++;
				$reporte .= '<tr style="'.$colors.'">
								<td align="center">'.$value['statusTexto'].'</td>
								<td align="center">'.($value['sEmisor']).'</td>
								<td align="center">$0.00</td>
								<td align="center">$0.00</td>
								<td align="center">$0.00</td>
								<td align="center">$0.00</td>
								<td align="center">'.$value['TipoClasificacion'].'</td>
							</tr>';
			}
			$reporte .= '</table>';     


					
					header("Content-type=application/x-msdownload");
					header("Content-disposition:attachment;filename=ReporteClasificacionProductos.xls");
					header("Pragma:no-cache");
					header("Expires:0");
					echo utf8_decode($reporte);
