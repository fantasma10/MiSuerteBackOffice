<?php
     
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

$ESTATUSCLIENTE = array (0 => 'Activo', 1 => 'Prealta', 3 => 'Inactivo', 4 => '');

$reportehtml  = '<html style="margin-top: 120px"><body>'; 
$reportehtml .= '<table width="1500px" style="font-family: Arial, Helvetica, sans-serif;">';

$estatus = $_POST["idEstatus"];
$sQuery  = "CALL `redefectiva`.`sp_select_cliente_por_estatus`(".$estatus.");";
$result  = $WBD->query($sQuery);
   
$reportehtml .= '<tr>
                    <td colspan="3" align="center"><span style="font-weight:bold;">Reporte de clientes</span></td>
                    <td colspan="1" align="center"><span style="font-weight:bold;">'.date('d-m-Y').'</span></td>
                </tr>';

$reportehtml .= '<tr style="font-size:12px; font-family: Arial, Helvetica, sans-serif; ">          
                    <th>ID</th>
                    <th width="100px">RFC</th>
                    <th width="150px">RAZON SOCIAL</th>
                    <th width="100px">ESTATUS</th>
                </tr>';  

while($DATA  = mysqli_fetch_array($result)){

    $ID             = $DATA['idCliente'];
    $RFC            = $DATA['RFC'];
    $RAZONSOCIAL    = ($DATA['RazonSocial'] == "")? $DATA['NombreCliente'] : $DATA['RazonSocial'];
    $ESTATUS        = $ESTATUSCLIENTE[$DATA['idEstatus']];

    $reportehtml .= '<tr style="font-size:12px;">
                        <td align="center">'.$ID.'</td>
                        <td>'.$RFC.'</td>
                        <td>'.$RAZONSOCIAL.'</td>
                        <td align="center">'.$ESTATUS.'</td>    
                    </tr>';   
}
            
$reportehtml .= '</table>';

$filename = "MIRED Reporte de Clientes ";
if ($estatus == 0) {
    $filename .= "- Activos ";
}
else if ($estatus == 1) {
    $filename .= "- Inactivos ";
}

$filename .= date('Ymd') . ".xls";

header("Content-Disposition: attachment; filename=\"$filename\"");
//header("Content-Type: application/vnd.ms-excel");
header("Content-type: application/octet-stream");
//header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Transfer-Encoding: binary");

echo $reportehtml;

?>