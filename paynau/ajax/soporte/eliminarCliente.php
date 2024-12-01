<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$idProveedor    = (!empty($_POST["nIdProveedor"]    ? $_POST["nIdProveedor"]    : 0));
$nIdContacto    = !empty($_POST['nIdContacto'])     ? $_POST['nIdContacto']     : 0;

if (isset($idProveedor)) {
    
    $array_params = array(
            array('name' => "PO_nIdProveedor",'value' => $idProveedor,'type' => "i"),
            array('name' => "PO_nIdContacto",'value' => $nIdContacto,'type' => "i")
    );
    
    $oWDPN->setSDataBase('paycash_one');
    $oWDPN->setSStoredProcedure('sp_delete_contacto');
    $oWDPN->setParams($array_params);
    
    $result = $oWDPN->execute();
    $data = $oWDPN->fetchAll();
    $data = utf8ize($data);
    $oWDPN->closeStmt();
    $response = array(
        "Exito" => true,
        "Codigo" => 0,
        "Mensaje" =>"Registo Eliminado correctamente",
        "Data" => $data
    );
    echo json_encode($response);
}else{
    $response = array(
        "Exito" => false,
        "Codigo" => 1,
        "Mensaje" =>"Ha ocurrido un error",
    );
    echo json_encode($response);
}

?>
