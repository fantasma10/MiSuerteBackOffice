<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
  require_once($_SERVER['DOCUMENT_ROOT']."/inc/lib/dompdf/dompdf_config.inc.php");

$pdf_hExport     = !empty($_POST["pdf_hExport"])? $_POST["pdf_hExport"]:0;
$excel_hExport   = !empty($_POST["excel_hExport"])? $_POST["excel_hExport"]:0;



if ($pdf_hExport == 1) {
	$setnNumCuenta = !empty($_POST["pdf_hnCuenta"])? $_POST["pdf_hnCuenta"]:0;
	$NombreCadena = !empty($_POST["pdf_NombreCadena"])? $_POST["pdf_NombreCadena"]:0;
	$setdFechaInicio = !empty($_POST["pdf_hfecha1"])? $_POST["pdf_hfecha1"]:0;
	$setdFechaFinal = !empty($_POST["pdf_hfecha2"])? $_POST["pdf_hfecha2"]:0;
}
if ($excel_hExport == 1) {
	$setnNumCuenta = !empty($_POST["excel_hnCuenta"])? $_POST["excel_hnCuenta"]:0;
	$NombreCadena = !empty($_POST["excel_NombreCadena"])? $_POST["excel_NombreCadena"]:0;
	$setdFechaInicio = !empty($_POST["excel_hfecha1"])? $_POST["excel_hfecha1"]:0;
	$setdFechaFinal = !empty($_POST["excel_hfecha2"])? $_POST["excel_hfecha2"]:0;
}
                $param = array
                (    
                    array(
                    'name'  => 'Ck_nNumCuenta',
                    'type'  => 's',
                    'value' => $setnNumCuenta),
                    array(
                    'name'  => 'Ck_dFechaInicio',
                    'type'  => 's',
                    'value' => $setdFechaInicio),
                    array(
                    'name'  => 'Ck_dFechaFinal',
                    'type'  => 's',
                    'value' => $setdFechaFinal),
					array(
					'name'  => 'nIdEstatus',
					'type'  => 'i',
					'value' => '1'),
                    array(
                    'name'  => 'nIdTipoCobro',
                    'type'  => 'i',
                    'value' => '1'),
					array(
					'name'  => 'nIdTipoMovimiento',
					'type'  => 'i',
					'value' => '0'),
                    array(
                    'name'  => 'str',
                    'value' => '',
                    'type'  => 's'),
                    array(
                    'name'  => 'start',
                    'value' => '0',
                    'type'  => 'i'),
                    array(
                    'name'  => 'limit',
                    'value' => '50000',
                    'type'  => 'i'),
                    array(
                    'name'  => 'sortCol',
                    'value' => '2',
                    'type'  => 'i'),
                    array(
                    'name'  => 'sortDir',
                    'value' => 'DESC',
                    'type'  => 's')
                );
                $oRAMP->setSDatabase('redefectiva');
                $oRAMP->setSStoredProcedure('sp_select_movimientos_credito');
                $oRAMP->setParams($param);
                
                $result2 = $oRAMP->execute();
       		$data['data'] = $oRAMP->fetchAll();
       		$oRAMP->closeStmt();
			$colors = '';
			$i = 0;
			$reporte='<table  width="100%"  cellpadding="0" id="reporte" cellspacing="0" align="center">
			
			<tr>
			<td colspan="12" align="center"><span style="font-weight:bold;">Reporte de </span><span id="nombreEmisor" style="font-weight:bold;">Corte diario en el Forelo</span></td>
			</tr>
			<tr>
				<td rowspan="2" colspan="9" align="left"><span style="font-weight:bold;"></span></td>
				<td colspan="3" align="right"><span style="font-weight:bold;font-size:15px;">Red Efectiva S.A. de C.V.</span></td>
			</tr>
			<tr>
				<td colspan="3" align="right"><span style="font-size:13px;">Blvd. Antonio L. Rdz 3058 Suite 201-A</span></td>
			</tr>
			<tr>
				<td colspan="9" align="left" style=""><span style="font-weight:bold;">Corte diario en el Forelo</span></td>
				<td colspan="3" align="right"><span style="font-size:13px;">Colonia Santa Maria</span></td>
			</tr>
			<tr>
				<td colspan="9" align="left" style="font-weight:bold;">Nombre Comercial: '.$NombreCadena.'</td>
				<td colspan="3" align="right"><span style="font-size:13px;">Monterrey, N.L. C.P. 64650</span></td>
			</tr>
			<tr>
				<td colspan="12"><span style="font-weight:bold;">Fecha: '.date('d/m/Y').'</td>
			</tr>
			<tr>
			<td colspan="12" align="left"><span style="font-weight:bold;">Datos</span></td>
			</tr>
			
			<tr style="background-color: #b7b7d4; ">
				<td align="center">Fecha</td>
				<td align="center">Saldo Inicial</td>
				<td align="center">Salida</td>
				<td align="center">Entrada</td>
				<td align="center">Saldo Final</td>
			</tr>';
			foreach (utf8ize($data['data']) as $value) {
				if (0 == $i % 2) {
                	$colors = "background-color:#ffffff;";
            	}else{
                	$colors = "background-color:#d6e1ff;";
            	}
				$i++;
				$reporte .= '<tr style="'.$colors.'">
								<td align="center">'.$value['fecAppMov'].'</td>
								<td align="center">$ '.number_format($value['saldoInicial'],'2',".",",").'</td>
								<td align="center">$ '.number_format($value['cargoMov'],'2','.',',').'</td>
								<td align="center">$ '.number_format($value['abonoMov'],'2','.',',').'</td>
								<td align="center">$ '.number_format($value['saldoFinal'],'2','.',',').'</td>
							</tr>';
			}
			$reporte .= '</table>';     

if ($pdf_hExport==1)
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
}elseif ($excel_hExport==1){
					
					header("Content-type=application/x-msdownload");
					header("Content-disposition:attachment;filename=CortediarioenelForelo.xls");
					header("Pragma:no-cache");
					header("Expires:0");
					echo utf8_decode($reporte);
}