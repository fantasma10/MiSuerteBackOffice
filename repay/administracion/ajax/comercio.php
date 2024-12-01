<?php

include($_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/customFunctions.php");

$tipo = !empty($_POST["tipo"]) ? $_POST["tipo"] : 0;
$tipoGet = $_GET["method"];

$idComercio = (!empty($_POST["nComercio"])) ? $_POST["nComercio"] : 0;
$idTipoComercio = (!empty($_POST["cmbTipoComercio"])) ? $_POST["cmbTipoComercio"] : 0;
$nombreComercio = (!empty($_POST["nombreComercio"])) ? $_POST["nombreComercio"] : "";
$razonSocial = (!empty($_POST["razonSocial"])) ? $_POST["razonSocial"] : "";
$sRFC = (!empty($_POST["RFC"])) ? $_POST["RFC"] : "";
$nActivo = (!empty($_POST["nActivo"])) ? $_POST["nActivo"] : 0;

$Parametros = array(
    array('name' => 'idTipoComercio', 'value' => $idTipoComercio, 'type' => 'i'),
    array('name' => 'nombreComercio', 'value' => $nombreComercio, 'type' => 's'),
    array('name' => 'razonSocial', 'value' => $razonSocial, 'type' => 's'),
    array('name' => 'RFC', 'value' => $sRFC, 'type' => 's'),
);

switch ($tipo) {
    // tipo = 1 = consulta de todos los tipos de comercios registrados
    case 1:
        $Params = array(
            array('name' => 'nIdComercio', 'value' => 0, 'type' => 'i'),
            array('name' => 'nActivo', 'value' => 0, 'type' => 'i'),
        );
        $oRDRP->setSDatabase('repay');
        $oRDRP->setSStoredProcedure('sp_select_comercio');
        $oRDRP->setParams($Params);
        $result = $oRDRP->execute();

        if ($result['nCodigo'] == 0) {
            $data = $oRDRP->fetchAll();
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

    // tipo = 2 = Guardar tipo de comercio    
    case 2:
        $oWDMP->setSDatabase('repay');
        $oWDMP->setSStoredProcedure('sp_insert_comercio');
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

    // tipo = 3 = editar Tipos de comercio
    case 3:

        $Param = array(
            array('name' => 'tipo', 'value' => 1, 'type' => 'i'),
            array('name' => 'nIdComercio', 'value' => $idComercio, 'type' => 'i')
        );
        $activo = array(array('name' => 'activo', 'value' => $nActivo, 'type' => 'i'));
        $Params = array_merge($Param, $Parametros);
        $Params = array_merge($Params, $activo);
        $oWDMP->setSDataBase('repay');
        $oWDMP->setSStoredProcedure('sp_update_comercio');
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

    // tipo = 4 = activar o desactivar un tipo de comercio   
    case 4:

        $Param = array(
            array('name' => 'tipo', 'value' => 2, 'type' => 'i'),
            array('name' => 'nIdComercio', 'value' => $idComercio, 'type' => 'i')
        );
        $activo = array(array('name' => 'activo', 'value' => $nActivo, 'type' => 'i'));
        $Params = array_merge($Param, $Parametros);
        $Params = array_merge($Params, $activo);
        $oWDMP->setSDataBase('repay');
        $oWDMP->setSStoredProcedure('sp_update_comercio');
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
            array('name' => 'nActivo', 'value' => 0, 'type' => 'i'),
        );
        $oWDMP->setSDataBase('repay');
        $oWDMP->setSStoredProcedure('sp_select_tipo_comercio');
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

    case 6:
        $Params = array(
            array('name' => 'nIdComercio', 'value' => $idComercio, 'type' => 'i'),
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