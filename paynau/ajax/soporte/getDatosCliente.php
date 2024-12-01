<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$idProveedor    = !empty($_POST["nIdProveedor"])    ? $_POST["nIdProveedor"]    : 0;
$nIdContacto    = !empty($_POST['nIdContacto'])     ? $_POST['nIdContacto']     : 0;
$strBuscar      = !empty($_POST['strBuscar'])   ? trim($_POST['strBuscar'])     : "";
$sCorreo        = !empty($_POST['nContactos'])  ? $_POST['nContactos']      : "";
$sCelular       = !empty($_POST['nContactos'])  ? $_POST['nContactos']    : "";
$sTelefono      = !empty($_POST['total'])       ? $_POST['total']     : "";
$tipo           = !empty($_POST['tipo'])    ? $_POST['tipo']      : 0;
$start          = !empty($_POST['start'])   ? $_POST['start']     : 0;
$limit          = !empty($_POST['limit'])   ? $_POST['limit']     : 500;

if (isset($idProveedor)) {
    
    $array_params = array(
            array('name' => "idProveedor",'value' => $idProveedor,'type' => "i"),
            array('name' => "idContacto",'value' => $nIdContacto,'type' => "i"),
            array('name' => "sBuscar",'value' => $strBuscar,'type' => "s"),
            array('name' => "sCorreo",'value' => $sCorreo,'type' => "s"),
            array('name' => "sCelular",'value' => $sCelular,'type' => "s"),
            array('name' => "sTelefono",'value' => $sTelefono,'type' => "s"),
            array('name' => "grupo",'value' => $tipo,'type' => "i"),
            array('name' => "start",'value' => $start,'type' => "i"),
            array('name' => "limit",'value' => $limit,'type' => "i"),
        
    );
    $oRDPN->setSDataBase('paycash_one');
    $oRDPN->setSStoredProcedure('sp_select_contactos');
    $oRDPN->setParams($array_params);
    
    $result = $oRDPN->execute();
    $data = $oRDPN->fetchAll();
    $data = utf8ize($data);
    $oRDPN->closeStmt();
    $saldoPendiente;
    $saldoActual;

    $response = array(
        "Exito" => 0,
        "Mensaje" =>"consulta exitosa",
        "Data" => $data
    );
    echo json_encode($response);
}

?>
