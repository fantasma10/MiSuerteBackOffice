<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
require_once($_SERVER['DOCUMENT_ROOT']."/inc/lib/dompdf/dompdf_config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSRE.php");

$pdf_hExport     = !empty($_POST["pdf_hExport"])? $_POST["pdf_hExport"]:0;
$excel_hExport   = !empty($_POST["excel_hExport"])? $_POST["excel_hExport"]:0;



if ($pdf_hExport == 1) {
    $setnstatusCredito = !empty($_POST["pdf_hnstatusCredito"])? $_POST["pdf_hnstatusCredito"]:0;
    $setdfecha1 = !empty($_POST["pdf_hfecha1"])? $_POST["pdf_hfecha1"]:0;
    $setdfecha2 = !empty($_POST["pdf_hfecha2"])? $_POST["pdf_hfecha2"]:0;
}
if ($excel_hExport == 1) {
    $setnstatusCredito = !empty($_POST["excel_hnstatusCredito"])? $_POST["excel_hnstatusCredito"]:0;
    $setdfecha1 = !empty($_POST["excel_hfecha1"])? $_POST["excel_hfecha1"]:0;
    $setdfecha2 = !empty($_POST["excel_hfecha2"])? $_POST["excel_hfecha2"]:0;
}
            // $param = array
            //     (    
            //         array(
            //         'name'  => 'CkdFechaInicio',
            //         'type'  => 's',
            //         'value' => $setdfecha1),
            //         array(
            //         'name'  => 'CkdFechaFinal',
            //         'type'  => 's',
            //         'value' => $setdfecha2),
            //         array(
            //         'name'  => 'CknIdEstatus',
            //         'type'  => 's',
            //         'value' => $setnstatusCredito)    
            //     );  //print_r($param); die();
            //     $oRAMP->setSDatabase('data_AquiMisPagos');
            //     $oRAMP->setSStoredProcedure('sp_select_gestion_creditos');
            //     $oRAMP->setParams($param);
            //     $result2 = $oRAMP->execute();
            //     $data['data'] = $oRAMP->fetchAll();   //print_r($data); die();
            //     $oRAMP->closeStmt();

                // *** WS ***
                    $arrayParametros= array(        
                        'FechaInicio' => $setdfecha1,
                        'FechaFin' => $setdfecha2,
                        'IdEstatus' => $setnstatusCredito
                    ); //print_r($arrayParametros);
                    $respuesta =(array) $client->ObtenerGestionCreditosPorRango($arrayParametros);  //echo "<pre>"; print_r($respuesta);
                    $respuestaListado =(array) $respuesta['ObtenerGestionCreditosPorRangoResult']->Model->anyType;  

                    if( isset($respuestaListado['enc_value']) ){
                        $data['data'][]=(array)$respuestaListado['enc_value'];
                    }else{
                        foreach ( ($respuestaListado) as $key) {
                            $data['data'][]=(array) $key->enc_value;   
                        }
                    }
                    //echo "<pre>"; print_r($data); echo "</pre>";  die();
                // **********

            $colors = '';
            $i = 0;
            $reporte='<table  width="100%"  cellpadding="0" id="reporte" cellspacing="0" align="center">
            <tr>
            <td colspan="12" align="center"><span style="font-weight:bold;">Reporte de </span><span id="nombreEmisor" style="font-weight:bold;">Créditos de los comisionistas</span></td>
            </tr>
            <tr>
                <td rowspan="2" colspan="9" align="left"><span style="font-weight:bold;"></span></td>
                <td colspan="3" align="right"><span style="font-weight:bold;font-size:15px;">Red Efectiva S.A. de C.V.</span></td>
            </tr>
            <tr>
                <td colspan="3" align="right"><span style="font-size:13px;">Blvd. Antonio L. Rdz 3058 Suite 201-A</span></td>
            </tr>
            <tr>
                <td colspan="9" align="left" style=""><span style="font-weight:bold;">Créditos de los comisionistas</span></td>
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
                <td align="center">Fecha Solicitud</td>
                <td align="center">Razón Social / Nombre</td>
                <td align="center">Crédito Otorgado</td>
                <td align="center">Solicitante</td>
                <td align="center">Autorizó </td>
                <td align="center">Estado</td>
            </tr>';
            foreach (utf8ize($data['data']) as $value) {    
                if (0 == $i % 2) {
                    $colors = "background-color:#ffffff;";
                }else{
                    $colors = "background-color:#d6e1ff;";
                }
                $i++;
                $reporte .= '<tr style="'.$colors.'">
                                <td align="center">'.substr($value['FechaSolicitud'],0,10) .'</td>
                                <td align="center">'.($value['RazonSocialNombre']).'</td>
                                <td align="center">'.($value['CreditoOtorgado']).'</td>
                                <td align="center">'.($value['NombreSolicitante']).'</td>
                                <td align="center">'.($value['NombreAutorizo']).'</td>
                                <td align="center">'.($value['Cobrado']).'</td>
                            </tr>';
            }
            $reporte .= '</table>';     

if ($pdf_hExport==1)
{
    $dompdf = new DOMPDF();
    $dompdf->load_html(utf8_decode($reporte));
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
                    header("Content-disposition:attachment;filename=CreditosdelosComisionistas.xls");
                    header("Pragma:no-cache");
                    header("Expires:0");
                    echo utf8_decode($reporte);
}