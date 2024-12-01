<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$idProveedor    = !empty($_POST["Proveedor"]    ? $_POST["Proveedor"]    : 0);
$nIdCollect     = !empty($_POST['Collect'])     ? $_POST['Collect']     : 0;
$nombre         = !empty($_POST['Nombre'])   ? trim($_POST['Nombre'])     : "";
$apellidoM      = !empty($_POST['ApellidoM'])  ? $_POST['ApellidoM']    : "";
$apellidoP       = !empty($_POST['ApellidoP'])  ? $_POST['ApellidoP']      : "";
$sCorreo        = !empty($_POST['Correo'])       ? $_POST['Correo']     : "";
$sCelular       = !empty($_POST['Celular'])       ? $_POST['Celular']     : "";
$sTelefono      = !empty($_POST['sTelefono'])    ? $_POST['sTelefono']      : 0;
$nListaGrupos   = !empty($_POST['ListaGrupos'])    ? $_POST['ListaGrupos']      : 0;
if (isset($idProveedor)) {
    
    $array_params = array(
            array('name' => "PO_nIdProveedor",'value' => $idProveedor,'type' => "i"),
            array('name' => "PO_nIdCollect",'value' => $nIdCollect,'type' => "i"),
            array('name' => "PO_sNombre",'value' => $nombre,'type' => "s"),
            array('name' => "PO_sApellidoPaterno",'value' => $apellidoP,'type' => "s"),
            array('name' => "PO_sApellidoMaterno",'value' => $apellidoM,'type' => "s"),
            array('name' => "PO_sCorreo",'value' => $sCorreo,'type' => "s"),
            array('name' => "PO_sCelular",'value' => $sCelular,'type' => "s"),
            array('name' => "PO_sTelefono",'value' => $sTelefono,'type' => "s"),
            array('name' => "PO_nIdGrupo",'value' => $nListaGrupos,'type' => "i")
        
    );
    $oWDPN->setSDataBase('paycash_one');
    $oWDPN->setSStoredProcedure('sp_insert_contacto');
    $oWDPN->setParams($array_params);
    
    $result = $oWDPN->execute();
    $data = $oWDPN->fetchAll();
    $data = utf8ize($data);
    $oWDPN->closeStmt();
    $response = array(
        "Exito" => true,
        "Codigo" => 0,
        "Mensaje" =>"Registo agregado correctamente",
        "Data" => $data
    );
    echo json_encode($response);
}else{
    $response = array(
        "Exito" => false,
        "Codigo" => 1,
        "Mensaje" =>"Ocurrio un error, veulva a intentar mas tarde",
    );
    echo json_encode($response);
}

?>
