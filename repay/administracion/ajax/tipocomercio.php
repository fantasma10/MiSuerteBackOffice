<?php

include($_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/customFunctions.php");

$tipo = !empty($_POST["tipo"]) ? $_POST["tipo"] : 0;
$tipoGet = $_GET["method"];

$idTipoComercio = (!empty($_POST["nTipoComercio"])) ? $_POST["nTipoComercio"] : 0;
$sTipocomercio = (!empty($_POST["nombreTipocomercio"])) ? $_POST["nombreTipocomercio"] : "";
$nActivo = (!empty($_POST["nActivo"])) ? $_POST["nActivo"] : 0;

$Parametros = array(
    array('name' => 'idTipoComercio', 'value' => $idTipoComercio, 'type' => 'i'),
    array('name' => 'Descripcion', 'value' => $sTipocomercio, 'type' => 's'),
    array('name' => 'nActivo', 'value' => $nActivo, 'type' => 'i')
);

switch ($tipo) {
    // tipo = 1 = consulta de todos los tipos de comercios registrados
    case 1:
        $Params = array(
            array('name' => 'nActivo', 'value' => 0, 'type' => 'i')
        );
        $oRDRP->setSDatabase('repay');
        $oRDRP->setSStoredProcedure('sp_select_tipo_comercio');
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

    // tipo = 2 = Guardar tipo de comercio    
    case 2:
        $Param = array(array('name' => 'sTipocomercio', 'value' => $sTipocomercio, 'type' => 's'));
        $oWDMP->setSDatabase('repay');
        $oWDMP->setSStoredProcedure('sp_insert_tipo_comercio');
        $oWDMP->setParams($Param);
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
        $Param = array(array('name' => 'tipo', 'value' => 1, 'type' => 'i'));
        $Params = array_merge($Param, $Parametros);
        $oWDMP->setSDataBase('repay');
        $oWDMP->setSStoredProcedure('sp_update_tipo_comercio');
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
        $Param = array(array('name' => 'tipo', 'value' => 2, 'type' => 'i'));
        $Params = array_merge($Param, $Parametros);
        $oWDMP->setSDataBase('repay');
        $oWDMP->setSStoredProcedure('sp_update_tipo_comercio');
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