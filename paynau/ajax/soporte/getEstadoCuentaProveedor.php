<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$idProveedor = (!empty($_POST["nIdProveedor"]) ? $_POST["nIdProveedor"] : 0);
$fechaIni    = (!empty($_POST["dFechaIni"])? $_POST["dFechaIni"] : '0000-00-00');
$fechaFin    = (!empty($_POST["dFechafin"])? $_POST["dFechafin"] : '0000-00-00');
if (isset($idProveedor)) {
    
    $array_params = array(
            array(
                'name' => "idProveedor",
                'value' => $idProveedor,
                'type' => "i"
            ),
            array(
                'name' => "dFechaInicio",
                'value' => $fechaIni,
                'type' => "s"
            ),
            array(
                'name' => "dFechafinal",
                'value' => $fechaFin,
                'type' => "s"
            ),
    );
    $oRDPN->setSDataBase('paycash_one');
    $oRDPN->setSStoredProcedure('sp_select_estado_cuenta_proveedor');
    $oRDPN->setParams($array_params);
    
    $result = $oRDPN->execute();
    $data = $oRDPN->fetchAll();
    $data = utf8ize($data);
    $oRDPN->closeStmt();
    $saldoPendiente;
    $saldoActual;
    foreach ($data as $val) {
        $saldoPendiente += $val["nCargo"];
        $saldoActual = array_pop($val);
    }
    $saldoFinal = $saldoActual - $saldoPendiente;
    $response = array(
        "Exito" => 0,
        "Mensaje" =>"consulta exitosa",
        "Data" => $data,
        "SaldoActual" => number_format($saldoActual, 4, '.', ''),
        "SaldoPendiente" => number_format($saldoPendiente, 4),
        "Saldofinal" => number_format($saldoFinal, 4, '.', '')
    );
    echo json_encode($response);
}

?>
