<?php
  include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
  require_once($_SERVER['DOCUMENT_ROOT']."/inc/lib/dompdf/dompdf_config.inc.php");
  header('content-Type: text/htmml; charset=UTF-8');
   
    $_ExportPdf     = !empty($_POST["h_ExportPdf"])? $_POST["h_ExportPdf"]:0;
    $_ExportExcel   = !empty($_POST["h_ExportExcel"])? $_POST["h_ExportExcel"]:0;
    
    $_nIdProveedor  = !empty($_POST["h_nIdProveedor"])? $_POST["h_nIdProveedor"]:0;
    $_nIdEstatus    = !empty($_POST["h_nIdEstatus"])? $_POST["h_nIdEstatus"]:-1;
    $_dMes          = !empty($_POST["h_Mes"])? $_POST["h_Mes"]:0;
    $_dYear         = !empty($_POST["h_Year"])? $_POST["h_Year"]:0;

//    $_nIdEstatus = ($_POST["cmbEstatus"] == 0 ? 0 : $_nIdEstatus);
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    
    $valorMes = $meses[($_dMes - 1)];
    $oRDPN->setBDebug(1);
    $oReporte = new PC_ReporteFacturas($_nIdProveedor,$_nIdEstatus,$_dMes,$_dYear,$oRDPN);
  
    $resultado = $oReporte->GetAll();
    if(!$resultado['bExito'] || $resultado['nCodigo'] != 0 || $resultado['num_rows'] == 0){
      $aaData = array();
    }
    else{
      $aaData = $resultado['data'];
    }

    $header= array("Razon Social","Nombre Comercial","Estatus","Operaciones","Monto a facturar");//titulos
    $sum =0; 
    $colors = '';
    $i = 0;

    $reportehtml .= '<table width="100%" style="font-family: Arial, Helvetica, sans-serif;" id="ordenes">';
    $reportehtml .= '<tr>
                    <td colspan="5" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                        <td rowspan="2" colspan="3" align="left"><span style="font-weight:bold;"></span></td>
                        <td colspan="2" align="right"><span style="font-weight:bold;font-size:15px;">Red Efectiva S.A. de C.V.</span></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><span style="font-size:13px;">Blvd. Antonio L. Rdz 3058 Suite 201-A</span></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="left" style=""><span style="font-weight:bold;">REPORTE DE FACTURAS DE COMISONES PAYNAU</span></td><td colspan="3" align="right"><span style="font-size:13px;">Colonia Santa Maria</span></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td><td colspan="2" align="right"><span style="font-size:13px;">Monterrey, N.L. C.P. 64650</span></td>
                    </tr>
                    <tr>
                        <td colspan="3"><span style="font-weight:bold;">Periodo del mes </span><span id="fechaInicial" style="font-weight:bold;">'.$valorMes.'</span> <span style="font-weight:bold;">del </span> <span id="fechaFinal" style="font-weight:bold;">'.$_dYear.'</span></td>
                    </tr>
                    <tr>
                    <td colspan="5" align="left"><span style="font-weight:bold;">Resumen De la operaciones de una factura</span></td>
                    </tr>';
    $reportehtml .= '<tr style="font-size:9px; font-family: Arial, Helvetica, sans-serif; color: #ffffff; background-color: #2c2b2b; ">';
      foreach($header as $valor ) {
        $reportehtml .='<th>'.$valor.'</th>';
      }               
      $reportehtml .= '</tr> '; 

      foreach ($aaData as $DATA){
            $sum += str_replace(',', '', $DATA['nMontoFactura']);
            $sEstats = $DATA['nIdEstatus'] == 1 ? "pendiente" : "Liberada";
             if (0 == $i % 2) {
                $colors = "background-color:#ffffff;";
            }else{
                $colors = "background-color:#d6e1ff;";
            }
            $i++;
            
          $reportehtml .= '    <tr style="font-size:11px;'.$colors.'">
                            <td>'.utf8_encode($DATA['sNombre']).'</td>
                            <td align="center">'.utf8_encode($DATA['sNombreComercial']).'</td>
                            <td align="center">'.$sEstats.'</td>
                            <td align="center">'.$DATA['nOperaciones'].'</td>
                            <td align="center">'.$DATA['nMontoFactura'].'</td>
                        </tr>';   
            

                }
            
            $reportehtml .= '    <tr style="font-size:12px; font-family: Arial, Helvetica, sans-serif; color: #ffffff; background-color: #2c2b2b; font-weight:bold">
                            <td colspan="1" align="right" >TOTAL:</td>
                           <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="center">$'.number_format($sum,2).'</td>
                          
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
    header("Content-disposition:attachment;filename=ReporteFacturasDeComisones.xls");
    header("Pragma:no-cache");
    header("Expires:0");

    echo utf8_encode($reportehtml);
}
?>