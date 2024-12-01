<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

if ($_POST) {
    
    $array_params = array(
            array(
                    'name'	=> 'p_nIdMetodpago',
                    'type'	=> 'i',
                    'value'	=> $_POST['idProveedor']
            ),
            array(
                    'name'	=> 'p_dFechaInicio',
                    'type'	=> 's',
                    'value'	=> $_POST['dFechaInicio']
            ),
            array(
                    'name'	=> 'p_dFechaFin',
                    'type'	=> 's',
                    'value'	=> $_POST['dFechaFin']
            )
    );
    $oRDPN->setSDatabase('paycash_one');
    $oRDPN->setSStoredProcedure('sp_select_detalle_liquidacion_pagos');
    $oRDPN->setParams($array_params);
    
    $result = $oRDPN->execute();
    $data = $oRDPN->fetchAll();
    $oRDPN->closeStmt();
    $oReporte = utf8ize($data);
    
    $result = array(
        'Exito' =>true,
        'Codigo' => 0,
        'Mensaje' => "Consulta Exitosa",
        'Data' => $oReporte
    );  
    echo json_encode($result);
    
}else{
    $result = array(
        'Exito' =>true,
        'Codigo' => 0,
        'Mensaje' => "Faltan parametros",
        'Data' => ''
    );  
    echo json_encode($result);
}
?>