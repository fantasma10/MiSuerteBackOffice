<?php
    ini_set("soap.wsdl_cache_enabled", "0");
    include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSFacturacion.php");

    $servicios = $_POST['servicios'];
    $datos = array();
	$idUnidadNegocio = array('Id' => 0);

    foreach($servicios as $servicio) {
        $getMetodo = "Get{$servicio}";
        $getResultado = "Get{$servicio}Result";

        if ($servicio == 'CatRegimenFiscal') {
            $servicio = 'RegimenFiscal';
        }

        $obtenerServicio = $client->$getMetodo($idUnidadNegocio);
        $obtenerResultados = $obtenerServicio->$getResultado->$servicio;

        $datos[$servicio] = $obtenerResultados;
    }

    echo json_encode($datos);
