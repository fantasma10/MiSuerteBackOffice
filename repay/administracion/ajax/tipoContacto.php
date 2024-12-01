<?php

include($_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/customFunctions.php");

$tipo = !empty($_POST["tipo"]) ? $_POST["tipo"] : 0;
$tipoGet = $_GET["method"];

$nTipoContacto = (!empty($_POST["nTipoContacto"])) ? $_POST["nTipoContacto"] : 0;
$sNombre = (!empty($_POST["sNombre"])) ? $_POST["sNombre"] : "";
$nActivo = (!empty($_POST["nActivo"])) ? $_POST["nActivo"] : 0;

$Parametros = array(
    array('name' => 'sNombre', 'value' => $sNombre, 'type' => 's'),
);

switch ($tipo) {
    // tipo = 1 = Consulta de todos los tipos de contacto
    case 1:
        $Params = array(
            array('name' => 'nTipoContacto', 'value' => $idSucursal, 'type' => 'i'),
            array('name' => 'nActivo', 'value' => $nActivo, 'type' => 'i'),
        );
        $oRDRP->setSDatabase('repay');
        $oRDRP->setSStoredProcedure('sp_select_tipo_contacto');
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

    // tipo = 2 = Guardar un tipo de contacto    
    case 2:
        $oWDMP->setSDatabase('repay');
        $oWDMP->setSStoredProcedure('sp_insert_tipo_contacto');
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

    // tipo = 3 = editar un tipo de contacto
    case 3:
        $Param = array(
            array('name' => 'tipo', 'value' => 1, 'type' => 'i'),
            array('name' => 'idTipoContacto', 'value' => $nTipoContacto, 'type' => 'i'),
            array('name' => 'nActivo', 'value' => $nActivo, 'type' => 'i')
        );
        $Params = array_merge($Param, $Parametros);
        $oWDMP->setSDataBase('repay');
        $oWDMP->setSStoredProcedure('sp_update_tipo_contacto');
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

    // tipo = 4 = activar o desactivar un registro de la tabla de tipo de contacto
    case 4:

        $Param = array(
            array('name' => 'tipo', 'value' => 2, 'type' => 'i'),
            array('name' => 'idTipocontacto', 'value' => $nTipoContacto, 'type' => 'i'),
            array('name' => 'nActivo', 'value' => $nActivo, 'type' => 'i')
        );
        $Params = array_merge($Param, $Parametros);
        $oWDMP->setSDataBase('repay');
        $oWDMP->setSStoredProcedure('sp_update_tipo_contacto');
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