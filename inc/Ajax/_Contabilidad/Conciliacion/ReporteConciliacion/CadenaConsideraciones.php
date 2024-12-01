<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    // include('../../../../config.inc.php');
    // include('../../../../obj/CadenaConsideracionesReporte.class.php');
    // //include('./obj/CadenaConsideracionesReporte.class.php');

    include($_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php");
    //include($_SERVER['DOCUMENT_ROOT'] . "/inc/obj/CadenaConsideracionesReporte.class.php");


   // echo '<pre>'; echo var_dump($_SERVER['DOCUMENT_ROOT']); echo '</pre>';

    // // // Inicializamos Base de datos de Lectura Y Escritura
    // // $RBD = new database($LOG, "READ", $R_SERVER, $R_USER, $R_PASS, $R_DATABASE, $R_PORT);
    // // $WBD = new database($LOG, "WRITE", $W_SERVER, $W_USER, $W_PASS, $W_DATABASE, $W_PORT);

    $oReporte = new CadenaConsideracionesReporte();
    $oReporte->setORdb($oRdb);
	$oReporte->setNIdCadena($_POST["nIdCadena"]);

	$resultado = $oReporte->sp_select_consideracion_cadena();

	$_resultado = $resultado['data'];

    echo json_encode($_resultado);
?> 