<?php
	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");
	include("../../../inc/lib/nusoap");	
	
	$oWebService = new WebService($WSDL3V);
	$clienteOK = $oWebService->createClient();
	$respuesta = array();
	if ($clienteOK) {
		$cliente = $oWebService->getClient();
		$parametros = array();
		$parametros["Usuario"] = $usuarioWS3V;
		$parametros["Pass"] = $passwordWS3V;
		try {
			$resultado = $cliente->Saldo($parametros);
			$mensaje = $resultado->SaldoResult->mensaje;
			$error = $resultado->SaldoResult->error;
			if ( !$error ) {
				$respuesta["codigo"] = 0;
				$respuesta["mensaje"] = $mensaje;
				$respuesta["error"] = $error;
			} else {
				$respuesta["codigo"] = 500;
				$respuesta["mensaje"] = $mensaje;
				$respuesta["error"] = $error;
			}
		} catch ( SoapFault $fault ) {
			$respuesta["codigo"] = 501;
			$respuesta["mensaje"] = $fault->getMessage();
		}
	}else{
		$respuesta["codigo"] = 502;
		$respuesta["mensaje"] = $oWebService->getClientError();
	}
	echo json_encode($respuesta);
?>