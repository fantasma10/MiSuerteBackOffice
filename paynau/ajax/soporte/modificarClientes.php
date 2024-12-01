<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$idProveedor    = !empty($_POST["nIdProveedor"]    ? $_POST["nIdProveedor"]    : 0);
$nIdContacto    = !empty($_POST['nIdContacto'])     ? $_POST['nIdContacto']     : 0;
$nIdCollect     = !empty($_POST['nIdCollect'])     ? $_POST['nIdCollect']     : 0;
$estatus        = !empty($_POST['estatus'])     ? $_POST['estatus']     : 0;
$nombre         = !empty($_POST['sNombre'])   ? trim($_POST['sNombre'])     : "";
$apellidoM      = !empty($_POST['appellidoM'])  ? $_POST['appellidoM']      : "";
$apellidoP      = !empty($_POST['apellidoP'])  ? $_POST['apellidoP']    : "";
$sCorreo        = !empty($_POST['sCorreo'])       ? $_POST['sCorreo']     : "";
$sCelular       = !empty($_POST['sCelular'])       ? $_POST['sCelular']     : "";
$sTelefono      = !empty($_POST['sTelefono'])    ? $_POST['sTelefono']      : 0;
$nListaGrupos   = !empty($_POST['nListaGrupos'])    ? $_POST['nListaGrupos']      : 0;

if (isset($idProveedor)) {
    
    $array_params = array(
            array('name' => "PO_nIdContacto",'value' => $nIdContacto,'type' => "i"),
            array('name' => "PO_nIdEstatus",'value' => $estatus,'type' => "i"),
            array('name' => "PO_nIdProveedor",'value' => $idProveedor,'type' => "i"),
            array('name' => "PO_nIdCollect",'value' => $nIdCollect,'type' => "s"),
            array('name' => "PO_sNombre",'value' => $nombre,'type' => "s"),
            array('name' => "PO_sApellidoPaterno",'value' => $apellidoP,'type' => "s"),
            array('name' => "PO_sApellidoMaterno",'value' => $apellidoM,'type' => "s"),
            array('name' => "PO_sCorreo",'value' => $sCorreo,'type' => "s"),
            array('name' => "PO_sCelular",'value' => $sCelular,'type' => "s"),
            array('name' => "PO_sTelefono",'value' => $sTelefono,'type' => "s"),
            array('name' => "PO_nIdGrupo",'value' => $nListaGrupos,'type' => "i")
        
    );
    $oWDPN->setSDataBase('paycash_one');
    $oWDPN->setSStoredProcedure('sp_update_contacto');
    $oWDPN->setParams($array_params);
    
    $result = $oWDPN->execute();
    $data = $oWDPN->fetchAll();
    $data = utf8ize($data);
    $oWDPN->closeStmt();
    $response = array(
        "Exito" => true,
        "Codigo" => 0,
        "Mensaje" =>"Registo actualizado correctamente",
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
