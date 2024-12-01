<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
include($_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/customFunctions.php");

$nombre = $_POST["nombre"];

//$data = array("No se encontro ningún dato");
$error = array("error" => true);

if (isset($nombre)) {
    $array_params = array(
        array('name' => 'ck_sNombre', 'value' => $nombre, 'type' => 's'),
    );

    $oRdb->setSDatabase("redefectiva");
    $oRdb->setSStoredProcedure('sp_select_cadena_por_nombre');
    $oRdb->setParams($array_params);
    $result = $oRdb->execute();
    $data['data'] = array();
    if ($result['nCodigo'] == 0 || $result['bExito']==1) {
        $data['data'] =  $oRdb->fetchAll();
        $data['error'] = false;
        echo json_encode($data);
        return true;
    }
}
else{
    $data = array("Ocurrio un problema intentelo de nuevo");
    $error = array("error" => true);
}

array_push($data,$error);
echo json_encode($data);