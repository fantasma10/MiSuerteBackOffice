<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$data = array();

$params = $_POST;

if (!empty($params) && isset($params["fechaSolicitud"])) {
    
    $param = array(
        array(
            'name'	=> 'P_fecha',
            'type'	=> 's',
            'value'	=> $params["fechaSolicitud"]
        )
    );
    
    $oRDPN->setDataBase('paycash_one');
    $oRDPN->setSDatabase('paycash_one');
    $oRDPN->setSStoredProcedure('sp_select_planpago_reporte');
    $oRDPN->setParams($param);

    $result = $oRDPN->execute();
    $data = $oRDPN->fetchAll();
    $oRDPN->closeStmt();
    $data = utf8ize($data);
    
    $result = array(
        'Exito' =>true,
        'Codigo' => 0,
        'Mensaje' => "Consulta Exitosa",
        'Data' => $data
    );
    
    echo json_encode($result);
} else {
    $result = array(
        'Exito' =>false,
        'Codigo' => 1,
        'Mensaje' => "no hay parametros",
    );
    echo json_encode($result);
}


