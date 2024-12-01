<?php
ini_set("soap.wsdl_cache_enabled", "0");
//include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
//include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
//include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSFacturacion.php");

$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;
switch ($tipo) {
	case 1:
		$idUnidadNegocio = array('Id' => 0);
		$result = $client->GetUsoCFDI($idUnidadNegocio);
		$array = array($result);
		$cfdi = $array[0]->GetUsoCFDIResult->UsoCFDI;	
		$totalDatos = count($cfdi);

		if($totalDatos == 1){	//esto para convertir el objeto en un arrglo en caso de ser tamaño 1 
			$cfdi = array($cfdi);
		}

		$datos = array();
		for ($i=0; $i <$totalDatos; $i++) { 
			$array = array();
			$array["strUsoCFDI"] = $cfdi[$i]->strUsoCFDI;
			$array["strDescripcion"] = $cfdi[$i]->strDescripcion;
			$array["nIdUsoCFDI"] = $cfdi[$i]->nIdUsoCFDI; 
			$datos[] = $array;
		}
	    echo json_encode($datos);		
		break;

	case 2:
		$idUnidadNegocio = array('Id' => 0);
		$result = $client->GetFormaPago($idUnidadNegocio);
		$array = array($result);
		$forma_pago = ($array[0]->GetFormaPagoResult->FormaPago);
		$totalDatos = count($forma_pago);

		if($totalDatos == 1){	//esto para convertir el objeto en un arrglo en caso de ser tamaño 1 
			$forma_pago = array($forma_pago);
		}

		$datos = array();
		for ($i=0; $i <$totalDatos; $i++) { 
			$array = array();
			$array["strFormaPago"] = $forma_pago[$i]->strFormaPago;
			$array["strDescripcion"] = $forma_pago[$i]->strDescripcion;
			$array["nIdFormaPago"] = $forma_pago[$i]->nIdFormaPago; 
			$datos[] = $array;
		}
	    echo json_encode($datos);
		break;

	case 3:
		$idUnidadNegocio = array('Id' => 0);
		$result = $client->GetMetodoPago($idUnidadNegocio);
		$array = array($result);
		$metodo_pago = $array[0]->GetMetodoPagoResult->MetodoPago;
		$totalDatos = count($metodo_pago);

		if($totalDatos == 1){	//esto para convertir el objeto en un arrglo en caso de ser tamaño 1 
			$metodo_pago = array($metodo_pago);
		}

		$datos = array();
		for ($i=0; $i <$totalDatos; $i++) { 
			$array = array();
			$array["strMetodoPago"] = $metodo_pago[$i]->strMetodoPago;
			$array["strDescripcion"] = $metodo_pago[$i]->strDescripcion;
			$array["nIdMetodoPago"] = $metodo_pago[$i]->nIdMetodoPago; 
			$datos[] = $array;
		}
	    echo json_encode($datos);
		break;

	case 4:
		$idUnidadNegocio = array('Id' => 1);
		$result = $client->GetProductoServicio($idUnidadNegocio);
		$array = array($result);
		$producto_servicio = $array[0]->GetProductoServicioResult->ProductoServicio;
		$totalDatos = count($producto_servicio);

		if($totalDatos == 1){	//esto para convertir el objeto en un arrglo en caso de ser tamaño 1 
			$producto_servicio = array($producto_servicio);
		}

		$datos = array();
		for ($i=0; $i <$totalDatos; $i++) { 
			$array = array();
			$array["strClaveProducto"] = $producto_servicio[$i]->strClaveProducto;
			$array["strDescripcion"] = $producto_servicio[$i]->strDescripcion;
			$array["nIdClaveProducto"] = $producto_servicio[$i]->nIdClaveProducto; 
			$datos[] = $array;
		}
	    echo json_encode($datos);
		break;

	case 5:
		$idUnidadNegocio = array('Id' => 1);
		$result = $client->GetUnidad($idUnidadNegocio);
		$array = array($result);
		$unidad = $array[0]->GetUnidadResult->Unidad;
		$totalDatos = count($unidad);

		if($totalDatos == 1){	//esto para convertir el objeto en un arrglo en caso de ser tamaño 1 
			$unidad = array($unidad);
		}

		$datos = array();
		for ($i=0; $i <$totalDatos; $i++) { 
			$array = array();
			$array["strUnidad"] = $unidad[$i]->strUnidad;
			$array["strDescripcion"] = $unidad[$i]->strDescripcion;
			$array["nIdUnidad"] = $unidad[$i]->nIdUnidad; 
			$datos[] = $array;
		}
	    echo json_encode($datos);
	    break;
	case 6:
		$idUnidadNegocio = array('Id' => 0);
		$result = $client->GetCatRegimenFiscal($idUnidadNegocio);
		$array = array($result);
		$regimenFiscal = $array[0]->GetCatRegimenFiscalResult->RegimenFiscal;
		$totalDatos = count($regimenFiscal);

		if($totalDatos == 1){	//esto para convertir el objeto en un arrglo en caso de ser tamaño 1 
			$regimenFiscal = array($regimenFiscal);
		}

		$datos = array();
		for ($i=0; $i <$totalDatos; $i++) { 
			$array = array();
			$array["strRegimenFiscal"] = $regimenFiscal[$i]->strRegimenFiscal;
			$array["strDescripcion"] = $regimenFiscal[$i]->strDescripcion;
			$array["nIdRegimenFiscal"] = $regimenFiscal[$i]->nIdRegimenFiscal; 
			$datos[] = $array;
		}
	    echo json_encode($datos);
	    break;
	default:
		# code...
		break;
}
?>