
    
<?php
        
  include ('../../inc/config.inc.php');
  require_once("../../inc/lib/dompdf/dompdf_config.inc.php");
            

  $corte = $_GET['corte'];



$reportehtml = '<html><body><div style="width:1000px;height:50px; background-color:#e2e2e2;padding-top:1px"><center><p style="font-family: Arial, Helvetica, sans-serif; font-size:16">';
$reportehtml .= 'Autorizaci&oacute;n de Pago de Liquidacion a Pronosticos';
$reportehtml .= '</p>';

$reportehtml .= '</div><br><div style="width:1000px; background-color:#eeeffa;padding-top:1px">';
$reportehtml .= '<table width="100%" style="font-family: Arial, Helvetica, sans-serif;">';
$reportehtml .= '<tr style="font-size:9px; font-family: Arial, Helvetica, sans-serif; color: #ffffff; background-color: #2c2b2b;">';
$reportehtml .= '<th width="10%">ID</th><th width="40%">PROVEEDOR</th><th width="20%">FECHA CORTE</th><th width="30%">TOTAL</th></tr>';

       //var_dump($MRDB);
     //$sQuery =$MRDB->query("CALL `pronosticos`.`sp_select_cortes_proveedor`('$fechaInicio','$fechaFin','1')");
     $sql = $MRDB->query("CALL `pronosticos`.`sp_select_corte_autorizacion`('$corte')");
   
      $sum =0;
        while($DATA  = mysqli_fetch_array($sql)){
            
            $idCorte      = $DATA['nIdCorte'];
            $proveedor    = $DATA['sNombreComercial'];
            $fechaCorte   = $DATA['dFecAlta'];
            $monto    = $DATA['nTotalPago'];           
            
          $sum += str_replace(',', '', $monto);

         $reportehtml .= '<tr style="font-size:11px;"><td>'.$idCorte.'</td><td>'.$proveedor.'</td>
                          <td align="center">'.$fechaCorte.'</td><td align="right">'.$monto.'</td></tr>';
            
            
            
      };

$suma = number_format($sum, 4, '.', ',');

$reportehtml .= '<tr style="font-size:11; background-color:#b7b7d4"><td colspan="6"></td><td colspan="1" align="center" style="font-weight:bolder; font-size:14px;">TOTAL</td><td colspan="1" align="right" style="font-weight:bolder">$'. $suma.'</td></tr>';
$reportehtml .= '</table></div>';

$reportehtml .= '<table style="width:1000px;height:200px;  background-color:white; font-family: Arial, Helvetica, sans-serif; font-size:14px; font-weight:bolder"><tr height="150px"> ';
$reportehtml .= '<td align="center" >______________________________</td> <td align="center" >______________________________</td></tr>';
$reportehtml .= '<tr style=" height:50px"><td align="center">Solicita</td> <td align="center">Autoriza</td>';
$reportehtml .= '</tr></table></html>';

//echo $reportehtml;


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

?>

