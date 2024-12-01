<?php

include($_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/customFunctions.php");

$tipo = !empty($_POST["tipo"]) ? $_POST["tipo"] : 0;
$tipoGet = $_GET["method"];

$idTipoContactoComercio = (!empty($_POST["idContactoComercio"])) ? $_POST["idContactoComercio"] : 0;
$idTipoContacto = (!empty($_POST["idTipoContacto"])) ? $_POST["idTipoContacto"] : "";
$idComercio = (!empty($_POST["idComercio"])) ? $_POST["idComercio"] : "";
$sNombre = (!empty($_POST["sNombre"])) ? $_POST["sNombre"] : "";
$sApellidoP = (!empty($_POST["sApellidoP"])) ? $_POST["sApellidoP"] : "";
$sApellidoM = (!empty($_POST["sApellidoM"])) ? $_POST["sApellidoM"] : "";
$sCorreo = (!empty($_POST["sCorreo"])) ? $_POST["sCorreo"] : "";
$sContrasenia = (!empty($_POST["sContrasenia"])) ? $_POST["sContrasenia"] : "";
$nActivo = (!empty($_POST["nActivo"])) ? $_POST["nActivo"] : 0;

$Parametros = array(
    array('name' => 'idComercio', 'value' => $idComercio, 'type' => 'i'),
    array('name' => 'idTipoContacto', 'value' => $idTipoContacto, 'type' => 'i'),
    array('name' => 'sNombre', 'value' => $sNombre, 'type' => 's'),
    array('name' => 'sApellidoP', 'value' => $sApellidoP, 'type' => 's'),
    array('name' => 'sApellidoM', 'value' => $sApellidoM, 'type' => 's'),
    array('name' => 'sCorreo', 'value' => $sCorreo, 'type' => 's'),
    array('name' => 'sContrasenia', 'value' => $sContrasenia, 'type' => 's')
);
//    print_r($Parametros);
switch ($tipo) {
    // tipo = 1 = consulta de todos los parametros dados de alta
    case 1:
        $Params = array(
            array('name' => 'nTipoContactoComercio', 'value' => $idTipoContactoComercio, 'type' => 'i'),
            array('name' => 'nActivo', 'value' => $nActivo, 'type' => 'i'),
        );
        $oRDRP->setSDatabase('repay');
        $oRDRP->setSStoredProcedure('sp_select_contacto_comercio');
        $oRDRP->setParams($Params);
        $result = $oRDRP->execute();
        if ($result['nCodigo'] == 0) {
            $data = $oRDRP->fetchAll();
            if (count($data) > 0 && $data[0]["errorCode"] == 0) {
                $resultado = array("oCodigo" => $result["nCodigo"], "sMensaje" => $result["sMensaje"], "Data" => $data
                );
            } else {
                $resultado = array("oCodigo" => 1, "sMensaje" => "no se encontraron registros", "Data" => ""
                );
            }
        } else {
            $resultado = array(
                "oCodigo" => 1,
                "sMensaje" => "ha ocurrido un error, comunicate con el administrador",
                "Data" => ""
            );
        }
        echo json_encode($resultado);
        break;

    // tipo = 2 = Guardar un parametro    
    case 2:
        $oWDMP->setSDatabase('repay');
        $oWDMP->setSStoredProcedure('sp_insert_contacto_comercio');
        $oWDMP->setParams($Parametros);
        $result = $oWDMP->execute();
        if ($result['nCodigo'] == 0) {
            $data = $oWDMP->fetchAll();
            if (count($data) > 0 && $data[0]["errorCode"] == 0) {
                $resultado = array("oCodigo" => $result["nCodigo"], "sMensaje" => $result["sMensaje"], "Data" => $data);
            } else {
                $resultado = array("oCodigo" => $data[0]["errorCode"], "sMensaje" => $data[0]["errorMsg"], "Data" => "");
            }
        } else {
            $resultado = array(
                "oCodigo" => 1,
                "sMensaje" => "ha ocurrido un error, comunicate con el administrador",
                "Data" => ""
            );
        }
        echo json_encode($resultado);
        break;

    // tipo = 3 = editar un parametro
    case 3:

        $Param = array(
            array('name' => 'tipo', 'value' => 1, 'type' => 'i'),
            array('name' => 'nTipoContactoComercio', 'value' => $idTipoContactoComercio, 'type' => 'i'),
            array('name' => 'nActivo', 'value' => $nActivo, 'type' => 'i')
        );
        $Params = array_merge($Param, $Parametros);
        $oWDMP->setSDataBase('repay');
        $oWDMP->setSStoredProcedure('sp_update_contacto_comercio');
        $oWDMP->setParams($Params);
        $result = $oWDMP->execute();
        if ($result['nCodigo'] == 0) {
            $data = $oWDMP->fetchAll();
            if (count($data) > 0) {
                $resultado = array("oCodigo" => $result["nCodigo"], "sMensaje" => $result["sMensaje"], "Data" => $data);
            } else {
                $resultado = array("oCodigo" => $result["nCodigo"], "sMensaje" => $result["sMensaje"], "Data" => "");
            }
        } else {
            $resultado = array(
                "oCodigo" => 1,
                "sMensaje" => "ha ocurrido un error, comunicate con el administrador",
                "data" => ""
            );
        }
        echo json_encode($resultado);
        break;

    // tipo = 4 = activar o desactivar un registro de la tabla de parametros   
    case 4:

        $Param = array(
            array('name' => 'tipo', 'value' => 2, 'type' => 'i'),
            array('name' => 'nTipoContactoComercio', 'value' => $idTipoContactoComercio, 'type' => 'i'),
            array('name' => 'nActivo', 'value' => $nActivo, 'type' => 'i')
        );
        $Params = array_merge($Param, $Parametros);
        $oWDMP->setSDataBase('repay');
        $oWDMP->setSStoredProcedure('sp_update_contacto_comercio');
        $oWDMP->setParams($Params);
        $result = $oWDMP->execute();
        if ($result['nCodigo'] == 0) {
            $data = $oWDMP->fetchAll();
            $data = utf8ize($data);
            if (count($data) > 0) {
                $resultado = array("oCodigo" => $result["nCodigo"], "sMensaje" => $result["sMensaje"], "Data" => $data);
            } else {
                $resultado = array("oCodigo" => $result["nCodigo"], "sMensaje" => $result["sMensaje"], "Data" => "");
            }
        } else {
            $resultado = array(
                "oCodigo" => 1,
                "sMensaje" => "ha ocurrido un error, comunicate con el administrador",
                "data" => ""
            );
        }
        echo json_encode($resultado);

        break;

    // tipo = 5 = Seleccionar los tipos de comercios para listarlos en un combo
    case 5:
        $Params = array(
            array('name' => 'nIdComercio', 'value' => 0, 'type' => 'i'),
            array('name' => 'nActivo', 'value' => 0, 'type' => 'i'),
        );
        $oWDMP->setSDataBase('repay');
        $oWDMP->setSStoredProcedure('sp_select_comercio');
        $oWDMP->setParams($Params);
        $result = $oWDMP->execute();
        if ($result['nCodigo'] == 0) {
            $data = $oWDMP->fetchAll();
            $data = utf8ize($data);
            if (count($data) > 0) {
                $resultado = array("oCodigo" => $result["nCodigo"], "sMensaje" => $result["sMensaje"], "Data" => $data);
            } else {
                $resultado = array("oCodigo" => $result["nCodigo"], "sMensaje" => $result["sMensaje"], "Data" => "");
            }
        } else {
            $resultado = array("oCodigo" => 1, "sMensaje" => "ha ocurrido un error, comunicate con el administrador", "data" => "");
        }
        echo json_encode($resultado);
        break;
    // tipo = 6 = Seleccionar los tipos de contacto para listarlos en un combo
    case 6:
        $Params = array(
            array('name' => 'nIdTipoContacto', 'value' => 0, 'type' => 'i'),
            array('name' => 'nActivo', 'value' => 0, 'type' => 'i')
        );
        $oRDRP->setSDataBase('repay');
        $oRDRP->setSStoredProcedure('sp_select_tipo_contacto');
        $oRDRP->setParams($Params);
        $result = $oRDRP->execute();
        if ($result['oCodigo'] == 0) {
            $data = $oRDRP->fetchAll();
            if (count($data) > 0) {
                $resultado = array("oCodigo" => $result['nCodigo'], "sMensaje" => $result['sMensaje'], "Data" => $data);
            } else {
                $resultado = array("oCodigo" => $result['nCodigo'], "sMensaje" => $result['sMensaje'], "Data" => "");
            }
        } else {
            $resultado = array("oCodigo" => 1, "sMensaje" => "ha ocurrido un error, comunicate con el administrador", "data" => "");
        }
        echo json_encode($resultado);
        break;

    default:
        # code...
        $resultado = array("oCodigo" => 1, "sMemsaje" => "Opcion invalida");
        echo json_encode($resultado);
        break;
}