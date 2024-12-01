<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    // include('../../../../config.inc.php');
    // include('../../../../obj/ConciliacionReporteHistorial.class.php');

    include($_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php");
    //include($_SERVER['DOCUMENT_ROOT'] . "/inc/obj/ConciliacionReporteHistorial.class.php");

    // include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
    // include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");

    // // Inicializamos Base de datos de Lectura Y Escritura
    // $RBD = new database($LOG, "READ", $R_SERVER, $R_USER, $R_PASS, $R_DATABASE, $R_PORT);
    // $WBD = new database($LOG, "WRITE", $W_SERVER, $W_USER, $W_PASS, $W_DATABASE, $W_PORT);

    $oReporte = new ConciliacionReporteHistorial();
    $oReporte->setORdb($oRdb);
	$oReporte->setNIdCadena($_POST["nIdCadena"]);
    $oReporte->setSFecha($_POST["sFecha"]);
    $oReporte->setNAccion($_POST["nAccion"]);

	$resultado = $oReporte->sp_select_bitacora_conciliacion();

	$_resultado = $resultado['data'];

    echo json_encode($_resultado);
?>