<?php
$APP_ROOT_DIRECTORY = $_SERVER['DOCUMENT_ROOT'];

include($APP_ROOT_DIRECTORY."/inc/config.inc.php");
include($APP_ROOT_DIRECTORY."/inc/session.ajax.inc.php");

$nIdCliente = $_POST['nIdCliente'];
$nEstatus   = $_POST['nEstatus'];
$nIdUsuario = $_SESSION["idU"];

if ((is_null($nIdCliente) || $nIdCliente == '') || (is_null($nEstatus) || $nEstatus == '')) {
    $result = array(
        'bExito' => false,
        'nCodigo' => 999,
        'sMensaje' => 'Error',
        'sMensajeDetallado' => 'No se puedo realizar el cambio de estatus'
    );
} else {
    $array_params = array(
        array('name' => 'CknIdCliente', 'value' => $nIdCliente, 'type' =>'i'),
        array('name' => 'CknEstatus', 'value' => $nEstatus, 'type' =>'i'),
        array('name' => 'CknIdUsuario', 'value' => $nIdUsuario, 'type' =>'i'),
    );

    $oWdb->setSDatabase('redefectiva');
    $oWdb->setSStoredProcedure('sp_update_cliente_estatus');
    $oWdb->setParams($array_params);
    $result = $oWdb->execute();
}

echo json_encode($result);