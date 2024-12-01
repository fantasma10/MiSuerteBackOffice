<?php
  include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
  require_once($_SERVER['DOCUMENT_ROOT']."/inc/lib/dompdf/dompdf_config.inc.php");


    $_nIdEmisor=!empty($_POST["h_nIdEmisor"])? $_POST["h_nIdEmisor"]:0;
    $_estatus=!empty($_POST["h_nIdEstatus"])? $_POST["h_nIdEstatus"]:-1;
    $_FechaInicio=!empty($_POST["h_dFechaInicio"])? $_POST["h_dFechaInicio"]:'0000-00-00';
    $_FechaFin=!empty($_POST["h_dFechaFin"])? $_POST["h_dFechaFin"]:'0000-00-00';
    $_ExportPdf=!empty($_POST["h_ExportPdf"])? $_POST["h_ExportPdf"]:0;
    $_ExportExcel=!empty($_POST["h_ExportExcel"])? $_POST["h_ExportExcel"]:0;
  
    $oRDPN->setBDebug(1);

    $oReporte = new PC_OrdenesPagoAyddo($_nIdEmisor,$_estatus,$_FechaInicio,$_FechaFin,$oRDPN);
  
    $resultado = $oReporte->GetAll();

    if(!$resultado['bExito'] || $resultado['nCodigo'] != 0 || $resultado['num_rows'] == 0){
      $aaData = array();
    }
    else{
      $aaData = $resultado['data'];
    }

    $header=$oReporte->pc_attribute;//titulos
    $sum =0; 
    $colors = '';
    $i = 0;

    $reportehtml .= '<table width="100%" style="font-family: Arial, Helvetica, sans-serif;" id="ordenes">';
    $reportehtml .= '<tr>
                    <td colspan="5" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                        <td rowspan="2" colspan="9" align="left"><span style="font-weight:bold;"></span></td>
                        <td colspan="2" align="right"><span style="font-weight:bold;font-size:15px;">Red Efectiva S.A. de C.V.</span></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><span style="font-size:13px;">Blvd. Antonio L. Rdz 3058 Suite 201-A</span></td>
                    </tr>
                    <tr>
                        <td colspan="9" align="left" style=""><span style="font-weight:bold;">REPORTE ORDENES DE PAGO</span></td><td colspan="2" align="right"><span style="font-size:13px;">Colonia Santa Maria</span></td>
                    </tr>
                    <tr>
                        <td colspan="9"></td><td colspan="2" align="right"><span style="font-size:13px;">Monterrey, N.L. C.P. 64650</span></td>
                    </tr>
                    <tr>
                        <td colspan="5"><span style="font-weight:bold;">Periodo de </span><span id="fechaInicial" style="font-weight:bold;">'.$_FechaInicio.'</span> <span style="font-weight:bold;">a</span> <span id="fechaFinal" style="font-weight:bold;">'.$_FechaFin.'</span></td>
                    </tr>
                    <tr>
                    <td colspan="6" align="left"><span style="font-weight:bold;">Resumen De Movimientos</span></td>
                    </tr>';
    $reportehtml .= '<tr style="font-size:9px; font-family: Arial, Helvetica, sans-serif; color: #ffffff; background-color: #2c2b2b; ">';
      foreach($header as $valor ) {
        $reportehtml .='<th>'.$valor.'</th>';
      }               
      $reportehtml .= '</tr> '; 

      foreach ($aaData as $DATA){
          $sum += str_replace(',', '', $DATA['nTotal']);
            
             if (0 == $i % 2) {
                $colors = "background-color:#ffffff;";
            }else{
                $colors = "background-color:#d6e1ff;";
            }
            $i++;
            
          $reportehtml .= '    <tr style="font-size:11px;'.$colors.'">
                            <td>'.$DATA['dFecProcesamiento'].'</td>
                            <td align="center">'.$DATA['dFechaPago'].'</td>
                            <td align="center">'.$DATA['nIdTipoPago'].'</td>
                            <td align="right">'.$DATA['sCtaOrigen'].'</td>
                            <td align="center">'.$DATA['sCtaBen'].'</td>
                            <td align="center">'.$DATA['nMonto'].'</td>
                            <td align="center">'.$DATA['nCargo'].'</td>
                            <td align="center">'.$DATA['nImporteTransferencia'].'</td>
                            <td align="center">'.$DATA['nTotal'].'</td>
                            <td align="center">'.utf8_encode($DATA['sBeneficiario']).'</td>
                            <td align="center">'.utf8_encode($DATA['sCorreoDestino']).'</td>
                        </tr>';   
            

                }
            
            $reportehtml .= '    <tr style="font-size:12px; font-family: Arial, Helvetica, sans-serif; color: #ffffff; background-color: #2c2b2b; font-weight:bold">
                            <td colspan="3" align="right" >TOTAL:</td>
                           <td align="right"></td>
                           <td align="right"></td>
                           <td align="right"></td>
                           <td align="right"></td>
                           <td align="right"></td>
                            <td align="right">$'.number_format($sum,2).'</td>
                            <td align="right"></td>
                            <td align="right"></td>
                          
                        </tr>';     
                
            $reportehtml .=  '</table>';
            
    
if ($_ExportPdf==1)
{
  $dompdf = new DOMPDF();
  $dompdf->load_html($reportehtml);
  $dompdf->set_paper('A4', 'landscape');

  $dompdf->render();

  $canvas = $dompdf->get_canvas(); 
  $font = Font_Metrics::get_font("helvetica", "bold"); 
  $canvas->page_text(734, 18, date('Y-m-d'), $font, 10, array(0,0,0)); 

  $canvas->page_text(50, 560, "_____________________________________________________________________________________________________________________________________", $font, 10, array(0,0,0)); 
  $canvas->page_text(750, 580, "Pág. {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0)); 
  $canvas->page_text(50, 580, "Copyright © 2017 - Red Efectiva", $font, 10, array(0,0,0)); //footer
  $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
}elseif ($_ExportExcel==1)
   {
    header("Content-type=application/x-msdownload");
    header("Content-disposition:attachment;filename=ReportePago.xls");
    header("Pragma:no-cache");
    header("Expires:0");

    echo utf8_encode($reportehtml);
}
?>