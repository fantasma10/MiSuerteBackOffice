<meta charset='utf-8'>
<?php

  include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
  include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
  include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
  require_once($_SERVER['DOCUMENT_ROOT']."/inc/lib/dompdf/dompdf_config.inc.php");

    $mesBusqueda    =!empty($_POST["h_mesBusqueda"]) ? $_POST["h_mesBusqueda"] : date('Y-m-d');
    $mesString      =!empty($_POST["h_mesString"]) ? $_POST["h_mesString"] : date('M');
    $idProveedor    =!empty($_POST["h_cmbProveedores"]) ? $_POST["h_cmbProveedores"] : 0;
    $_ExportPdf     =!empty($_POST["h_ExportPdf"]) ? $_POST["h_ExportPdf"] : 0;
    $_ExportExcel   =!empty($_POST["h_ExportExcel"]) ? $_POST["h_ExportExcel"] : 0;

    $param = array(
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
    $oRDPN->setSStoredProcedure('sp_select_corte_ordenescobro_reporte');
    $oRDPN->setParams($param);

    $result = $oRDPN->execute();
    $data = $oRDPN->fetchAll();
    $oRDPN->closeStmt();
//    $data = utf8ize($data);

    if(!$resultado['bExito'] || $resultado['nCodigo'] != 0 || $resultado['num_rows'] == 0){
      $aaData = array();
    }
    else{
      $aaData = $resultado['data'];
    }

    $header= array("RFC","Razon Social","No de poperaciones","Monto Total","IVA comision","Total a facturar");//titulos
    $sum =0; 
    $colors = '';
    $i = 0;

    $reportehtml .= '<table width="100%" style="font-family: Arial, Helvetica, sans-serif;" id="ordenes">';
    $reportehtml .= '<tr>
                    <td colspan="5" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                        <td rowspan="2" colspan="4" align="left"><span style="font-weight:bold;"></span></td>
                        <td colspan="2" align="right"><span style="font-weight:bold;font-size:15px;">Red Efectiva S.A. de C.V.</span></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><span style="font-size:13px;">Blvd. Antonio L. Rdz 3058 Suite 201-A</span></td>
                    </tr>
                    <tr>
                        <td colspan="4  " align="left" style=""><span style="font-weight:bold;">REPORTE ORDENES DE COBRO</span></td><td colspan="2" align="right"><span style="font-size:13px;">Colonia Santa Maria</span></td>
                    </tr>
                    <tr>
                        <td colspan="4  "></td><td colspan="2" align="right"><span style="font-size:13px;">Monterrey, N.L. C.P. 64650</span></td>
                    </tr>
                    <tr>
                        <td colspan="5"><span style="font-weight:bold;">Del mes de </span><span id="fechaInicial" style="font-weight:bold;">'.$mesString.'</span></td>
                    </tr>
                    <tr>
                    <td colspan="6" align="left"><span style="font-weight:bold;">Resumen De Movimientos</span></td>
                    </tr>';
    $reportehtml .= '<tr style="font-size:9px; font-family: Arial, Helvetica, sans-serif; color: #ffffff; background-color: #2c2b2b; ">';
      foreach($header as $valor ) {
        $reportehtml .='<th>'.$valor.'</th>';
      }               
      $reportehtml .= '</tr> '; 
      
      foreach ($data as $DATA){
          $sum += str_replace(',', '', $DATA['monto_facturar']);
            
             if (0 == $i % 2) {
                $colors = "background-color:#ffffff;";
            }else{
                $colors = "background-color:#d6e1ff;";
            }
            $i++;
            
        $reportehtml .= '   <tr style="font-size:11px;'.$colors.'">
                                <td>'.$DATA['sRFC'].'</td>
                                <td align="center">'.$DATA['sRazonSocial'].'</td>
                                <td align="center">'.$DATA['num_operaciones'].'</td>
                                <td align="right">'.$DATA['monto_total'].'</td>
                                <td align="center">'.$DATA['iva_comision'].'</td>
                                <td align="center">'.$DATA['monto_facturar'].'</td>
                            </tr>';   
            

                }
        $reportehtml .= '   <tr style="font-size:12px; font-family: Arial, Helvetica, sans-serif; color: #ffffff; background-color: #2c2b2b; font-weight:bold">
                                <td colspan="1" align="right" >Total Requerido:</td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right">$'.number_format($sum,2).'</td>
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