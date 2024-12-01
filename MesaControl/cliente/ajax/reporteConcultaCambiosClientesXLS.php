<?php

include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

$reportehtml  = '<html style="margin-top: 120px"><body>';
$reportehtml .= '<table width="1500px" style="font-family: Arial, Helvetica, sans-serif;">';

$sQuery  = "CALL `redefectiva`.`sp_select_cfg_formulario_actualizaciones`(1);";
$result  = $WBD->query($sQuery);

$reportehtml .= '<tr>
                    <td colspan="3" align="center"><span style="font-weight:bold;">Reporte de modificaciones de clientes</span></td>
                    <td colspan="1" align="center"><span style="font-weight:bold;">'.date('d-m-Y').'</span></td>
                </tr>';

$reportehtml .= '<tr style="font-size:12px; font-family: Arial, Helvetica, sans-serif; ">          
                    <th>ID</th>
                    <th width="100px">RFC</th>
                    <th width="150px">RAZON SOCIAL</th>
                    <th width="100px">TIPO DE CLIENTE</th>
                    <th width="100px">REP. LEGAL Y CONTRATO</th>
                    <th width="100px">LIQUIDACION</th>
                    <th width="100px">FACTURACION</th>
                </tr>';

while($DATA  = mysqli_fetch_array($result)){

    $ID             = $DATA['nIdCliente'];
    $RFC            = $DATA['RFC'];
    $RAZONSOCIAL    = ($DATA['RazonSocial'] == "")? $DATA['NombreCliente'] : $DATA['RazonSocial'];
    $seccion1       = ($DATA['sSeccion1'] !== '{}') ? 'SECCION MODIFICADA' : '';
    $seccion3       = ($DATA['sSeccion3'] !== '{}') ? 'SECCION MODIFICADA' : '';
    $seccion5       = ($DATA['sSeccion5'] !== '{}') ? 'SECCION MODIFICADA' : '';
    $seccion6       = ($DATA['sSeccion6'] !== '{}') ? 'SECCION MODIFICADA' : '';


    $reportehtml .= '<tr style="font-size:12px;">
                        <td align="center">'.$ID.'</td>
                        <td>'.$RFC.'</td>
                        <td>'.$RAZONSOCIAL.'</td>
                        <td>'.$seccion1.'</td>
                        <td>'.$seccion3.'</td>
                        <td>'.$seccion5.'</td>
                        <td>'.$seccion6.'</td>
                    </tr>';
}

$reportehtml .= '</table>';

$filename = "MIRED Reporte de Modificacion de Clientes ";


$filename .= date('Ymd') . ".xls";

header("Content-Disposition: attachment; filename=\"$filename\"");
//header("Content-Type: application/vnd.ms-excel");
header("Content-type: application/octet-stream");
//header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Transfer-Encoding: binary");

echo $reportehtml;

?>