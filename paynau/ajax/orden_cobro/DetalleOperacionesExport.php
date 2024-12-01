<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");



if ($_POST){
	
	$nId=!empty($_POST["h_cmbClientes"])? $_POST["h_cmbClientes"]:0;
    $tipoReporte=!empty($_POST["h_tipoReporte"])? $_POST["h_tipoReporte"]:0;
    $fechaInicio=!empty($_POST["h_dFechaInicio"])? $_POST["h_dFechaInicio"]:'0000-00-00';
	$exportExcel=!empty($_POST["h_ExportExcel"])? $_POST["h_ExportExcel"]:0;

	$sumMovimientos=0;
	$sumImporte=0;
	$sumComision=0;
	$sumTrasferencia=0;
	$sumNeto=0;
		
		$array_params = array(
			array(
				'name'	=> 'p_dFecha',
				'type'	=> 's',
				'value'	=> $fechaInicio
			),
			array(
				'name'	=> 'p_nId',
				'type'	=> 'i',
				'value'	=> $nId
			)
		);
			
		$reporte=array(1=>'sp_select_detalle_corte_metodo_pago',2=>'sp_select_detalle_corte_proveedor');
		$t=$_POST['h_tipoReporte'];
		$oRDPN->setSDatabase('paycash_one');
		$oRDPN->setSStoredProcedure($reporte[$t]);
		$oRDPN->setParams($array_params);

		$result = $oRDPN->execute();
		$data = $oRDPN->fetchAll();
		$data =utf8ize($data);
			
		$titulo=array(1=>'Metodo de Pago',2=>'Proveedores');

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
				<td colspan="12"><span style="font-weight:bold;">Periodo de </span><span id="fechaInicial" style="font-weight:bold;">'.$fechaInicio.'</span> <span style="font-weight:bold;">a</span> <span id="fechaFinal" style="font-weight:bold;">'.$fechaInicio.'</span></td>
			</tr>
			<tr>
			<td colspan="12" align="left"><span style="font-weight:bold;">Resumen De Movimientos</span></td>
			</tr>
			<tr style="background-color: #b7b7d4; ">
				 <td align="center">Folio</td>
                 <td align="center">Proveedor</td>
                 <td align="center">Metodo de Pago</td>
                 <td align="center">Monto</td>
                 <td align="center">Comision</td>
                 <td align="center">Fecha</td>
                 <td align="center">Hora</td>
			</tr>';
			foreach ($data as $value) {

				$sumMovimientos+=1;
				$sumImporte+=$value['nMonto'];
				$sumComision+=$value['nComision'];
				if (0 == $i % 2) {
                	$colors = "background-color:#ffffff;";
            	}else{
                	$colors = "background-color:#d6e1ff;";
            	}
				$i++;

				$reporte .= '    <tr style="'.$colors.'">
				<td align="center" >'.utf8_encode($value['nIdFolio']).'</td>
				<td align="center">'.utf8_encode($value['sNombreComercial']).'</td>
				<td align="center">'.utf8_encode($value['sMetodo']).'</td>
				<td align="right">$ '.$value['nMonto'].'</td>
				<td align="right" >$'.$value['nComision'].'</td>
				<td align="right">'.$value['dFecha'].'</td>
				<td align="right">'.$value['dHora'].'</td>
			</tr>';   
			}

			$reporte .= '<tr style=" background-color: #b7b7d4; font-weight:bold">
			<td align="center">Total</td>
			<td align="right">&nbsp;</td>
			<td align="center"></td>
			<td align="right">$'.number_format($sumImporte,2).'</td>
			<td align="right">$'.number_format($sumComision,2).'</td>
			<td align="right"></td>
			<td align="right"></td>
			</tr>
			</table>
			';     


			header("Content-type=application/x-msdownload");
			header("Content-disposition:attachment;filename=ReporteOperaciones.xls");
			header("Pragma:no-cache");
			header("Expires:0");
			echo utf8_encode($reporte);

		
	}
