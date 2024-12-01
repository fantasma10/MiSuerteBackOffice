<?php

include($_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/customFunctions.php");

$tipo = !empty($_POST["tipo"]) ? $_POST["tipo"] : 0;
$tipoGet = $_GET["method"];

$idSucursal = (!empty($_POST["idSucursal"])) ? $_POST["idSucursal"] : 0;
$idComercio = (!empty($_POST["idComercio"])) ? $_POST["idComercio"] : "";
$sNombre = (!empty($_POST["sNombre"])) ? $_POST["sNombre"] : "";
$sPuntoReferencia = (!empty($_POST["puntoReferencia"])) ? $_POST["puntoReferencia"] : "";
$sCalle1 = (!empty($_POST["calle1"])) ? $_POST["calle1"] : "";
$sCalle2 = (!empty($_POST["calle2"])) ? $_POST["calle2"] : "";
$NumInterior = (!empty($_POST["nInterior"])) ? $_POST["nInterior"] : 0;
$NumExterior = (!empty($_POST["nExterior"])) ? $_POST["nExterior"] : 0;
$nLatitud = (!empty($_POST["latitud"])) ? $_POST["latitud"] : 0;
$nLongitud = (!empty($_POST["longitd"])) ? $_POST["longitd"] : 0;
$nLimiteSucursales = (!empty($_POST["limiteSucursales"])) ? $_POST["limiteSucursales"] : 0;
$nActivo = (!empty($_POST["nActivo"])) ? $_POST["nActivo"] : 0;

$Parametros = array(
    array('name' => 'idComercio', 'value' => $idComercio, 'type' => 'i'),
    array('name' => 'sNombre', 'value' => $sNombre, 'type' => 's'),
    array('name' => 'sPuntoReferencia', 'value' => $sPuntoReferencia, 'type' => 's'),
    array('name' => 'sCalle1', 'value' => $sCalle1, 'type' => 's'),
    array('name' => 'sCalle2', 'value' => $sCalle2, 'type' => 's'),
    array('name' => 'nNoInterior', 'value' => $NumInterior, 'type' => 'i'),
    array('name' => 'nNoExterior', 'value' => $NumExterior, 'type' => 'i'),
    array('name' => 'nLatitud', 'value' => $nLatitud, 'type' => 'i'),
    array('name' => 'nLongitud', 'value' => $nLongitud, 'type' => 'i'),
    array('name' => 'nLimiteSucursales', 'value' => $nLimiteSucursales, 'type' => 'i')
);
switch ($tipo) {
    // tipo = 1 = consulta de todas las sucursales dadas de alta
    case 1:
        $Params = array(
            array('name' => 'nSucursal', 'value' => $idSucursal, 'type' => 'i'),
            array('name' => 'nActivo', 'value' => $nActivo, 'type' => 'i'),
        );
        $oRDRP->setSDatabase('repay');
        $oRDRP->setSStoredProcedure('sp_select_sucursal');
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

    // tipo = 2 = Guardar la sucursal    
    case 2:
        $oWDMP->setSDatabase('repay');
        $oWDMP->setSStoredProcedure('sp_insert_sucursal');
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

    // tipo = 3 = editar una sucursal
    case 3:
        $Param = array(
            array('name' => 'tipo', 'value' => 1, 'type' => 'i'),
            array('name' => 'idSucursal', 'value' => $idSucursal, 'type' => 'i'),
            array('name' => 'nActivo', 'value' => $nActivo, 'type' => 'i')
        );
        $Params = array_merge($Param, $Parametros);
        $oWDMP->setSDataBase('repay');
        $oWDMP->setSStoredProcedure('sp_update_sucursal');
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
        $oWDMP->freeResult();
        echo json_encode($resultado);
        break;

    // tipo = 4 = activar o desactivar un registro de la tabla de sucursales   
    case 4:

        $Param = array(
            array('name' => 'tipo', 'value' => 2, 'type' => 'i'),
            array('name' => 'idParametro', 'value' => $idSucursal, 'type' => 'i'),
            array('name' => 'nActivo', 'value' => $nActivo, 'type' => 'i')
        );
        $Params = array_merge($Param, $Parametros);
        $oWDMP->setSDataBase('repay');
        $oWDMP->setSStoredProcedure('sp_update_sucursal');
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