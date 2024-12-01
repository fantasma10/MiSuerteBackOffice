<?php
include($_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/session.ajax.inc.php");

$tipo_consulta = $_POST["tipo"];

$array_params = array(array('name' => 'ck_nTipo', 'value' => $tipo_consulta, 'type' =>'i'));
$oRdb->setSDatabase('redefectiva');
$oRdb->setSStoredProcedure('sp_select_cfg_formulario_actualizaciones');
$oRdb->setParams($array_params);
$result = $oRdb->execute();
$data   = $oRdb->fetchAll();
$oRdb->closeStmt();
$totalDatos = count($data);
$row = array();

switch ($tipo_consulta){
    case 1:
        for($i = 0; $i < $totalDatos; $i++){
            $row[$i]['nIdCliente']  = $data[$i]['nIdCliente'];
            $row[$i]['RFC']         = $data[$i]['RFC'];
            $row[$i]['RazonSocial'] = $data[$i]['RazonSocial'];
            $row[$i]['NombreCliente']  = $data[$i]['NombreCliente'];
            $row[$i]['idEstatus']   = 1;
        }
    break;
    case 2:
        for($i = 0; $i < $totalDatos; $i++){
            $row[$i]['nIdCliente']  = $data[$i]['nIdCliente'];
            $row[$i]['RFC']         = $data[$i]['RFC'];
            $row[$i]['RazonSocial'] = $data[$i]['razonSocial'];
            $row[$i]['NombreProveedor']  = $data[$i]['nombreProveedor'];
            $row[$i]['idEstatus']   = 1;
        }
    break;
}

$resultado = array(
    "iTotalRecords"     => $totalDatos,
    "iTotalDisplayRecords"  => $totalDatos,
    "aaData"        => $row,
);

echo json_encode($resultado);