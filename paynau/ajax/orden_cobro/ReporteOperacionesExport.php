<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
require_once($_SERVER['DOCUMENT_ROOT']."/inc/lib/dompdf/dompdf_config.inc.php");



if ($_POST){
	
	$nId=!empty($_POST["h_cmbClientes"])? $_POST["h_cmbClientes"]:0;
    $tipoReporte=!empty($_POST["h_tipoReporte"])? $_POST["h_tipoReporte"]:0;
    $fechaInicio=!empty($_POST["h_dFechaInicio"])? $_POST["h_dFechaInicio"]:'0000-00-00';
    $fechaFin=!empty($_POST["h_dFechaFin"])? $_POST["h_dFechaFin"]:'0000-00-00';
    $exportPdf=!empty($_POST["h_ExportPdf"])? $_POST["h_ExportPdf"]:0;
	$exportExcel=!empty($_POST["h_ExportExcel"])? $_POST["h_ExportExcel"]:0;
	$sumMovimientos=0;
	$sumImporte=0;
	$sumComision=0;
	$sumTrasferencia=0;
	$sumNeto=0;
		$array_params = array(
			array(
				'name'	=> 'p_nId',
				'type'	=> 'i',
				'value'	=> $nId
			),
			array(
				'name'	=> 'p_dFechaInicio',
				'type'	=> 's',
				'value'	=> $fechaInicio
			),
			array(
				'name'	=> 'p_dFechaFin',
				'type'	=> 's',
				'value'	=> $fechaFin
			)
			);
			$reporte=array(1=>'sp_select_metodo_pago_operaciones',2=>'sp_select_proveedor_operaciones');
			$titulo=array(1=>'Integradores',2=>'Proveedores');
			$oRDPN->setSDatabase('paycash_one');
			$oRDPN->setSStoredProcedure($reporte[$tipoReporte]);
			$oRDPN->setParams($array_params);

			$result = $oRDPN->execute();

			$data = $oRDPN->fetchAll();

			$colors = '';
			$i = 0;
			$reporte='<table  width="100%"  cellpadding="0" id="reporte" cellspacing="0" align="center">
			<tr>
			<td colspan="12" align="center"><span style="font-weight:bold;">Reporte Para </span><span id="nombreEmisor" style="font-weight:bold;">'.$titulo[$tipoReporte].' </span></td>
			</tr>
			<tr>
				<td rowspan="2" colspan="9" align="left"><span style="font-weight:bold;"></span></td>
				<td colspan="3" align="right"><span style="font-weight:bold;font-size:15px;">Red Efectiva S.A. de C.V.</span></td>
			</tr>
			<tr>
				<td colspan="3" align="right"><span style="font-size:13px;">Blvd. Antonio L. Rdz 3058 Suite 201-A</span></td>
			</tr>
			<tr>
				<td colspan="9" align="left" style=""><span style="font-weight:bold;">REPORTE DE MOVIMIENTOS</span></td>
				<td colspan="3" align="right"><span style="font-size:13px;">Colonia Santa Maria</span></td>
			</tr>
			<tr>
				<td colspan="9"></td>
				<td colspan="3" align="right"><span style="font-size:13px;">Monterrey, N.L. C.P. 64650</span></td>
			</tr>
			<tr>
				<td colspan="12"><span style="font-weight:bold;">Periodo de </span><span id="fechaInicial" style="font-weight:bold;">'.$fechaInicio.'</span> <span style="font-weight:bold;">a</span> <span id="fechaFinal" style="font-weight:bold;">'.$fechaFin.'</span></td>
			</tr>
			<tr>
			<td colspan="12" align="left"><span style="font-weight:bold;">Resumen De Movimientos</span></td>
			</tr>
			<tr style="background-color: #b7b7d4; ">
				<td align="center" colspan="5">Metodo de pago</td>
				<td align="center">Fecha</td>
				<td align="center">Movimientos</td>
				<td align="center" colspan="2">Importe</td>
				<td align="center">Comision</td>
				<td align="center" colspan="2">Total Neto</td>
			</tr>';

			foreach ($data as $value) {
				$sumMovimientos+=$value['nTotalOperaciones'];
				$sumImporte+=$value['nTotalMonto'];
				$sumComision+=$value['nTotalComision'];
				$sumTrasferencia+=$value['nImporteTrasferencia'];
				$sumNeto+=$value['nTotal'];
				if (0 == $i % 2) {
                	$colors = "background-color:#ffffff;";
            	}else{
                	$colors = "background-color:#d6e1ff;";
            	}
				$i++;
				$reporte .= '    <tr style="'.$colors.'">
				<td align="center" colspan="5">'.utf8_encode($value['sNombre']).'</td>
				<td align="center">'.utf8_encode($value['dFechaOperaciones']).'</td>
				<td align="right">'.$value['nTotalOperaciones'].'</td>
				<td align="right" colspan="2">$'.$value['nTotalMonto'].'</td>
				<td align="right">$'.$value['nTotalComision'].'</td>
				<td align="right" colspan="2">$'.$value['nTotal'].'</td>
			</tr>';   
			}

			$reporte .= '<tr style=" background-color: #b7b7d4; font-weight:bold">
			<td align="center" colspan="5">Total</td>
			<td align="right">&nbsp;</td>
			<td align="center" >'.number_format($sumMovimientos).'</td>
			<td align="right" colspan="2">$'.number_format($sumImporte,2).'</td>
			<td align="right" >$'.number_format($sumComision,2).'</td>
			<td align="right" colspan="2">$'.number_format($sumNeto,2).'</td>
			</tr>
			</table>
			';     

			if ($exportPdf==1)
				{
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
				}elseif ($exportExcel==1)
   					{
					header("Content-type=application/x-msdownload");
					header("Content-disposition:attachment;filename=ReporteOperaciones.xls");
					header("Pragma:no-cache");
					header("Expires:0");
					echo utf8_encode($reporte);
				}
		
	}
