<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$Proveedor      = !empty($_POST["idProveedor"]) ? $_POST["idProveedor"] : 0;
$Mesbusqueda    = !empty($_POST["mesBusqueda"]) ? $_POST["mesBusqueda"] :'0000-00-00';
    
if ($_POST["idProveedor"]) {
    
    $param = array(
        array(
            'name'	=> 'P_nidProveedor',
            'type'	=> 'i',
            'value'	=> $Proveedor
        ),
        array(
            'name'	=> 'P_fechaInicio',
            'type'	=> 's',
            'value'	=> $Mesbusqueda
        )
    );
    $oRDPN->setSDatabase('paycash_one');
    $oRDPN->setSStoredProcedure('sp_select_detalle_facturas');
    $oRDPN->setParams($param);
    
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
}
?>