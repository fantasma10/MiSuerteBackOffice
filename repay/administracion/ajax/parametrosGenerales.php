<?php

include($_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/customFunctions.php");

$tipo = !empty($_POST["tipo"]) ? $_POST["tipo"] : 0;
$tipoGet = $_GET["method"];

$nIdParametro = (!empty($_POST["nParametro"])) ? $_POST["nParametro"] : 0;
$sNombreProceso = (!empty($_POST["sNombreProceso"])) ? $_POST["sNombreProceso"] : "";
$sReferencia = (!empty($_POST["sReferencia"])) ? $_POST["sReferencia"] : "";
$sParametro = (!empty($_POST["sParametro"])) ? $_POST["sParametro"] : "";
$sTipoDato = (!empty($_POST["sTipoDato"])) ? $_POST["sTipoDato"] : "";
$sValorObligatorio = (!empty($_POST["sValorObligado"])) ? $_POST["sValorObligado"] : 0;
$sValor = (!empty($_POST["sValor"])) ? $_POST["sValor"] : "";
$sComentarios = (!empty($_POST["sComentarios"])) ? $_POST["sComentarios"] : "";
$nActivo = (!empty($_POST["nActivo"])) ? $_POST["nActivo"] : 0;
//API KEY
//UserCode
//Encryption Key
$Parametros = array(
    array('name' => 'sNombreProceso', 'value' => $sNombreProceso, 'type' => 's'),
    array('name' => 'sReferencia', 'value' => $sReferencia, 'type' => 's'),
    array('name' => 'sParametro', 'value' => $sParametro, 'type' => 's'),
    array('name' => 'sTipoDato', 'value' => $sTipoDato, 'type' => 's'),
    array('name' => 'sValorObligado', 'value' => $sValorObligatorio, 'type' => 'i'),
    array('name' => 'sValor', 'value' => $sValor, 'type' => 's'),
    array('name' => 'sComentarios', 'value' => $sComentarios, 'type' => 's')
);
switch ($tipo) {
    // tipo = 1 = consulta de todos los parametros dados de alta
    case 1:
        $Params = array(
            array('name' => 'nParametro', 'value' => $nIdParametro, 'type' => 'i'),
            array('name' => 'nActivo', 'value' => $nActivo, 'type' => 'i'),
        );
        $oRDRP->setSDatabase('repay');
        $oRDRP->setSStoredProcedure('sp_select_parametros_generales');
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
        $oWDMP->setSStoredProcedure('sp_insert_parametros_generales');
        $oWDMP->setParams($Parametros);
        $result = $oWDMP->execute();
        if ($result['nCodigo'] == 0) {
            $data = $oWDMP->fetchAll();
            if (count($data) > 0 && $data[0]["errorCode"] == 0) {
                $resultado = array("oCodigo" => $result["nCodigo"], "sMensaje" => $result["sMensaje"], "Data" => $data);
            } else {
                $resultado = array("oCodigo" => 1, "sMensaje" => "no se encontraron registros", "Data" => "");
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
            array('name' => 'idParametro', 'value' => $nIdParametro, 'type' => 'i'),
            array('name' => 'nActivo', 'value' => $nActivo, 'type' => 'i')
        );
        $Params = array_merge($Param, $Parametros);
        $oWDMP->setSDataBase('repay');
        $oWDMP->setSStoredProcedure('sp_update_parametros_generales');
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
            array('name' => 'idParametro', 'value' => $nIdParametro, 'type' => 'i'),
            array('name' => 'nActivo', 'value' => $nActivo, 'type' => 'i')
        );
        $Params = array_merge($Param, $Parametros);
        $oWDMP->setSDataBase('repay');
        $oWDMP->setSStoredProcedure('sp_update_parametros_generales');
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

    default:
        # code...
        $resultado = array("oCodigo" => 1, "sMemsaje" => "Opcion invalida");
        echo json_encode($resultado);
        break;
}