<?php
$APP_ROOT_DIRECTORY = $_SERVER['DOCUMENT_ROOT'];

require($APP_ROOT_DIRECTORY."/inc/config.inc.php");
require($APP_ROOT_DIRECTORY."/inc/session2.ajax.inc.php");
require($APP_ROOT_DIRECTORY."/inc/customFunctions.php");

$nType = $_POST['nType'];
$dDate = $_POST['dDate'];
$nIdCliente = ($_POST['nIdCliente'] == '' || $_POST['nIdCliente'] == 'null') ? null : $_POST['nIdCliente'];

/**
 * case 1: Obtiene la contratos que estan por vencer
 * case 2: Exporta la información a Excel de lo contratos apunto de vencer
 */

function encodingString ($string) {
    return mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
}

switch ($nType) {
    case 1: 
        $array_params = array(
            array('name' => 'CkdDate', 'value' => $dDate, 'type' => 's'),
            array('name' => 'CknIdCliente', 'value' => $nIdCliente, 'type' => 'i')
        );

        $oRdb->setSDatabase('redefectiva');
        $oRdb->setSStoredProcedure('sp_select_revision_contratos_clientes');
        $oRdb->setParams($array_params);
        $result = $oRdb->execute();

        $datos = array();
        $sMessage = 'No se puedo obtener la información de los contratos';

        if ($result['nCodigo'] == 0) {
            $rows = $oRdb->fetchAll();
            $sMessage = 'No hay información de los contratos';

            if (count($rows) > 0) {
                $sMessage = 'Se obtuvo la información de los contratos correctamente';

                foreach ($rows as $key => $row) {
                    $datos[$key]['nIdCliente'] = $row['nIdCliente'];
                    $datos[$key]['sRFC'] = $row['sRFC'];
                    $datos[$key]['sNombreCliente'] = utf8_encode($row['sNombreCliente']);
                    $datos[$key]['nIdCadena'] = $row['nIdCadena'];
                    $datos[$key]['sNombreCadena'] = utf8_encode($row['sNombreCadena']);
                    $datos[$key]['dFechaContrato'] = $row['dFechaContrato'];
                    $datos[$key]['dFecRenovacion'] = $row['dFecRenovacion'];
                }
            }
        }

        echo json_encode(array(
            'bExito' => $result['bExito'],
            'nCodigo' => $result['nCodigo'],
            'data' => $datos,
            'sMessage' => $sMessage
        ));
    break;
    case 2:
        echo pack("CCC",0xef,0xbb,0xbf);

        $array_params = array(
            array('name' => 'CkdDate', 'value' => $dDate, 'type' => 's'),
            array('name' => 'CknIdCliente', 'value' => $nIdCliente, 'type' => 'i')
        );

	    $oRdb->query('SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci');
        $oRdb->setSDatabase('redefectiva');
        $oRdb->setSStoredProcedure('sp_select_revision_contratos_clientes');
        $oRdb->setParams($array_params);
        $result = $oRdb->execute();

        $tabla = '<table border="1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="5" style="text-align: center;">Revisi&oacute;n de contratos</th>
                    </tr>
                    <tr>
                        <th>Cliente</th>
                        <th>RFC</th>
                        <th>Cadena</th>
                        <th>Fecha contratro</th>
                        <th>Fecha renovaci&oacute;n</th>
                </tr>
            </thead>
            <tbody>
        ';

	    if($result['nCodigo'] == 0){
		    $rows = $oRdb->fetchAll();

            if (count($rows) > 0) {
                foreach($rows as $key => $row){
                    $tabla .= '<tr>
                        <td>'.encodingString($row['sNombreCliente']).'</td>
                        <td>'.$row['sRFC'].'</td>
                        <td>'.encodingString($row['sNombreCadena']).'</td>
                        <td>'.$row['dFechaContrato'].'</td>
                        <td>'.$row['dFecRenovacion'].'</td>
                    </tr>';
                }
            } else {
                $tabla .= '<tr><td colspan="5">No se encontrar&oacute;n contratos.</td></tr>';
            }
        }
        else{
            // $errmsg = $oReporte->GetErrorCode.' : '.$oReporte->GetErrorMsg();
        }

        $tabla .= '</tbody></table>';

        header("Content-Type: application/octet-stream; charset=UTF-8");
        header("Content-Disposition: attachment;filename=\"Revisión de contratos.xls\"");

        echo utf8ize($tabla);
    break;
}