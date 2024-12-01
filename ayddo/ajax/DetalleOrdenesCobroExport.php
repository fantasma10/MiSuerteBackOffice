<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");


if ($_POST){
	
    $idProveedor    =!empty($_POST["h_cmbProveedores"]) ? $_POST["h_cmbProveedores"] : 0;
    $mesBusqueda    =!empty($_POST["h_mesBusqueda"]) ? $_POST["h_mesBusqueda"] : date('Y-m-d');
    $mesString      =!empty($_POST["h_mesString"]) ? $_POST["h_mesString"] : date('M');
    $exportExcel=!empty($_POST["h_ExportExcel"])? $_POST["h_ExportExcel"]:0;

        $sumMovimientos=0;
	$sumImporte=0;
	$sumComision=0;
	$sumTrasferencia=0;
	$sumNeto=0;
		
		$array_params = array(
                    array(
                        'name'	=> 'P_nidProveedor',
                        'type'	=> 'i',
                        'value'	=> $idProveedor
                    ),
                    array(
                        'name'	=> 'P_fechaInicio',
                        'type'	=> 's',
                        'value'	=> $mesBusqueda
                    )
                );
		$oRDPN->setSDatabase('paycash_one');
		$oRDPN->setSStoredProcedure("sp_select_detalle_ordenes_cobro");
		$oRDPN->setParams($array_params);

		$result = $oRDPN->execute();
		$data = $oRDPN->fetchAll();
		$data =utf8ize($data);
		$titulo=array(1=>'Metodo de Pago',2=>'Proveedores');

			$colors = '';
			$i = 0;
			$reporte='<table  width="100%"  cellpadding="0" id="reporte" cellspacing="0" align="center">
			<tr>
			<td colspan="7" align="center"><span style="font-weight:bold;">Reporte Para </span><span id="nombreEmisor" style="font-weight:bold;">Resumen De Facturas de Comisiones Paynau </span></td>
			</tr>
			<tr>
				<td rowspan="2" colspan="4" align="left"><span style="font-weight:bold;"></span></td>
				<td colspan="3" align="right"><span style="font-weight:bold;font-size:15px;">Red Efectiva S.A. de C.V.</span></td>
			</tr>
			<tr>
				<td colspan="3" align="right"><span style="font-size:13px;">Blvd. Antonio L. Rdz 3058 Suite 201-A</span></td>
			</tr>
			<tr>
				<td colspan="4" align="left" style=""><span style="font-weight:bold;">REPORTE DETALLE DE FACTURAS DE COMISONES PAYNAU</span></td>
				<td colspan="3" align="right"><span style="font-size:13px;">Colonia Santa Maria</span></td>
			</tr>
			<tr>
				<td colspan="4"></td>
				<td colspan="3" align="right"><span style="font-size:13px;">Monterrey, N.L. C.P. 64650</span></td>
			</tr>
			<tr>
				<td colspan="7"><span style="font-weight:bold;">Mes del corte: </span><span id="fechaInicial" style="font-weight:bold;">'.$mesString.'</span></td>
			</tr>
			<tr>
			<td colspan="7" align="left"><span style="font-weight:bold;">Resumen De Facturas de Comisiones Paynau</span></td>
			</tr>
			<tr style="background-color: #b7b7d4; ">
                                <td align="center">Fecha</td>
                                <td align="center">No de orden</td>
                                <td align="center">Monto</td>
                                <td align="center">Forma de pago</td>
                                <td align="center">Comision</td>
                                <td align="center">IVA</td>
                                <td align="center">Total</td>
			</tr>';
			foreach ($data as $value) {

				$sumMovimientos+=1;
				$sumImporte+=$value['nMonto'];
				$sumComision+=$value['nComision'];
				$sumIva+=$value['iva'];
				if (0 == $i % 2) {
                	$colors = "background-color:#ffffff;";
            	}else{
                	$colors = "background-color:#d6e1ff;";
            	}
				$i++;

				$reporte .= '    <tr style="'.$colors.'">
                                        <td align="right">'.$value['dFecha'].'</td>
                                        <td align="center" >'.utf8_encode($value['nIdFolio']).'</td>
                                        <td align="right">$ '.$value['nMonto'].'</td>
                                        <td align="center">'.utf8_encode($value['sMetodo']).'</td>
                                        <td align="right" >$'.$value['nComision'].'</td>
                                        <td align="right" >$'.$value['iva'].'</td>
                                        <td align="right">'.$value['total'].'</td>
                                </tr>';   
			}

			$reporte .= '<tr style=" background-color: #b7b7d4; font-weight:bold">
			<td align="center">Total</td>
			<td align="right">&nbsp;</td>
			<td align="right">$'.number_format($sumImporte,2).'</td>
			<td align="center"></td>
			<td align="right">$'.number_format($sumComision,2).'</td>
			<td align="right">$'.number_format($sumIva,2).'</td>
			<td align="right"></td>
			</tr>
			</table>
			';     


			header("Content-type=application/x-msdownload");
			header("Content-disposition:attachment;filename=DetalleFacturasDeComisiones.xls");
			header("Pragma:no-cache");
			header("Expires:0");
			echo utf8_encode($reporte);

		
	}
